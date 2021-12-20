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
//----------------------------------------------------------------


//-------------------------Code-----------------------------------
// defined fucntion for transmitting frame
void transmit_frame(int flag, MSG *msg, size_t length, int seq_ack){
    FRAME frame;
    int link = 1;

    frame.sourceaddr = nodeinfo.address;
    frame.destaddr = connections[1].destaddr;
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
        connections[1].lasttimer = CNET_start_timer(EV_TIMER1, 3 * timeout, 0);
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
    memcpy(&connections[1].lasttransmittedframe, &frame, length);
    // write the frame into physical layer
    CHECK(CNET_write_physical(link, &connections[1].lasttransmittedframe, &length));
}

// defined function for printing the state of the node
EVENT_HANDLER(showstate){
    printf("\n\tackexpected\t= %i\n\tnextframetosend\t= %i\n\tframeexpected\t= %i\n",
            connections[1].ackexpected, connections[1].nextframetosend, connections[1].frameexpected);
}

// defined function for timeouts event
EVENT_HANDLER(timeout){
    // retransmit the data frame
    transmit_frame(1, &connections[1].lastmsg, connections[1].lastmsglength, connections[1].ackexpected);
}

// defined function for application ready event
EVENT_HANDLER(application_ready){
    connections[1].lastmsglength = sizeof(MSG);
    // read message from application layer
    CHECK(CNET_read_application(&connections[1].destaddr, &connections[1].lastmsg, &connections[1].lastmsglength));
    CNET_disable_application(ALLNODES);

    // transmit a data frame
    transmit_frame(1, &connections[1].lastmsg, connections[1].lastmsglength, connections[1].nextframetosend);
    increment(connections[1].nextframetosend);
}

// defined function for physical layer ready event
EVENT_HANDLER(physical_ready){
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

    // if the frame is a data frame (receiver side)
    if (frame.seq != -1){
        // if the seq is expeced
        if (frame.seq == connections[1].frameexpected){
            len = frame.len;
            // write the frame into application layer
            CHECK(CNET_write_application(&frame.msg, &len));
            increment(connections[1].frameexpected);
            printf("DATA received [delivered]:(src= %d, dest= %d, seq= %d, ack= %d, msgLen= %lu)\n", 
                    frame.sourceaddr, frame.destaddr, frame.seq, frame.ack, frame.len);
        }
        // transmit an ack frame
        transmit_frame(0, NULL, 0, frame.seq);
    }

    // if the frame is acknowledgement frame (sender side)
    if (frame.ack != -1){
        // if the ack is expected
        if (frame.ack == connections[1].ackexpected){
            CNET_stop_timer(connections[1].lasttimer);
            increment(connections[1].ackexpected);
            // enable application layer
            CNET_enable_application(ALLNODES);
            printf("\tACK received: (src= %d, dest= %d, seq= %d, ack= %d, msgLen= %lu)\n",
                    frame.sourceaddr, frame.destaddr, frame.seq, frame.ack, frame.len);
        }
    }
}

// defined function for roobting nodes
EVENT_HANDLER(reboot_node){
    // set handlers for events
    CHECK(CNET_set_handler( EV_APPLICATIONREADY, application_ready, 0));
    CHECK(CNET_set_handler( EV_PHYSICALREADY, physical_ready, 0));
    CHECK(CNET_set_handler( EV_TIMER1, timeout, 0));
    CHECK(CNET_set_handler(EV_DEBUG0, showstate, 0));
    CHECK(CNET_set_debug_string(EV_DEBUG0, "Node State"));

    // allocate memory for array connections
    connections = (CONN *) malloc((nodeinfo.nlinks + 1) * sizeof(CONN));
    // initialization of CONN struct
    MSG msg;
    connections[1].lasttimer = NULLTIMER;
    connections[1].lastmsglength = 0;
    connections[1].lastmsg = msg;
    connections[1].nextframetosend = 0;
    connections[1].ackexpected = 0;
    connections[1].frameexpected = 0;

    // enable application layer
    CNET_enable_application(ALLNODES);
}
//----------------------------------------------------------------