
//  The cnet network simulator (v3.4.1)
//  Copyright (C) 1992-onwards,  Chris.McDonald@uwa.edu.au
//  Released under the GNU General Public License (GPL) version 2.

//  https://stackoverflow.com/questions/18634079/glibc-rand-function-implementation
//  https://github.com/lattera/glibc/blob/master/stdlib/random_r.c

#ifndef _RAND_H_
#define _RAND_H_

#define	RAND_N344	344

typedef struct {
    unsigned int	r[RAND_N344];
    int			n;
} RAND;

extern	void	internal_srand(unsigned int seed);
extern	int	internal_rand(void);

#endif

//  vim: ts=8 sw=4
