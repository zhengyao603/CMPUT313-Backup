
NAME	= cnet
SHELL	= /bin/sh
OS	:= $(shell uname)

ifndef	TCLTKVERSION
TCLTKVERSION	= 8.6
endif

ifeq ($(OS),Darwin)
# For	macOS Darwin (10.6.4 onwards)
#
    BREW_TCLTK		= /usr/local/opt/tcl-tk
    TCLTK_INCLUDE	= $(BREW_TCLTK)/include

    INCLUDES	= -I$(TCLTK_INCLUDE)
    CC		= cc -std=c99 -Wall -Werror -pedantic
    CFLAGS	= -O3 $(INCLUDES) -DTCLTK_INCLUDE=\"$(TCLTK_INCLUDE)\"
    LD		= cc -multiply_defined suppress
    LIBDIRS	= -L$(BREW_TCLTK)/lib
    LIBS	= -ltcl$(TCLTKVERSION) -ltk$(TCLTKVERSION)
    OS_COMPILE	= compile/macos.c

else ifeq ($(OS),Linux)
# For	Linux ELF systems (kernel 2.4 onwards)
#
    WARNINGS =	-Wall -Werror -Wshadow -Wpointer-arith -Wcast-qual \
		-Wcast-align -Wwrite-strings -Wconversion \
		-Wstrict-prototypes -Wredundant-decls -Winline \
		-Wcomments -Wtrigraphs -Wimport -Wundef
#
    INCLUDES	= -I/usr/include/tcl$(TCLTKVERSION)
    CC		= cc -std=c99 -Wall -Werror -pedantic
    CFLAGS	= -O3 -fPIC $(INCLUDES)
    LD		= cc -rdynamic
    LIBDIRS	=
#    LIBELF	= /usr/lib64/libelf-0.176.so
    LIBELF      = -lelf
    LIBS	= -ltcl$(TCLTKVERSION) -ltk$(TCLTKVERSION) $(LIBELF) -lX11 -ldl -lm
    OS_COMPILE	= compile/linux.c

