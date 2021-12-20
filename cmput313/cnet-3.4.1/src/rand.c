#include "cnetprivate.h"

//  The cnet network simulator (v3.4.1)
//  Copyright (C) 1992-onwards,  Chris.McDonald@uwa.edu.au
//  Released under the GNU General Public License (GPL) version 2.


//  IN THIS FILE WE PROVIDE IMPLEMENTATIONS OF THE STANDARD C99
//  FUNCTIONS srand() AND rand(), SO THAT EACH NODE MAY CALL
//  THESE INDEPENDENTLY OF OTHER NODES.

//  https://stackoverflow.com/questions/18634079/glibc-rand-function-implementation
//  https://www.mscs.dal.ca/~selinger/random/

void srand(unsigned int seed)
{
    unsigned int *r	= RP->r;

    r[0] = seed+1;			// seed cannot be 0
    for(int i=1; i < 31; i++) {
	r[i] = (unsigned int)((16807 * (unsigned long)r[i-1]) % 2147483647);
//	if(r[i] < 0) {                  // can this ever happen?
//	    r[i] += 2147483647;
//	}
    }
    for(int i=31; i < 34; i++) {
	r[i] = r[i-31];
    }
    for(int i=34; i < RAND_N344; i++) {
	r[i] = r[i-31] + r[i-3];
    }
    RP->n	= 0;
}

int rand(void)
{
    unsigned int *r	= RP->r;
    unsigned int x	= r[RP->n % RAND_N344] =
	r[(RP->n + 313) % RAND_N344] + r[(RP->n + 341) % RAND_N344];

    RP->n		= (RP->n + 1) % RAND_N344;
    return (int)(x >> 1);
}

// ----------------------------------------------------------------

static	RAND	internal_RAND;

void internal_srand(unsigned int seed)
{
    RAND *save	= RP;

    RP	= &internal_RAND;
    srand(seed);
    RP	= save;
}

int internal_rand(void)
{
    RAND *save	= RP;

    RP	= &internal_RAND;
    int r = rand();
    RP	= save;
    return r;
}

//  vim: ts=8 sw=4
