#include <cnet.h>
#include <string.h>
#include <stdlib.h>
#include <time.h>


//------------------Typedef-----------------------
typedef struct {
    double		x;
    double		y;
} POINT;

typedef struct {
    POINT		now;		// current location
    POINT		dest;		// known destination
    bool		paused;		// is this node paused?
    double		dx;		    // steps to reach destination
    double		dy;

    CnetPosition	maparea;	// max. dimensions of map
    double		    walkspeed;	// metres per second
    CnetTime		pausetime;	// microseconds
    CnetPosition    position;   // current position of the node
} WALK;

typedef struct {
	CnetPosition    pos;                // position of the anchor
	int             stored_address[15]; // addresses of stored frames
	int             stored_count;       // count of stored frames
} BEACON;

typedef struct {
    int			    dest;
    int			    src;
    int			    length;		      // length of payload(if there is any data message)

    int             if_general;       // if the frame is a general mobile transmitted frame
    int             if_beacon;        // if the frame is a beacon message
    int             if_retransmit;    // if the frame is a mobile retransmitted frame
    int             if_request;       // if the frame is a download request frame
    int             if_reply;         // if the frame is a download reply frame
} WLAN_HEADER;

typedef struct {
    WLAN_HEADER		header;
    BEACON          beacon;           // beacon message if the frame is a beacon frame
    char		    payload[2048];    // data message if the frame is a data frame
} WLAN_FRAME;
//------------------------------------------------


//--------------------Macro-----------------------
#define	WALKING_SPEED	3.0
#define	PAUSE_TIME		20
#define	TX_NEXT			(5000000 + rand() % 5000000)

#define	USEC_PER_STEP	1000000
#define	MARGIN			20
#define	CLOSE_ENOUGH	100
//------------------------------------------------


//------------------Global------------------------
extern void srand(unsigned);
extern int rand(void);

static int mobiles[15]; // addresses of mobile nodes
static int anchors[15]; // addresses of anchor nodes
static int m_count = 0; // count of mobiles
static int a_count = 0; // count of anchors

// mobile globals
static WALK *walk = NULL; // walk status for the mobiles
static CnetPosition *anchor_positions = NULL; // positions of anchors(from beacon message)
static int beacon_received = 0; // count of anchors already broadcasted

// anchor globals
static WLAN_FRAME *anchor_buffer = NULL; // buffer for anchors
static int buffer_count = 0; // count of stored frames
//------------------------------------------------


//------------------Code--------------------------
// defined function for converting string 'mobiles' and 'anchors' 
// to int array which stores address of each node
void address_convert(char *string, int flag){
    // temp array and count
	char temp[5];
	int count = 0;

	for (int i = 0; i <= strlen(string); i++){
		// if current byte is ',' or is the last byte
		if (string[i] == 44 || i == strlen(string)){
			// if it is mobiles
			if (!flag){
				mobiles[m_count] = atoi(temp);
				m_count += 1;
			}
			// if it is anchors
			if (flag){
				anchors[a_count] = atoi(temp);
				a_count += 1;
			}

			// clear up temp array
			memset(temp, 0, sizeof(temp));
			count = 0;

			continue;
		}
		// if current byte is ' '
		if (string[i] == 32){
			continue;
		}
		temp[count] = string[i];
		count += 1;
	}
}

// defined function for generating random point
void random_point(POINT *new){
    new -> x = rand() % (int)(walk -> maparea.x - 2 * MARGIN) + MARGIN;
    new -> y = rand() % (int)(walk -> maparea.y - 2 * MARGIN) + MARGIN;
}


// defined function for calculating distance between two points
double distance(CnetPosition p0, CnetPosition p1){
    int	dx	= p1.x - p0.x;
    int	dy	= p1.y - p0.y;

    return sqrt(dx*dx + dy*dy);
}


// defined function for node movement
EVENT_HANDLER(mobility){
	// if the node is not moving
	if (walk -> paused){
		POINT newdest;
		do {
			//choose a random point to move(except current position)
			random_point(&newdest);
		} while((int)newdest.x == (int)walk -> now.x &&
    		    (int)newdest.y == (int)walk -> now.y);
		walk -> dest = newdest;

        // calculate distance between destination and cuurent position
		double dx = (walk -> dest.x - walk -> now.x);
    	double dy = (walk -> dest.y - walk -> now.y);

    	double metres = sqrt(dx * dx + dy * dy);
    	double nsteps = (metres / walk -> walkspeed) * 1000000 / USEC_PER_STEP;

        // calculate movement in x and y coordinate for each step
    	walk -> dx = dx / nsteps;
    	walk -> dy = dy / nsteps;

        // start moving
    	CNET_start_timer(EV_TIMER0, USEC_PER_STEP, 0);
    	walk -> paused = false;
	}

    // if the node is still moving
	if (!walk -> paused){
		walk -> now.x += walk -> dx;
		walk -> now.y += walk -> dy;

        // update position of the node
		CnetPosition newpos = {walk -> now.x, walk -> now.y, 0};
		CHECK(CNET_set_position(newpos));
		walk -> position = newpos;

        // calculate the distance between current position and the destination
		double dx = (walk -> dest.x - walk -> now.x);
    	double dy = (walk -> dest.y - walk -> now.y);

        // if the node is closer enough to the destination
    	if ((dx * dx + dy * dy) <= CLOSE_ENOUGH){
    		walk -> paused = true;
    		// pause for pausetime
    	    CNET_start_timer(EV_TIMER0, walk -> pausetime, 0);
    	} else {
    		// keep walking
    		CNET_start_timer(EV_TIMER0, USEC_PER_STEP, 0);
    	}
	}
}


