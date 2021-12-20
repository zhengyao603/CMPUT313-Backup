#include <cnet.h>
#include <string.h>

// Definition of FRAME
typedef enum { DL_DISCOVER, DL_DISCOVER_ACK } FRAMEKIND;

typedef struct{
	char neighbour_name[32];
	CnetAddr neighbour_address;
	int neighbour_nlinks;
	int outgoing_costperbyte;
	int incoming_costperbyte;
} INFO;

typedef struct {
	FRAMEKIND kind;
	INFO info;
} FRAME;

//--------------------------------------------------
// 2D array records info of all the neighbours of each node
static INFO neighbour_info[33][34];

// 2D array records if i-th node receive discover ack on j-th link(1 or 0)
static int receive_ack[33][34];

// 2D array records the number of DISCOVER sent by i-th node
// and the DISCOVER_ACK received by i-th node
static int count[33][2] = {0};
//---------------------------------------------------


// EVENT_HANDLER macro used for defining button_pressed function
static EVENT_HANDLER(button_pressed){
	if (nodeinfo.nlinks != 0){
		// print requried messages
		printf("#DISCOVER messages transmitted by the node: %d\n", count[nodeinfo.nodenumber][0]);
		printf("#DISCOVER_ACK messages received by the node: %d\n", count[nodeinfo.nodenumber][1]);
		for (int link = 1; link <= 32; link++){
			INFO neighbour = neighbour_info[nodeinfo.nodenumber][link];
			if (!neighbour.neighbour_address){
				break;
			}
			// print neighbour informations
			printf("[%d] %s (%d) #links = %d, costTo = %d, costFrom = %d\n", 
				   link,
				   neighbour.neighbour_name,
				   neighbour.neighbour_address,
				   neighbour.neighbour_nlinks,
				   neighbour.outgoing_costperbyte,
				   neighbour.incoming_costperbyte);
		}
	}
}


// EVENT_HANDLER macro used for defining physical_ready function
static EVENT_HANDLER(physical_ready){
	size_t len = sizeof(FRAME);
	int link;
	INFO info;
	FRAME frame;
	frame.info = info;

    // check if the frame is successfully read
	CHECK(CNET_read_physical(&link, (char *) &frame, &len));

	switch (frame.kind){
		case DL_DISCOVER:
		    // if node has already received ACK from the link
			if (receive_ack[nodeinfo.nodenumber][link]){
			    	break;
			    }
			// send back an ACK frame
			frame.kind = DL_DISCOVER_ACK;
			// send back requested info of the node
			strcpy(frame.info.neighbour_name, nodeinfo.nodename);
			frame.info.neighbour_address = nodeinfo.address;
			frame.info.neighbour_nlinks = nodeinfo.nlinks;
			frame.info.outgoing_costperbyte = linkinfo[link].costperbyte;
			count[nodeinfo.nodenumber][0] += 1;

			len = sizeof(FRAME);
			// write back the frame into physical layer
			CHECK(CNET_write_physical(link, (char *) &frame, &len));
			break;

		case DL_DISCOVER_ACK:
		    frame.info.incoming_costperbyte = linkinfo[link].costperbyte;
		    // record necessary info and ensure the arrival of ACK frame
		    neighbour_info[nodeinfo.nodenumber][link] = frame.info;
		    receive_ack[nodeinfo.nodenumber][link] = 1;
		    count[nodeinfo.nodenumber][1] += 1;
			break;
    }
}


// EVENT_HANDLER macro used for defining timer1_send_discover function
static EVENT_HANDLER(timer1_send_discover){
	// continuously sending the DISCOVER message to neighbours
	for (int link = 1; link <= nodeinfo.nlinks; link++){
		size_t len = sizeof(FRAME);
		FRAME frame;
		INFO info;
		frame.kind = DL_DISCOVER;
		frame.info = info;

        // write frame into physical layer
		CHECK(CNET_write_physical(link, (char *) &frame, &len));
	}

    // if the node is not familiar all its neighbour, redo the process
	if (count[nodeinfo.nodenumber][1] != nodeinfo.nlinks){
		CNET_start_timer(EV_TIMER1, 1000000, 0);
	}
}


// EVENT_HANDLER macro used for defining reboot_node function
EVENT_HANDLER(reboot_node){
	CNET_set_handler(EV_DEBUG0, button_pressed, 0);
	CNET_set_debug_string(EV_DEBUG0, "Neighbours");

	CNET_set_handler(EV_PHYSICALREADY, physical_ready, 0);
	CNET_set_handler(EV_TIMER1, timer1_send_discover, 0);

	// Request EV_TIMER1 in 1 sec, ignore return value
	CNET_start_timer(EV_TIMER1, 1000000, 0);
}