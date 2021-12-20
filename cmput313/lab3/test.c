#include <stdio.h>

typedef struct{
	double x;
	double y;
} CnetPosition;

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


int main(){
	printf("%lu\n", sizeof(WLAN_FRAME));

	return 0;
}