#include "cnetprivate.h"

// The cnet network simulator (v3.4.1)
// Copyright (C) 1992-onwards,  Chris.McDonald@uwa.edu.au
// Released under the GNU General Public License (GPL) version 2.


static void init_nodeattrs(NODEATTR *new, NODEATTR *from_nodetype)
{
    if(from_nodetype) {
	memcpy(new, from_nodetype, sizeof(NODEATTR));
	if(from_nodetype->messagerate == 0)
	    new->messagerate	= DEFAULT;
	if(from_nodetype->minmessagesize == 0)
	    new->minmessagesize	= DEFAULT;
	if(from_nodetype->maxmessagesize == 0)
	    new->maxmessagesize	= DEFAULT;
    }
    else {
	memcpy(new, &DEF_NODEATTR, sizeof(NODEATTR));
	clone_node_vars(new);
	new->messagerate	= DEFAULT;
	new->minmessagesize	= DEFAULT;
	new->maxmessagesize	= DEFAULT;
    }
    if(new->outputfile) {
	new->outputfile	= strdup(new->outputfile);
	CHECKALLOC(new->outputfile);
    }
}

int add_node(CnetNodeType nodetype, char *name, bool defn, NODEATTR *defaults)
{
    NODE	*np;
    int		 n;

    FOREACH_NODE {
	if(strcasecmp(name, np->nodename) == 0) {
	    if(defn) {
		if(np->nodetype != (CnetNodeType)UNKNOWN)
		    FATAL("attempt to redefine node '%s'\n", name);
		NP = np;
		goto defining;
	    }
	    return(n);				// node seen before
	}
    }
    if(strlen(name) >= MAX_NODENAME_LEN) {
	WARNING("node name '%s' is too long (max is %i)\n",
		    name, MAX_NODENAME_LEN-1);
	++nerrors;				// continue anyway
    }

    NODES		= realloc(NODES, (unsigned)(_NNODES+1)*sizeof(NODE));
    CHECKALLOC(NODES);
    n			= _NNODES++;
    NP			= &NODES[n];
    RP			= &NP->rand;

    memset(NP, 0, sizeof(NODE));
    NP->nodename	= strdup(name);
    CHECKALLOC(NP->nodename);
    NP->nodetype	= (CnetNodeType)UNKNOWN;

    NP->nics		= NEW(NICATTR);
    CHECKALLOC(NP->nics);
    NP->nics[LT_LOOPBACK].linktype	= LT_LOOPBACK;
    NP->nics[LT_LOOPBACK].up		= true;
    NP->nics[LT_LOOPBACK].mtu		= MAX_MESSAGE_SIZE + 1024;

#if	CNET_PROVIDES_WANS
    NP->wans		= NEW(int);
    CHECKALLOC(NP->wans);
#endif
#if	CNET_PROVIDES_LANS
    NP->lans		= NEW(int);
    CHECKALLOC(NP->lans);
#endif

    NP->runstate	= STATE_REBOOTING;
    NP->outputfd	= UNKNOWN;

    init_nodeattrs(&NP->nattr, defaults);
#if	CNET_PROVIDES_MOBILITY
    NP->nattr.battery_volts	=
	(nodetype==NT_MOBILE) ? DEF_NODEATTR.battery_volts : 0.0;
    NP->nattr.battery_mAH	=
	(nodetype==NT_MOBILE) ? DEF_NODEATTR.battery_mAH : 0.0;
#endif

    init_nicattrs(
#if	CNET_PROVIDES_WANS
		&NP->defaultwan,
#else
		NULL,
#endif
#if	CNET_PROVIDES_LANS
		&NP->defaultlan,
#else
		NULL,
#endif
#if	CNET_PROVIDES_WLANS
		&NP->defaultwlan
#else
		NULL
#endif
		);

defining:
    if(defn == true)
	NP->nodetype	= nodetype;
    NP->nattr.address	= (CnetAddr)n;

    return n;
}

