#include "cnetprivate.h"

//  The cnet network simulator (v3.4.1)
//  Copyright (C) 1992-onwards,  Chris.McDonald@uwa.edu.au
//  Released under the GNU General Public License (GPL) version 2.


//  THE motd() FUNCTION WILL BE CALLED EARLY FROM main() TO GIVE YOU
//  A CHANCE TO PROVIDE ANY MESSAGE-OF-THE-DAY TO STUDENTS.
//  EXAMPLES MAY INCLUDE ANY RECENTLY DISCOVERED PROBLEMS (?) OR
//  MODIFICATIONS TO PROJECT REQUIREMENTS.

#define	MOTD_FILE	"/cslinux/examples/CITS3230/cnet.motd"

void motd(void)			// called from cnetmain.c:main()
{
#if	defined(MOTD_FILE)
    FILE	*fp = fopen(MOTD_FILE, "r");

    if(fp != NULL) {
	char	line[BUFSIZ];

	while(fgets(line, sizeof(line), fp))
	    fputs(line, stdout);
	fclose(fp);
    }
#endif
}

//  vim: ts=8 sw=4
