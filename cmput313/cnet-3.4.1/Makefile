NAME		= cnet
VERSION		= 3.4.1
SHELL		= /bin/sh
#
# ---------------------------------------------------------------------
# Change/uncomment the following 5 constants to suit your system.
# If referring to your home directory, specify $(HOME), not ~
#
# PREFIX defines the directory below which cnet will be installed.
PREFIX		= /usr/local
#PREFIX		= $(HOME)
#
# BINDIR defines the directory where the cnet executable will be installed.
BINDIR		= $(PREFIX)/bin
#
# LIBDIR defines the directory where cnet's support files will be installed.
LIBDIR		= $(PREFIX)/lib/cnet
#
# DOCDIR defines the directory to hold cnet's web-based documentation
DOCDIR		= /home/httpd/html/cnet
#DOCDIR		= /Library/WebServer/Documents     # for macOS ?
#DOCDIR		= $(HOME)/WWW/cnet
#
# The version of Tcl/Tk on your system (e.g. 8.5 or 8.6)
TCLTKVERSION    = 8.6
#
# ---------------------------------------------------------------------
#
export	LIBDIR TCLTKVERSION
#
all:
	@make --no-print-directory -C src
	@make --no-print-directory -C support

install:
	make --no-print-directory
	mkdir -p -m 755 $(BINDIR) $(LIBDIR)
	@cp bin/$(NAME) $(BINDIR)/$(NAME)
	@chmod 755 $(BINDIR)/$(NAME)
	@rm -rf $(LIBDIR)/*
	@cp lib/* $(LIBDIR)
	@chmod 644 $(LIBDIR)/*
	@echo "$(NAME) executable program:    $(BINDIR)/$(NAME)"
	@echo "directory of runtime files: $(LIBDIR)/"

doc:
	mkdir -p -m 755 $(DOCDIR) $(DOCDIR)/images
	@cp php/*.* $(DOCDIR)
	@cp php/images/*.* $(DOCDIR)/images
	@cp examples/click/{CLICK,click.c} $(DOCDIR)
	@cp examples/ticktock/{TICKTOCK,ticktock.c} $(DOCDIR)
	@cp examples/keyboard/{KEYBOARD,keyboard.c} $(DOCDIR)
	@cp examples/stopandwait/{STOPANDWAIT,stopandwait.c} $(DOCDIR)
	@chmod 644 $(DOCDIR)/images/*.* $(DOCDIR)/*
	@chmod 755 $(DOCDIR)/images


# ---------------------------------------------------------------------

clean:
	make --no-print-directory -C src clean
	make --no-print-directory -C support clean
	make --no-print-directory -C examples clean
	rm -rf bin/$(NAME) lib/*.a

uninstall:
	rm -rf $(BINDIR)/$(NAME) $(LIBDIR) $(DOCDIR)