#if	CNET_PROVIDES_WLANS
void clone_mobile_node(int orig, int ntimes)
{
    char	newname[256];
    char	*fmt;
    NODE	*npt, *npo;

    if(ntimes >= 100)
	fmt	= "%s%03i";
    else if(ntimes >= 10)
	fmt	= "%s%02i";
    else
	fmt	= "%s%0i";

    for(int n=1 ; n<ntimes ; ++n) {
	int	thisnode;

	npo	= &NODES[orig];
	sprintf(newname, fmt, npo->nodename, n);
	thisnode = add_node(npo->nodetype, newname, true, &npo->nattr);

	npo	= &NODES[orig];
	npt	= &NODES[thisnode];

	for(int w=0 ; w<npo->nwlans ; ++w) {
	    extern NICATTR      *add_wlan(int thisn);

	    add_wlan(thisnode);
#if 0
	    NICATTR	*nic = add_wlan(thisnode);

	    memcpy(nic, &npo->wlans[w], sizeof(*nic));
#endif
	}

        npt->nattr.compile	= strdup(npo->nattr.compile);
	CHECKALLOC(npt->nattr.compile);
        npt->nattr.rebootfunc	= strdup(npo->nattr.rebootfunc);
	CHECKALLOC(npt->nattr.rebootfunc);
    }

//  PATCH THE nodename OF THE ORIGINAL NODE
    npo	= &NODES[orig];
    sprintf(newname, fmt, npo->nodename, 0);
    free(npo->nodename);
    npo->nodename	= strdup(newname);
    CHECKALLOC(npo->nodename);
}
#endif

// ------------------------------------------------------------------------

typedef struct _n {
    char		*name;
    CnetNodeType	nodetype;
    NODEATTR		nattr;
    struct _n		*next;
} NTLIST;

static NTLIST	*nt_head	= NULL;

NODEATTR *add_nodetype(CnetNodeType ntype, char *name)
{
    NTLIST	*new = nt_head;

    while(new) {
	if(strcasecmp(name, new->name) == 0) {
	    WARNING("nodetype '%s' redefined\n", name);
	    break;
	}
	new	= new->next;
    }
    new			= NEW(NTLIST);
    CHECKALLOC(new);
    new->name		= strdup(name);
    CHECKALLOC(new->name);
    new->nodetype	= ntype;
    init_nodeattrs(&new->nattr, NULL);

    new->next		= nt_head;
    nt_head		= new;
    return(&nt_head->nattr);
}

NODEATTR *find_nodetype(char *name, CnetNodeType *type)
{
    NTLIST	*ntp = nt_head;

    while(ntp) {
	if(strcasecmp(name, ntp->name) == 0) {
	    *type	= ntp->nodetype;
	    return(&ntp->nattr);
	}
	ntp	= ntp->next;
    }
    return(NULL);
}

void print_nodetypes(FILE *topfp)
{
    extern void print_node_attr(int always, NODEATTR *me, const char *indent);

    NTLIST	*ntp = nt_head;

    while(ntp) {
	char	*desc = NULL;

	switch (ntp->nodetype) {
	case NT_ACCESSPOINT :	desc = "accesspointtype";	break;
	case NT_HOST :		desc = "hosttype";		break;
	case NT_MOBILE :	desc = "mobiletype";		break;
	case NT_ROUTER :	desc = "routertype";		break;
	}
	F(topfp, "%s %s {\n", desc, ntp->name);
	print_node_attr(false, &ntp->nattr, "    ");
	F(topfp, "}\n\n");
	ntp	= ntp->next;
    }
}


// ------------------------------------------------------------------------

int CNET_get_nodestats(CnetNodeStats *stats)
{
    int	result = 0;

    if(stats == NULL) {
	ERROR(ER_BADARG);
	result	= -1;
    }
    else
	memcpy(stats, &NP->nodestats, sizeof(CnetNodeStats));

    if(gattr.trace_events) {
	if(result == 0)
	    TRACE(0, "\t%s(%s) = 0\n", __func__, find_trace_name(stats));
	else
	    TRACE(1, "\t%s(NULL) = -1 %s\n",
			__func__, cnet_errname[(int)cnet_errno]);
    }
    return result;
}

//  vim: ts=8 sw=4