// defined function for initialize mobility of the node
void init_mobility(double walkspeed_metres_per_sec, int pausetime_sec){
	// initialize WALK struct
	walk = calloc(1, sizeof(WALK));
	walk -> walkspeed = walkspeed_metres_per_sec;
    walk -> pausetime = pausetime_sec * 1000000;
    walk -> paused = true;
    CHECK(CNET_get_position(NULL, &walk->maparea));
    srand(nodeinfo.time_of_day.sec + nodeinfo.nodenumber);

    // randomly select a ponit for the node to begin
	random_point(&walk -> now);
	CnetPosition newpos = {walk -> now.x, walk -> now.y, 0};
	CHECK(CNET_set_position(newpos));
	walk -> position = newpos;

	// node start moving
	CHECK(CNET_set_handler(EV_TIMER0, mobility, 0));
    CNET_start_timer(EV_TIMER0, USEC_PER_STEP, 0);
}


// defined function for transmitting mobile frames
EVENT_HANDLER(mobile_transmit){
	WLAN_FRAME frame;
	int link = 1;

	do {
		// construct a frame to send(dest is other nodes)
		frame.header.dest = mobiles[rand() % m_count];
	} while (frame.header.dest == nodeinfo.address);

	frame.header.src = nodeinfo.address;
	sprintf(frame.payload, "hello from node #%d with address #%d", nodeinfo.nodenumber, nodeinfo.address);
	frame.header.length	= strlen(frame.payload) + 1;

    // set type bits
	frame.header.if_general = 1;
	frame.header.if_beacon = 0;
	frame.header.if_retransmit = 0;
	frame.header.if_request = 0;
	frame.header.if_reply = 0;

    // write the frame into physical layer
	size_t len = sizeof(WLAN_FRAME);
	printf("mobile [%d](x = %lf,y = %lf): pkt transmitted (src = %d, dest = %d)\n", 
    	    nodeinfo.address, walk -> now.x, walk -> now.y, frame.header.src, frame.header.dest);
    CHECK(CNET_write_physical_reliable(link, &frame, &len));

    CNET_start_timer(EV_TIMER1, TX_NEXT, 0);
}


// defined function for transmitting anchor frames
EVENT_HANDLER(anchor_transmit){
	int link = 1;

    // broadcast beacon message to every mobile node
    for (int i = 0; i < m_count; i++){
    	WLAN_FRAME frame;

    	// store header info
		frame.header.src = nodeinfo.address;
		frame.header.dest = mobiles[i];
		frame.header.length = 0;

        // set type bits
		frame.header.if_general = 0;
		frame.header.if_beacon = 1;
		frame.header.if_retransmit = 0;
		frame.header.if_request = 0;
		frame.header.if_reply = 0;

        // store beacon info
		CHECK(CNET_get_position(&frame.beacon.pos, NULL));
		frame.beacon.stored_count = buffer_count;
		for (int j = 0; j < buffer_count; j++){
			// if the frame already been requested
			if (anchor_buffer[j].header.if_reply){
				frame.beacon.stored_address[j] = -1;
				continue;
			}
			frame.beacon.stored_address[j] = anchor_buffer[j].header.dest;
		}

        // write the frame into physical layer
		size_t len = sizeof(WLAN_FRAME);
		CHECK(CNET_write_physical_reliable(link, &frame, &len));
    }

    CNET_start_timer(EV_TIMER2, 1000000, 0);
}


