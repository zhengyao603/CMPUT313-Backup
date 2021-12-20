#include <cnet.h>
#include <stdlib.h>
#include <string.h>

/*  This is an implementation of a stop-and-wait data link protocol.

    This protocol provides a reliable data-link layer for a 2-node network.
    This protocol employs only data and acknowledgement frames -
    piggybacking and negative acknowledgements are not used.

    It is based on Tanenbaum's 'protocol 4', 2nd edition, p227.
 */

//  A FRAME CAN BE EITHER DATA OR AN ACKNOWLEDGMENT FRAME
typedef enum    { DL_DATA, DL_ACK }   FRAMEKIND;

//  DATA FRAMES CARRY A MAXIMUM-SIZED PAYLOAD, OUR MESSAGE
typedef struct {
    char        data[MAX_MESSAGE_SIZE];
} MSG;


//  THE FORMAT OF A FRAME
typedef struct {
//  THE FIRST FIELDS IN THE STRUCTURE DEFINE THE FRAME HEADER
    FRAMEKIND    kind;      	// only ever DL_DATA or DL_ACK
    size_t	 len;       	// the length of the msg field only
    int          checksum;  	// checksum of the whole frame
    int          seq;       	// only ever 0 or 1

//  THE LAST FIELD IN THE FRAME IS THE PAYLOAD, OUR MESSAGE
    MSG          msg;
} FRAME;


//  SOME HELPFUL MACROS FOR COMMON CALCULATIONS
#define FRAME_HEADER_SIZE	(sizeof(FRAME) - sizeof(MSG))
#define FRAME_SIZE(frame)	(FRAME_HEADER_SIZE + frame.len)
#define increment(seq)		seq = 1-seq


//  STATE VARIABLES HOLDING INFORMATION ABOUT THE LAST MESSAGE
MSG       	lastmsg;
size_t		lastmsglength		= 0;
CnetTimerID	lasttimer		= NULLTIMER;

//  STATE VARIABLES HOLDING SEQUENCE NUMBERS
int		nextdatatosend		= 0;
int       	ackexpected		= 0;
int		dataexpected		= 0;


//  A FUNCTION TO TRANSMIT EITHER A DATA OR AN ACKNOWLEDGMENT FRAME
void transmit_frame(FRAMEKIND kind, MSG *msg, size_t length, int seqno)
{
    FRAME       frame;
    int		link = 1;

//  INITIALISE THE FRAME'S HEADER FIELDS
    frame.kind      = kind;
    frame.seq       = seqno;
    frame.checksum  = 0;
    frame.len       = length;

    switch (kind) {
    case DL_ACK :
        printf("ACK transmitted, seq=%i\n", seqno);
	break;

    case DL_DATA: {
	CnetTime	timeout;

        printf(" DATA transmitted, seq=%i\n", seqno);
        memcpy(&frame.msg, msg, length);

	timeout =
		FRAME_SIZE(frame)*((CnetTime)8000000 / linkinfo[link].bandwidth) +
				linkinfo[link].propagationdelay;

        lasttimer = CNET_start_timer(EV_TIMER1, 3 * timeout, 0);
	break;
      }
    }

//  FINALLY, WRITE THE FRAME TO THE PHYSICAL LAYER
    length		= FRAME_SIZE(frame);
    frame.checksum	= CNET_ccitt((unsigned char *)&frame, length);
    CHECK(CNET_write_physical(link, &frame, &length));
}

//  THE APPLICATION LAYER HAS A NEW MESSAGE TO BE DELIVERED
EVENT_HANDLER(application_ready)
{
    CnetAddr destaddr;

    lastmsglength  = sizeof(MSG);
    CHECK(CNET_read_application(&destaddr, &lastmsg, &lastmsglength));
    CNET_disable_application(ALLNODES);

    printf("down from application, seq=%i\n", nextdatatosend);
    transmit_frame(DL_DATA, &lastmsg, lastmsglength, nextdatatosend);
    increment(nextdatatosend);
}

