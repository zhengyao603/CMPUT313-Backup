#include <dlfcn.h>
#include <nlist.h>

// The cnet network simulator (v3.4.1)
// Copyright (C) 1992-onwards,  Chris.McDonald@uwa.edu.au
// Released under the GNU General Public License (GPL) version 2.

static int add_compile_args(int ac, char *av[])
{
    return(ac);			// nothing to add
}

static int add_link_args(int ac, char *av[])
{
    av[ac++] =	"-p";		// align data seg. on PAGSIZ boundary
    av[ac++] =	"-d";
    return(ac);
}


static void data_segments(int n, void *handle, char *so_filenm)
{
    extern int	 	nlist(const char *, struct nlist *);

    typedef struct _c {
	char		*so_filenm;
	unsigned long	length_data;
	char		*incore_data;
	char		*original_data;
	struct _c	*next;
    } CACHE;

    static CACHE	*chd = NULL;
    CACHE		*cp  = chd;

    NODE		*np	= &NODES[n];
    struct nlist	nls[3];

    while(cp != NULL) {
	if(strcmp(cp->so_filenm, so_filenm) == 0)
	    goto found;
	cp	= cp->next;
    }

    nls[0].n_name	= "__DYNAMIC";
    nls[1].n_name	= "_end";
    nls[2].n_name	= NULL;

    if(nlist(so_filenm, nls) != 0) {
	F(stderr,"%s: cannot load symbols from %s\n",
					argv0,so_filenm);
	++nerrors;
	return;
    }

    cp			= malloc(sizeof(CACHE));
    cp->so_filenm	= strdup(so_filenm);
    cp->length_data	= (nls[1].n_value - nls[0].n_value);
    cp->incore_data	= (char *)((long)dlsym(handle,"end") - cp->length_data);
    cp->original_data	= malloc(cp->length_data);
    memcpy(cp->original_data, cp->incore_data, cp->length_data);
    cp->next		= chd;
    chd			= cp;

    if(vflag)
	F(stderr,"%s dataseg=0x%08lx len(dataseg)=%ld\n",
			    so_filenm, (long)cp->incore_data, cp->length_data);
found:

    np->length_data[0]		= cp->length_data;
    np->incore_data[0]		= cp->incore_data;
    np->original_data[0]	= cp->original_data;

    np->private_data[0]		= malloc(cp->length_data);
    memcpy(np->private_data[0], cp->original_data, cp->length_data);
}

//  vim: ts=8 sw=4
