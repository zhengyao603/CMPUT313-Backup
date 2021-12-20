#include <cnet.h>
#include <stdlib.h>
#include <string.h>

//-------------------------Typedef---------------------------------
//  DATA FRAMES CARRY A MAXIMUM-SIZED PAYLOAD, OUR MESSAGE
typedef struct {
    char        data[MAX_MESSAGE_SIZE];
} MSG;

typedef struct {
//  THE FIRST FIELDS IN THE STRUCTURE DEFINE THE FRAME HEADER
    size_t	     len;       	// the length of the msg field only
    int          checksum;  	// checksum of the whole frame
    int          seq;       	// seq number
    int          ack;           // ack number
    CnetAddr     sourceaddr;    // source address
    CnetAddr     destaddr;      // destination address

//  THE LAST FIELD IN THE FRAME IS THE PAYLOAD, OUR MESSAGE
    MSG          msg;
} FRAME;

typedef struct {
	CnetAddr     destaddr;             // address of the other host of the connection
	CnetTimerID	 lasttimer;            // last timer of the connection

	size_t       lastmsglength;        // length of last message of the connection
	MSG          lastmsg;              // last message of the connection

	int		     nextframetosend;      // next frame to send in sender
	int          ackexpected;          // expected ack for receiver
	int          frameexpected;        // expected frame of sender
	FRAME        lasttransmittedframe; // last transmitted frame of the connection
} CONN;

//  SOME HELPFUL MACROS FOR COMMON CALCULATIONS
#define FRAME_HEADER_SIZE	(sizeof(FRAME) - sizeof(MSG))
#define FRAME_SIZE(frame)	(FRAME_HEADER_SIZE + frame.len)
#define increment(seq)      seq = 1 - seq
//----------------------------------------------------------------


//-------------------------Global---------------------------------
static CONN *connections;      // CONN array for storing data
static int discover_count = 0; // number of neighbours already discovered
//----------------------------------------------------------------


//-------------------------Code-----------------------------------

//-------------------------Connection-----------------------------
// defined fucntion for transmitting frame
void transmit_frame(int flag, MSG *msg, size_t length, int seq_ack, int link){
	FRAME frame;
	frame.sourceaddr = nodeinfo.address;
    frame.destaddr = connections[link].destaddr;
    frame.checksum  = 0;
    frame.len = length;

    // this frame is a data frame
    if (flag){
        CnetTime timeout;
        frame.ack = -1;
        frame.seq = seq_ack;

        memcpy(&frame.msg, msg, length);
        // set the timer
        timeout = FRAME_SIZE(frame) * ((CnetTime) 8000000 / linkinfo[link].bandwidth) +
                  linkinfo[link].propagationdelay;
        connections[link].lasttimer = CNET_start_timer(EV_TIMER1, 3 * timeout, 0);
        printf("DATA transmitted: (src= %d, dest= %d, seq= %d, ack= %d, msgLen= %lu)\n",
                frame.sourceaddr, frame.destaddr, frame.seq, frame.ack, frame.len);
    }

    // this frame is an acknowledgement frame
    if (!flag){
        frame.seq = -1;
        frame.ack = seq_ack;
        printf("\tACK sent: (src= %d, dest= %d, seq= %d, ack= %d, msgLen= %lu)\n",
                frame.sourceaddr, frame.destaddr, frame.seq, frame.ack, frame.len);
    }

    length = FRAME_SIZE(frame);
    // set the expected checksum
    frame.checksum  = CNET_ccitt((unsigned char *) &frame, length);
    memcpy(&connections[link].lasttransmittedframe, &frame, length);
    // write the frame into physical layer
    CHECK(CNET_write_physical(link, &connections[link].lasttransmittedframe, &length));
}

// defined function for application layer operation
EVENT_HANDLER(application_ready){
	CnetAddr destaddr;
	MSG lastmsg;
	size_t lastmsglength = sizeof(MSG);

	// read message from application layer
	CHECK(CNET_read_application(&destaddr, &lastmsg, &lastmsglength));
	CNET_disable_application(destaddr);

	for (int link = 1; link <= nodeinfo.nlinks; link++){
		// check the link of destaddr
		if (connections[link].destaddr == destaddr){
			// encapsulate connections
		    connections[link].lastmsglength = lastmsglength;
		    memcpy(&connections[link].lastmsg, &lastmsg, lastmsglength);

		    // transmit a data frame
		    transmit_frame(1, &connections[link].lastmsg, connections[link].lastmsglength, connections[link].nextframetosend, link);
		    increment(connections[link].nextframetosend);
		}
	}
}

