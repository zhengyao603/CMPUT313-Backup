#include "cnetprivate.h"

// The cnet network simulator (v3.3.4)
// Copyright (C) 1992-onwards,  Chris.McDonald@uwa.edu.au
// Released under the GNU General Public License (GPL) version 2.

//  ANY FIELDS NOT EXPLICITLY INITIALIZED, HAVE THE VALUE 0, NULL, or false
NODEATTR	DEF_NODEATTR = {
	.address		= (CnetAddr)UNKNOWN,
	.icontitle		= DEFAULT_ICONTITLE,

#if	CNET_PROVIDES_APPLICATION_LAYER
	.minmessagesize		= MIN_MESSAGE_SIZE,
	.maxmessagesize		= MAX_MESSAGE_SIZE,
	.messagerate		= 1000000,
#endif

#if	CNET_PROVIDES_MOBILITY
	.position.x		= UNKNOWN,
	.position.y		= UNKNOWN,
	.position.z		= 0,

	.battery_volts		= DEFAULT_BATTERY_volts,
	.battery_mAH		= DEFAULT_BATTERY_mAH,
#endif

	.winx			= UNKNOWN,
	.winy			= UNKNOWN,
};

//  ANY FIELDS NOT EXPLICITLY INITIALIZED, HAVE THE VALUE 0, NULL, or false
GLOBALATTR	gattr = {
#if	CNET_PROVIDES_WLANS
	.drawwlans		= false,
#endif

	.mapscale		= 1.0,
	.mapmargin		= 0.0,
	.mapcolour		= "",
	.maptile		= "clouds.gif",
	.drawnodes		= true,
	.drawlinks		= true,

	// extensions
	// hiddenstats
	// nodestats
	// linkstats
};

char	*argv0;				// name of program from command-line

bool	qflag		= false;	// quiet (except during EV_DEBUGs)
int	vflag		= 0;		// debug, be verbose

#if	defined(USE_TCLTK)
bool	Wflag		= true;		// run under the windowing env.
#else
bool	Wflag		= false;	// run without the windowing env.
#endif

// ------------------- NETWORKING/TOPOLOGY VARIABLES ---------------------

int             THISNODE	= 0;
int             _NNODES		= 0;

CnetEvent	HANDLING	= EV_NULL;

int             NNODES		= 0;	// divulged with  cnet -N

NODE            *NODES		= NULL;
NODE            *NP		= NULL;	// always  &NODES[THISNODE]
RAND		*RP		= NULL;	// always  &NP->rand

CnetNodeInfo	nodeinfo;
CnetLinkInfo	*linkinfo	= NULL;

CnetError	cnet_errno	= ER_OK;
RUNSTATE	cnet_state	= STATE_PAUSED;

CnetTime	MICROSECONDS	= 0;

CnetNICaddr	NICADDR_ZERO	= { 0, 0, 0, 0, 0, 0 };
CnetNICaddr	NICADDR_BCAST	= { 255, 255, 255, 255, 255, 255 };

// -----------------------------------------------------------------------

int	nerrors		= 0;
char	chararray[4096];

// -----------------------------------------------------------------------

INPUT	input;

void init_globals(bool Bflag, const char *Cflag, bool Oflag,
		  const char *Rflag, unsigned int Sflag, bool tflag)
{
//  INITIALIZE SPECIFIC DEFAULT ATTRIBUTES
    DEF_NODEATTR.compile	= strdup(Cflag);
    CHECKALLOC(DEF_NODEATTR.compile);
    DEF_NODEATTR.stdio_quiet	= (Wflag == false || qflag);
    DEF_NODEATTR.winopen	= Oflag;
    DEF_NODEATTR.rebootfunc	= strdup(Rflag);
    CHECKALLOC(DEF_NODEATTR.rebootfunc);
    DEF_NODEATTR.trace_all	= tflag;

//  SEED THE GLOBAL RANDOM NUMBER GENERATOR
    internal_srand(gattr.Sflag = Sflag);

#if	CNET_PROVIDES_WANS
    extern void	init_defaultwan(bool);
    init_defaultwan(Bflag);
#endif
#if	CNET_PROVIDES_LANS
    extern void	init_defaultlan(bool);
    init_defaultlan(Bflag);
#endif
#if	CNET_PROVIDES_WLANS
    extern void	init_defaultwlan(bool);
    init_defaultwlan(Bflag);
#endif
}

char *format_nodeinfo(NODE *np, const char *str)
{
#if	!defined(USE_MACOS)
    extern	uint32_t htonl(uint32_t hostlong);
#endif

    char	*s, *f, *a;
    char const	*t;
    char	fmt[32];
    uint32_t	ip;

    s	= chararray;
    t	= str;
    while(*t) {
	if(*t == '%') {
	    f		= fmt;
	    *f++	= *t++;
	    while(isdigit(*t))
		*f++	= *t++;

	    switch (*t) {
//  NODE'S ADDRESS
	    case 'a':	*f++	= 'i';
			*f	= '\0';
			sprintf(s, fmt, np->nattr.address);
			while(*s) ++s;
			break;
//  NODE'S NUMBER
	    case 'i':	*f++	= 'i';
			*f	= '\0';
			sprintf(s, fmt, np - NODES);
			while(*s) ++s;
			break;
//  NODE'S ADDRESS IN DOTTED DECIMAL NOTATION
	    case 'I':	ip	=  htonl((uint32_t)np->nattr.address);
			a	= (char *)&ip;
			sprintf(s, "%i.%i.%i.%i", a[0], a[1], a[2], a[3]);
			while(*s) ++s;
			break;
//  NODE'S NAME
	    case 'n':	*f++	= 's';
			*f	= '\0';
			sprintf(s, fmt, np->nodename);
			while(*s) ++s;
			break;
//  OTHER CHARS COPIED VERBATIM
	    default :	*f	= '\0';
			strcpy(s, fmt);
			while(*s) ++s;
			break;
	    }
	}
	else
	    *s++	= *t;
	++t;
    }
    *s	= '\0';

    char *cp = strdup(chararray);
    CHECKALLOC(cp);
    return cp;
}

const char *findenv(const char *name, const char *fallback)
{
    const char	*value = getenv(name);

    if(value == NULL || *value == '\0')
	value = fallback;
    if(vflag && value)
	REPORT("%s=\"%s\"\n", name,value);
    return value;
}

//  vim: ts=8 sw=4
