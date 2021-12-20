#
#  You DO NOT need to modify this file to suit your system.
#
SHELL	= /bin/sh
OS	:= $(shell uname)

ifeq ($(OS),Darwin)
    LIBNAME	:= libcnetsupport-macos.a
else ifeq ($(OS),Linux)
    LIBNAME	:= libcnetsupport-linux.a
endif

# ---------------------------------------------------------------------

DOTH	= cnetsupport.h
OBJ	= hashtable.o haversine.o lexical.o md5.o queue.o vector.o

C99	= cc -std=c99 -Wall -Werror -pedantic -O3 -fPIC


all:	$(OBJ)
	@echo linking $(LIBNAME)
	@ar rc $(LIBNAME) $(OBJ)
	@ranlib $(LIBNAME)
	@cp -p $(LIBNAME) cnetsupport.h ../lib

%.o : %.c $(DOTH)
	@echo compiling $< ; $(C99) $(CFLAGS) -c $<

clean:
	@rm -f *.a *.o core *.cnet f?