else ifeq ($(OS),FreeBSD)
# For	FreeBSD (5.1-RELEASE)
#
    INCLUDES	= -I/usr/local/include \
		  -I/usr/local/include/tcl8.3 \
		  -I/usr/local/include/tk8.3 \
		  -I${X11BASE}/include
    CC		= gcc -std=c99 -pedantic -Wall
    CFLAGS	= -fPIC $(INCLUDES)
    LD		= $(CC( -rdynamic
    LIBDIRS	= -L/usr/local/lib
    LIBS	= -lXpm -lX11 -lm -L${X11BASE}/lib -ltcl83 -ltk83 -lm -lgnuregex
    OS_COMPILE	= compile/freebsd.c

else ifeq ($(OS),NetBSD)
# For	NetBSD
#
    INCLUDES	= -I/usr/pkg/include -I/usr/X11R6/include
    CC		= gcc -std=c99 -pedantic -Wall
    CFLAGS	= -O $(INCLUDES)
    LD		= gcc -rdynamic
    LIBDIRS	= -L/usr/pkg/lib -L/usr/X11R6/lib -Wl,-R/usr/pkg/lib:/usr/X11R6/lib
    LIBS	= -ltcl83 -ltk83 -lX11 -lm
    OS_COMPILE	= compile/netbsd.c

else ifeq ($(OS),OSF1)
# For	OSF/1 V4.0 on a DEC Alpha
#
    INCLUDES	= -I/usr/local/include -I/usr/contrib/include
    CC		= gcc -std=c99 -pedantic -Wall
    CFLAGS	= -O $(INCLUDES)
    LD		= gcc
    LIBDIRS	= -L/usr/local/lib -L/usr/contrib/lib
    LIBS	= -ltcl -ltk -lX11 -lm
    OS_COMPILE	= compile/osf1.c

else ifeq ($(OS),IRIX)
# For	SGI's IRIX-5.3
#
    INCLUDES	= -I/usr/include/X11
    CC		= gcc -std=c99 -pedantic -Wall
    CFLAGS	= -O $(INCLUDES)
    LD		= gcc
    LIBDIRS	= -L/usr/lib
    LIBS	= -ltcl -ltk -lX11 -lm -lelf -lmld -lm 
    OS_COMPILE	= compile/irix5.c

else ifeq ($(OS),SunOS\ 5)
# For	Sun's Solaris, >= Solaris.[23]
#
    INCLUDES	=
    CFLAGS	= -O $(INCLUDES)
    CC		= gcc -std=c99 -pedantic -Wall
    LD		= gcc
    LIBDIRS	= -L$(OPENWINHOME)/lib
    LIBS	= -ltcl -ltk -lX11 -lm -ldl -lelf -lgen -lm
    OS_COMPILE	= compile/solaris.c

else ifeq ($(OS),SunOS\ 4)
# For	Sun's SunOS, >= SunOS4.1.2
#
    INCLUDES	=
    CFLAGS	= -O $(INCLUDES)
    CC		= gcc -std=c99 -pedantic -Wall
    LD		= gcc
    LIBDIRS	= -L/usr/local/lib
    LIBS	= -ltcl -ltk -lX11 -lm -ldl -lm
    OS_COMPILE	= compile/sunos.c
endif

# ---------------------------------------------------------------------

OBJ	= applicationlayer.o battery.o checksums.o cnetmain.o\
	    compile.o drawframes.o error.o events.o exit.o format64.o\
	    globals.o images.o keyboard.o\
	    lan.o leds.o lexical.o links.o mainwindow.o motd.o\
	    nics.o nicmenu.o nicwindows.o nodes.o nodemenu.o nodewindows.o\
	    parser.o physicallayer.o poisson.o position.o queuing.o rand.o\
	    save.o scheduler.o shmem.o statistics.o stdapplication.o stdio.o\
	    tcltkfunctions.o timers.o topology.o trace.o vars.o\
	    wan.o wlan.o

DOTH	= cnet.h cnetprivate.h preferences.h\
	    rand.h tcltkfunctions.h hidenames.h

LEXICAL		= lexical.h
STATISTICS	= statistics.h
PHYSICAL	= physicallayer.h
SCHEDULER	= scheduler.h

# -------------------------------------------------------------------------

$(NAME):	$(OBJ)
		@echo linking $(NAME)
		@$(LD) -o $(NAME) $(OBJ) $(LIBDIRS) $(LIBS)
		@chmod 755 $(NAME)
		@cp -p $(NAME) ../bin
		@cp -p cnet.h  ../lib

compile.o:	compile.c $(OS_COMPILE)
	@echo compiling $< ; $(CC) $(CFLAGS) -DLIBDIR=\"$(LIBDIR)\" \
		-DOS_COMPILE=\"$(OS_COMPILE)\" -c $<

lexical.o:	lexical.c $(DOTH) $(LEXICAL)
	@echo compiling $< ; $(CC) $(CFLAGS) -c $<

parser.o:	parser.c $(DOTH) $(LEXICAL)
	@echo compiling $< ; $(CC) $(CFLAGS) -c $<

queuing.o:	queuing.c $(DOTH) $(SCHEDULER)
	@echo compiling $< ; $(CC) $(CFLAGS) -c $<

scheduler.o:	scheduler.c $(DOTH) $(SCHEDULER) $(PHYSICAL)
	@echo compiling $< ; $(CC) $(CFLAGS) -c $<

physicallayer.o:	physicallayer.c $(DOTH) $(PHYSICAL)
	@echo compiling $< ; $(CC) $(CFLAGS) -c $<

wan.o:	wan.c $(DOTH) $(PHYSICAL)
	@echo compiling $< ; $(CC) $(CFLAGS) -c $<

lan.o:	lan.c $(DOTH) $(PHYSICAL)
	@echo compiling $< ; $(CC) $(CFLAGS) -c $<

wlan.o:	wlan.c $(DOTH) $(PHYSICAL)
	@echo compiling $< ; $(CC) $(CFLAGS) -c $<

%.o : %.c $(DOTH)
	@echo compiling $< ; $(CC) $(CFLAGS) -c $<

# ---------------------------------------------------------------------

clean:
	@rm -f $(NAME) *.o *.cnet f?

hide:
	@make --no-print-directory clean
	echo '#if	HIDE_GLOBAL_NAMES'	 > hidenames.h
	sort < HIDENAMES | \
	awk '/^[A-Za-z]/ { printf("#define\t%-36s\t__CN%03d\n", $$0,++n);}'\
						>> hidenames.h
	echo '#endif'				>> hidenames.h