//  PROCESS THE ARRIVAL OF A NEW FRAME, VERIFY CHECKSUM, ACT ON ITS FRAMEKIND
EVENT_HANDLER(physical_ready)
{
    FRAME        frame;
    int          link, arriving_checksum;
    size_t	 len = sizeof(FRAME);

//  RECEIVE THE NEW FRAME
    CHECK(CNET_read_physical(&link, &frame, &len));

//  CALCULATE THE CHECKSUM OF THE ARRIVING FRAME, IGNORE IF INVALID
    arriving_checksum	= frame.checksum;
    frame.checksum  	= 0;
    if(CNET_ccitt((unsigned char *)&frame, len) != arriving_checksum) {
        printf("\t\t\t\tBAD checksum - frame ignored\n");
        return;           // bad checksum, just ignore frame
    }

    switch (frame.kind) {
//  AN ACKNOWLEDGMENT HAS ARRIVED, ENSURE IT'S THE ACKNOWLEDGMENT WE WANT
    case DL_ACK :
        if(frame.seq == ackexpected) {
            printf("\t\t\t\tACK received, seq=%i\n", frame.seq);
            CNET_stop_timer(lasttimer);
            increment(ackexpected);
            CNET_enable_application(ALLNODES);
        }
	break;

//  SOME DATA HAS ARRIVED, ENSURE IT'S THE ONE DATA WE EXPECT
    case DL_DATA :
        printf("\t\t\t\tDATA received, seq=%i, ", frame.seq);
        if(frame.seq == dataexpected) {
            printf("up to application\n");
            len = frame.len;
            CHECK(CNET_write_application(&frame.msg, &len));
            increment(dataexpected);
        }
        else
            printf("ignored\n");
        transmit_frame(DL_ACK, NULL, 0, frame.seq);	// acknowledge the data
	break;
    }
}

//  WHEN A TIMEOUT OCCURS, WE RE-TRANSMIT THE MOST RECENT DATA (MESSAGE)
EVENT_HANDLER(timeouts)
{
    printf("timeout, seq=%i\n", ackexpected);
    transmit_frame(DL_DATA, &lastmsg, lastmsglength, ackexpected);
}

//  DISPLAY THE CURRENT SEQUENCE NUMBERS WHEN A BUTTON IS PRESSED
EVENT_HANDLER(showstate)
{
    printf(
    "\n\tackexpected\t= %i\n\tnextdatatosend\t= %i\n\tdataexpected\t= %i\n",
		    ackexpected, nextdatatosend, dataexpected);
}

//  THIS FUNCTION IS CALLED ONCE, AT THE BEGINNING OF THE WHOLE SIMULATION
EVENT_HANDLER(reboot_node)
{
//  ENSURE THAT WE HAVE A 2-NODE NETWORK
    if(nodeinfo.nodenumber > 1) {
	fprintf(stderr,"This is not a 2-node network!\n");
	exit(1);
    }

//  INDICATE THE EVENTS OF INTEREST FOR THIS PROTOCOL
    CHECK(CNET_set_handler( EV_APPLICATIONREADY, application_ready, 0));
    CHECK(CNET_set_handler( EV_PHYSICALREADY,    physical_ready, 0));
    CHECK(CNET_set_handler( EV_TIMER1,           timeouts, 0));

//  BIND A FUNCTION AND A LABEL TO ONE OF THE NODE'S BUTTONS
    CHECK(CNET_set_handler( EV_DEBUG0,           showstate, 0));
    CHECK(CNET_set_debug_string( EV_DEBUG0, "State"));

/*  THIS PROTOCOL IS CURRENTLY WRITTEN SO THAT ONLY NODE-0 WILL GENERATE
    AND TRANSMIT MESSAGES, AND NODE-1 WILL RECEIVE THEM.
    THIS RESTRICTION SIMPLIFIES UNDERSTANDING FOR THOSE NET TO cnet.
    THE RESTRICTION CAN EASILY BE REMOVED BY REMOVING THE LINE:

	    if(nodeinfo.nodenumber == 0)

    BOTH NODES WILL THEN TRANSMIT AND RECEIVE (WHY?)
 */
    if(nodeinfo.nodenumber == 0)
	CNET_enable_application(ALLNODES);
}
