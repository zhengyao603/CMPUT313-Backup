#include "cnetprivate.h"

// The cnet network simulator (v3.4.1)
// Copyright (C) 1992-onwards,  Chris.McDonald@uwa.edu.au
// Released under the GNU General Public License (GPL) version 2.

void CNET_check_version(const char *using)
{
    if(strcmp(using, CNET_VERSION) == 0)
	return;

    F(stderr,"This is '%s'.\n", CNET_VERSION);
    F(stderr,"Your protocol includes the header file from '%s'.\n",using);
    F(stderr,
	    "Ensure that your protocols include the correct header file,\n");
    F(stderr,
	    "remove all *.o and *%s files, and re-run the simulation.\n",
				    findenv("CNETEXT",CNETEXT));
    exit(EXIT_FAILURE);
}

void CNET_exit(const char *filenm, const char *function, int lineno)
{
    sprintf(chararray,
"Error @%" PRIdCnetTime "usec while executing %s, file %s, line %i, function %s() -\n%s: %s",
	MICROSECONDS, NP->nodename, filenm, lineno, function,
	cnet_errname[cnet_errno], cnet_errstr[cnet_errno]);

    F(stderr,"%s\n", chararray);

#if defined(USE_TCLTK)
    if(Wflag) {
	char *str	= strdup(chararray);

	CHECKALLOC(str);
	TCLTK("show_error %s \"%s\" \"%s\" %i", argv0, str, filenm, lineno);
	FREE(str);
    }
#endif
    exit(EXIT_FAILURE);
}

//  vim: ts=8 sw=4