// defined function for physical layer transmittion during connection
EVENT_HANDLER(physical_connection){
	FRAME frame;
    int link;
    int checksum;
    size_t len = sizeof(FRAME);

    // read the frame from physical layer
    CHECK(CNET_read_physical(&link, &frame, &len));

    // check if the checksum of the frame is valid
    checksum = frame.checksum;
    frame.checksum = 0;
    // if the frame is corrupted, ignore it
    if (CNET_ccitt((unsigned char *) &frame, len) != checksum) {
        printf("BAD frame received: checksums (stored= %d, computed= %d)\n",
               checksum, CNET_ccitt((unsigned char *) &frame, len));
        return;
    }

    // if the ndoe is a host
    if (nodeinfo.nodetype == NT_HOST){
    	// if the frame is a data frame (receiver side)
	    if (frame.seq >= 0){
	        // if the seq is expeced
	        if (frame.seq == connections[link].frameexpected){
	            len = frame.len;
	            // write the frame into application layer
	            CHECK(CNET_write_application(&frame.msg, &len));
	            increment(connections[link].frameexpected);
	            printf("DATA received [delivered]:(src= %d, dest= %d, seq= %d, ack= %d, msgLen= %lu)\n", 
	                    frame.sourceaddr, frame.destaddr, frame.seq, frame.ack, frame.len);
	        }
	        // transmit an ack frame
	        transmit_frame(0, NULL, 0, frame.seq, link);
	    }

	    // if the frame is acknowledgement frame (sender side)
	    if (frame.ack >= 0){
	        // if the ack is expected
	        if (frame.ack == connections[link].ackexpected){
	            CNET_stop_timer(connections[link].lasttimer);
	            increment(connections[link].ackexpected);

	            // enable application layer
	            CNET_enable_application(connections[link].destaddr);

	            printf("\tACK received: (src= %d, dest= %d, seq= %d, ack= %d, msgLen= %lu)\n",
	                    frame.sourceaddr, frame.destaddr, frame.seq, frame.ack, frame.len);
	        }
	    }
    }

    // if the node is a router
	if (nodeinfo.nodetype == NT_ROUTER){
		// re-compute the checksum
		frame.checksum = CNET_ccitt((unsigned char *) &frame, len);
		// forward the frame with another link
		if (link == 1){
			printf("Frame received from link #1, forward it to link #2\n");
			CHECK(CNET_write_physical(2, (char *) &frame, &len));
		} else if (link == 2){
			printf("Frame received from link #2, forward it to link #1\n");
			CHECK(CNET_write_physical(1, (char *) &frame, &len));
		}
	}
}

// defined function for timeout event
EVENT_HANDLER(timeout){
	for (int link = 1; link <= nodeinfo.nlinks; link++){
		// check which connection times out
		if (timer == connections[link].lasttimer){
			// retransmit the data frame
		    transmit_frame(1, &connections[link].lastmsg, connections[link].lastmsglength, connections[link].ackexpected, link);
		}
	}
}
//------------------------------------------------------------------


//--------------------------------Discovery-------------------------
// deinfed function for discovering neighbours for each node
void discover_neighbour(int link){
    // initialize a msg
    MSG msg = {'D', 'A', 'T', 'A', '\0'};

    // construct a data frame
    FRAME frame;
    frame.msg = msg;
	frame.len = 5;
	frame.seq = -1;
	frame.ack = -2;
	frame.sourceaddr = nodeinfo.address;
	frame.destaddr = 0;
	frame.checksum = 0;

    // compute checksum and store the frame
	size_t length = FRAME_SIZE(frame);
	frame.checksum = CNET_ccitt((unsigned char *) &frame, length);

	// write the frame into physical layer
	CHECK(CNET_write_physical(link, (char *) &frame, &length));
}