// defined function for handling physical layer events
EVENT_HANDLER(receive){
	WLAN_FRAME frame;
    size_t len;
    int	 link;

    // read a frame from the physical layer
    len	= sizeof(frame);
    CHECK(CNET_read_physical(&link, &frame, &len));

    // mobile node
    if (nodeinfo.nodetype == NT_MOBILE){

    	// if the frame is a beacon message
    	if (frame.header.if_beacon && frame.header.dest == nodeinfo.address){
    		// check if already store the pos of the anchor
    		int if_exist = 0;
    		for (int i = 0; i < beacon_received; i++){
    			if (anchor_positions[i].x == frame.beacon.pos.x
    			    && anchor_positions[i].y == frame.beacon.pos.y){
    				if_exist = 1;
    			}
    		}
    		// store the address if have not stored
    		if (!if_exist){
    			anchor_positions[beacon_received] = frame.beacon.pos;
	    		beacon_received++;
    		}

    		// check if anchor have any frames for the mobile node
    		int if_have = 0;
    		for (int i = 0; i < frame.beacon.stored_count; i++){
    			if (frame.beacon.stored_address[i] == nodeinfo.address){
    				if_have = 1;
    			}
    		}
    		// request to download the frame if there is a stored one
    		if (if_have){
    			WLAN_FRAME request;

                // set header info
    			request.header.src = nodeinfo.address;
    			request.header.dest = frame.header.src;
    			request.header.length = 0;

                // set type bits
    			request.header.if_general = 0;
				request.header.if_beacon = 0;
				request.header.if_retransmit = 0;
				request.header.if_request = 1;
				request.header.if_reply = 0;

                // write the request frame into physical layer
    			size_t request_len = sizeof(WLAN_FRAME);
    			CHECK(CNET_write_physical_reliable(link, &request, &request_len));
    		}
    	}

    	// is the frame is a data message
    	if (frame.header.if_general) {
    		// if the frame is for me
    		if (frame.header.dest == nodeinfo.address){
    			printf("mobile [%d](x = %lf,y = %lf): pkt received (src = %d, dest = %d)\n", 
			    	    nodeinfo.address, walk -> now.x, walk -> now.y, frame.header.src, frame.header.dest);
    		}
    		// if the frame is for other nodes
    		if (frame.header.dest != nodeinfo.address){
    			for (int i = 0; i < beacon_received; i++){
    				// if the mobile node is closer to any anchor node, retransmit the frame
    				if (distance(walk -> position, anchor_positions[i]) <= 170){
    					frame.header.if_general = 0;
    					frame.header.if_retransmit = 1;

    					printf("mobile [%d](x = %lf,y = %lf): pkt relayed (src = %d, dest = %d)\n", 
					    	    nodeinfo.address, walk -> now.x, walk -> now.y, frame.header.src, frame.header.dest);
    					CHECK(CNET_write_physical_reliable(link, &frame, &len));
    				}
    			}
    		}
    	}
    }

    // anchor node
    if (nodeinfo.nodetype == NT_ACCESSPOINT){
    	// at most store 20 frames
    	if (buffer_count == 20) buffer_count = 0;

    	// if the received frame is a retransmitted frame
    	if (frame.header.if_retransmit){
    		printf("anchor [%d]: pkt received and stored (src = %d, dest = %d)\n", 
    			   nodeinfo.address, frame.header.src, frame.header.dest);
    		anchor_buffer[buffer_count] = frame;
    		buffer_count++;
    	}
    	// if the received frame is a request message
    	if (frame.header.if_request){
    		printf("anchor [%d]: download request (dest = %d)\n", nodeinfo.address, frame.header.src);
    		for (int i = 0; i < buffer_count; i++){
    			if (anchor_buffer[i].header.dest == frame.header.src && !anchor_buffer[i].header.if_reply){
    				// construct a reply frame
    				anchor_buffer[i].header.if_retransmit = 0;
    				anchor_buffer[i].header.if_reply = 1;

                    // write the reply frame into physical layer
                    size_t reply_len = sizeof(WLAN_FRAME);
                    printf("anchor [%d]: download reply (src = %d, dest = %d)\n", 
                    	   nodeinfo.address, anchor_buffer[i].header.src, anchor_buffer[i].header.dest);
    				CHECK(CNET_write_physical_reliable(link, &anchor_buffer[i], &reply_len));
    			}
    		}
    	}
    }
}


// defined function for rebooting node
EVENT_HANDLER(reboot_node){
	// store addresses of mobiles and anchors
	char *mobiles_string = CNET_getvar("mobiles");
	char *anchors_string = CNET_getvar("anchors");
	address_convert(mobiles_string, 0);
	address_convert(anchors_string, 1);

	CNET_check_version(CNET_VERSION);
	CHECK(CNET_set_handler(EV_PHYSICALREADY, receive, 0));

    // if the node is a mobile node
	if (nodeinfo.nodetype == NT_MOBILE){
		anchor_positions = calloc(a_count, sizeof(CnetPosition));

	    // set the random seed
		srand(time(NULL) + nodeinfo.nodenumber);

	    // initialize mobility of node
		init_mobility(WALKING_SPEED, PAUSE_TIME);

        // transmit frame for every TX_NEXT usec
		CHECK(CNET_set_handler(EV_TIMER1, mobile_transmit, 0));
	    CNET_start_timer(EV_TIMER1, TX_NEXT, 0);
	}

    // if the node is an anchor node
	if (nodeinfo.nodetype == NT_ACCESSPOINT){
		anchor_buffer = calloc(20, sizeof(WLAN_FRAME));

		CHECK(CNET_set_handler(EV_TIMER2, anchor_transmit, 0));
	    CNET_start_timer(EV_TIMER2, 2000000, 0);
	}
}
//------------------------------------------------