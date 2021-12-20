#include <cnet.h>
#include <stdlib.h>
#include <string.h>

#define	FREQ		500000

EVENT_HANDLER(timeouts)
{
    printf("%3i\n", rand() % 100 );
    CNET_start_timer(EV_TIMER1, FREQ, 0);
}

EVENT_HANDLER(reboot_node)
{
//    srand( nodeinfo.nodenumber );
    CHECK(CNET_set_handler( EV_TIMER1,           timeouts, 0));
    CNET_start_timer(EV_TIMER1, FREQ, 0);
}