// defined function for physical layer discovering neighbours
EVENT_HANDLER(physical_discover){
	size_t len = sizeof(FRAME);
	int link;
	int checksum;
	FRAME frame;

    // read the frame from physical layer
	CHECK(CNET_read_physical(&link, (char *) &frame, &len));

	// check if the checksum of the frame is valid
    checksum = frame.checksum;
    frame.checksum = 0;
    // if the frame is corrupted, ignore it
    if (CNET_ccitt((unsigned char *) &frame, len) != checksum) {
        printf("BAD frame received: checksums (stored= %d, computed= %d)\n",
               checksum, CNET_ccitt((unsigned char *) &frame, len));
        return;
    }

    // if the node is a host
	if (nodeinfo.nodetype == NT_HOST){
		// if the frame is a data frame (receiver side)
		if (frame.seq == -1 && frame.ack == -2 && !connections[link].destaddr){
			// store the address
			frame.destaddr = nodeinfo.address;
			frame.seq = -2;
			frame.ack = -1;
			// recompute the checksum
			frame.checksum = CNET_ccitt((unsigned char *) &frame, len);

			// write the ack frame back into physical layer
			CHECK(CNET_write_physical(link, (char *) &frame, &len));
		}
		// if the frame is an ack frame (sender side)
		else if (frame.ack == -1 && frame.seq == -2 && !connections[link].destaddr){
			// if the host already discovered host in this link, ignore the ack frame
			connections[link].destaddr = frame.destaddr;
			discover_count++;
		}
	}

	// if the node is a router
	if (nodeinfo.nodetype == NT_ROUTER){
		// re-compute the checksum
		frame.checksum = CNET_ccitt((unsigned char *) &frame, len);
		// forward the frame with another link
		if (link == 1){
			printf("Frame received from link #1, forward it to link #2\n");
			CHECK(CNET_write_physical(2, (char *) &frame, &len));
		} else if (link == 2){
			printf("Frame received from link #2, forward it to link #1\n");
			CHECK(CNET_write_physical(1, (char *) &frame, &len));
		}
	}
}

// defined function for waiting physical layer ready
EVENT_HANDLER(discover){
	// discover the neighbours of the host
    for (int link = 1; link <= nodeinfo.nlinks; link++){
    	// if the link has already been discovered
    	if (connections[link].destaddr){
    		continue;
    	}
    	discover_neighbour(link);
    }

    // if there is any neighbour has not been discovered
    if (discover_count != nodeinfo.nlinks){
    	CNET_start_timer(EV_TIMER0, 5000000, 0);
    }
    // if each host has already familiar with their neighbours
    else if (discover_count == nodeinfo.nlinks){
    	printf("Discovery Process Finished!\n");
    	for (int i = 1; i <= nodeinfo.nlinks; i++){
    		printf("Neighbour #%d: DestAddr: %d\n", i, connections[i].destaddr);
    		connections[i].nextframetosend = 0;
		    connections[i].ackexpected = 0;
		    connections[i].frameexpected = 0;
    	}
    	printf("\n");

    	// reset handlers
    	CHECK(CNET_set_handler(EV_PHYSICALREADY, physical_connection, 0));
    	CHECK(CNET_set_handler(EV_TIMER1, timeout, 0));
    	CHECK(CNET_set_handler(EV_APPLICATIONREADY, application_ready, 0));

    	// enable application layer
    	CNET_enable_application(nodeinfo.address);
    	for (int i = 1; i <= nodeinfo.nlinks; i++){
    		CNET_enable_application(connections[i].destaddr);
    	}
    }
}
//---------------------------------------------------------------------

//-----------------------------Rebooting-------------------------------
// defined function for roobting nodes
EVENT_HANDLER(reboot_node){
	CHECK(CNET_set_handler(EV_PHYSICALREADY, physical_discover, 0));

	// if the node is a host
    if (nodeinfo.nodetype == NT_HOST){
    	// set handlers
	    CHECK(CNET_set_handler(EV_TIMER0, discover, 0));
    	// allocate memory for array connections
	    connections = (CONN *) calloc(nodeinfo.nlinks + 1, sizeof(CONN));

	    CNET_start_timer(EV_TIMER0, 1000000, 0);
    }
}
//----------------------------------------------------------------