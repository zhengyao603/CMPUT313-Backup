#include "dll_basic.h"

 /* THIS FILE PROVIDES A MINIMAL RELIABLE DATALINK LAYER.  IT AVOIDS ANY
    FRAME LOSS AND CORRUPTION AT THE PHYSICAL LAYER BY CALLING
    CNET_write_physical_reliable() INSTEAD OF CNET_write_physical().
    BECAUSE "NOTHING CAN GO WRONG", WE DON'T NEED TO MANAGE ANY SEQUENCE
    NUMBERS OR BUFFERS OF FRAMES IN THIS LAYER, AND OUR DLL_FRAME
    STRUCTURE CAN CONSIST OF JUST ITS PAYLOAD (THE NL's PACKETS).
 */

typedef struct {
// AS WE USE A RELIABLE DATALINK, WE DON'T NEED ANY OTHER FIELDS
    char        packet[MAX_FRAME_SIZE];
} DLL_FRAME;


//  down_to_datalink() RECEIVES PACKETS FROM THE NETWORK LAYER (ABOVE)
int down_to_datalink(int link, char *packet, size_t length)
{
//  NOTE THAT WE'RE NOT WRAPPING CNET_write_physical_reliable() IN A CALL
//  TO CHECK().  IN WEAKER PROTOCOLS, THIS FUNCTION WILL SATURATE THE
//  PHYSICAL-LAYER, INDICATING:
//        ER_TOOBUSY: Function is too busy/congested to handle request
//
    CNET_write_physical_reliable(link, packet, &length);
    return 0;
}


/*  up_to_datalink() RECEIVES FRAMES FROM THE PHYSICAL LAYER (BELOW) AND,
    KNOWING THAT OUR PHYSICAL LAYER IS RELIABLE, IMMEDIATELY SENDS THE
    PAYLOAD (A PACKET) UP TO THE NETWORK LAYER.
 */
static EVENT_HANDLER(up_to_datalink)
{
    extern int up_to_network(char *packet, size_t length, int arrived_on);

    DLL_FRAME	f;
    size_t	length;
    int		link;

    length	= sizeof(DLL_FRAME);
    CHECK(CNET_read_physical(&link, &f, &length));

    CHECK(up_to_network(f.packet, length, link));
}

void reboot_DLL(void)
{
    CHECK(CNET_set_handler(EV_PHYSICALREADY,	up_to_datalink, 0));
//  NOTHING ELSE TO DO!
}
