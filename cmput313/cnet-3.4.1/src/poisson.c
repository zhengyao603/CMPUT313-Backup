#include "cnetprivate.h"

// The cnet network simulator (v3.4.1)
// Copyright (C) 1992-onwards,  Chris.McDonald@uwa.edu.au
// Released under the GNU General Public License (GPL) version 2.

static int poisson(double mean)
{
    double L	= exp(-mean);
    double p	= 1.0;
    int k	= 0;

    do {
	++k;
	p *= internal_rand() / (double)RAND_MAX;
    } while(p > L);
    return --k;
}

CnetTime poisson_usecs(CnetTime mean_usecs)
{
    double lambda	= mean_usecs;
    double mult		= 1.0;

    while(lambda > 64.0) {
	lambda	= lambda / 2.0;
	mult	= mult   * 2.0;
    }
    return (CnetTime)(poisson(lambda) * mult);
}

//  vim: ts=8 sw=4
