<?php require_once("cnet-header.php"); ?>

<div style="line-height: 1.3em;">

<h1><i>cnet</i> Changelog</h1>

<p>
<i>cnet</i>'s version number changes when a change to its source
code affects <i>cnet</i>'s execution semantics.
The version number does not change if (only) cosmetic changes are made
to the source code or GUI, or if the documentation changes.
</p>

<h1>Version 3.4 - from March 2020</h1>

<ul>
<li> v3.4.1 - Added instructions for installing on
    Windows Subsystem for Linux (WSL), under Windows-10.
    <br>
    Added support for macOS's DarkMode (Mojave, 10.4 onwards).
    <br>
    Corrected a bug in which output filenames requested by the 
    <a href="options.php#option-o">-o</a> command-line option,
    were not unique for each node.

<li> v3.4.0 - Lots of refactoring.
    <br>
    Corrected a bug on some Linux distributions in which the
	symbol "_end" was not being defined in shared objects
	(thanks to Peter Elliott, Univ. of Alberta).
    <br>
    Under macOS we now use Tck/Tk provided by Homebrew,
	(rather than the outdated version packaged with XCode),
	and no longer require XQuartz.
    <br>
    Implementation of per-node functions for C99's <code>srand</code> and <code>rand</code>.
    <br>
    Improved implementation of internal Poisson distribution function.
    <br>
    Documentation changed from basic HTML to basic PHP.
    <br>
    Removed - <code>CNET_srand</code>, <code>CNET_rand</code>,
	<code>CNET_newrand</code>, and <code>CNET_nextrand</code>,
	and internal use of Mersenne Twister functions.
    <br>
    Removed - removed support for execution on iPods.
	Ahhh, jailbreaking was fun.
    <p>
</li>
</ul>

<h1>Version 3.3 - from June 2013 (no longer supported)</h1>

<ul>
<li> v3.3.4 - Cleaned up code to address 'new' warnings from an
    updated gcc on Linux.
<li> v3.3.3 - Corrected a bug in <code>compile.c</code> which prevented correct
    parsing of compilation string.
    <br>
    Changed calls to <code>abs()</code> to <code>fabs()</code>, in <code>lan.c</code>
<li> v3.3.2 - Corrected a bug in which AL errors were not updated on the GUI.
    <br>
    Added <a href="options.php#option-G">-G</a> command-line option,
    equivalent to -WTgqz.
<li> v3.3.1 - Added compile-time support for XQuartz under macOS.
    <br>
    Corrected use of <code>Tcl_SetObjResult()</code> to report errors.
<li> v3.3.0 - The <code>x,y,z</code> fields of <code>CnetPosition</code> are now
    of type <code>double</code> to better support mapping.
    <br>
    Added the functions
    <code>CNET_Wflag()</code>,
    <code>CNET_vflag()</code>,
    <code>CNET_get_mapmargin()</code>, and
    <code>TCLTK_interp()</code>.
    <br>
    Support added for global- and per-node variables in topology files,
    accessed from protocols using the new
    <a href="api_getvar.php"><code>CNET_getvar()</code></a> function.
    <br>
    Added the
    <a href="api_unused_timer_event.php"><code>CNET_unused_timer_event()</code></a>
    and
    <a href="api_unused_debug_event.php"><code>CNET_unused_debug_event()</code></a>
    functions.
    <br>
    Changes made to Tcl/Tk code to correctly use
    <code>Tcl_GetStringResult()</code> and <code>Tcl_EvalEx()</code>.

</ul>


<h1>Version 3.2 - from September 2009 (no longer supported)</h1>

<ul>
<li> v3.2.4 - Removed the ability (gimmick) to set a node's operating system
    type and icon.

    Added <a href="options.php#option-Q">-Q</a> command-line option
    to (silently) ignore out-of-sequence errors in the Application Layer.

    Changed code to enable clean compilations on Ubuntu Linux,
    where <code>-Wunused-but-set-variable</code> is set by default.

<li> v3.2.3 - wish I'd kept this up-to-date
<li> v3.2.2 - wish I'd kept this up-to-date
<li> v3.2.1 - Correction made to gathering of LAN statistics.

    The <a href="options.php#option-S">-S</a> command-line option now correctly
    replaces (overrides)
    the seed parameter to <code>CNET_srand()</code> and <code>CNET_newrand()</code>.

<li> v3.2.0 - Support added for 64-bit macOS.

    Support added for Tcl/Tk v8.5 (now preferred).

    Support added for Ubuntu Linux (return value of write() captured).

    Documentation rewritten, providing Unix-manual-like pages for each
    function.

</ul>

<h1>Version 3.1 - from October 2007 (no longer supported)</h1>

<ul>
<li> v3.1.4 - Added the <a href="api_shmem.php"><code>CNET_shmem2()</code></a>
	function.

<li> v3.1.3 - Corrected memory allocation for WLAN nodes.

     Refactored some Tcl/Tk for event and statistics updates.

     Corrected the information provided by
    <a href="api_set_wlanstate.php"><code>CNET_get_wlanstate</code></a>.

     New documentation for core data structures
    <code>nodeinfo</code> and <code>linkinfo</code>.

<li> v3.1.2 - Corrected a bug processing the -D, -U, and -I command-line
    options.

    Corrected a bug in <code>CNET_write_physical</code> which caused
    a crash when scheduling frame collisions.

    The <code>-z</code> command-line option now implies <code>-s</code>.

    The buffer and message parameters of
    <code>CNET_read_physical</code>,
    <code>CNET_write_physical</code>,
    <code>CNET_write_physical_reliable</code>,
    <code>CNET_write_direct</code>,
    <code>CNET_read_application</code>, and
    <code>CNET_write_application</code>
    are now of type
    <code><b>void</b>&nbsp;*</code> or
    <code><b>const void</b>&nbsp;*</code>
    (were <code><b>char</b>&nbsp;*</code> or
    <code><b>const char</b>&nbsp;*</code>).

    The icons of mobile nodes are now always raised on the map.

    Simplified handling of fonts in Tc/Tk.

    Corrected some of the map layout to correctly honour map-scaling.

<li> v3.1.1 - Added the
    <a href="api_get_mapscale.php"><code>CNET_get_mapscale</code></a>
    function.

    Modified the calculation of distance between two (mobile) nodes.

    Included memory alignment in the calculation of per-node data segment size
    for macOS.

    Corrected Makefile for <i>make&nbsp;uninstall</i>.
</ul>

<h1>Version 3.0 - from November 2004 (no longer supported)</h1>

<p>
<ul>
<li> v3.0.20 - Supported on 64-bit Linux distributions.

    Signal-strength "bars" added to the popup windows of nodes with WLANs.

    The <code>CnetColour</code> type is now just a C string.

    Random number generation functions renamed to
    <a href="api_rand.php"><code>CNET_srand</code></a>,
    <a href="api_rand.php"><code>CNET_rand</code></a>,
    <a href="api_rand.php"><code>CNET_newrand</code></a>, and
    <a href="api_rand.php"><code>CNET_nextrand</code></a>.

<li> v3.0.19 - Corrections made to link bandwidth calculations.

<li> v3.0.18 - Support for vectors of data added to the support API.

<li> v3.0.17 - Correction to calculation of frame collision statistics.
    Correction to a rare problem where sleeping <code>LT_WLAN</code>
    links could receive frames.

<li> v3.0.16 - <code>&lt;cnet.h&gt;</code> now includes <code>&lt;math.h&gt;</code>,
    and the standard C mathematics library (-lm) is now linked in by default.

    Added simple macros to convert between dBm and mW.

    Corrected a bug in the hashtable_new() support function.

    Added one-button support for macOS
	(thanks to Michael Rogers, Tennessee Tech.Univ.).

<li> v3.0.15 - Improved collision handling for <code>LT_WLAN</code> links.

<li> v3.0.14 - Added the <code>positionerror</code> global attribute.

    Corrected image scaling and node positioning
    on the simulation map.

<li> v3.0.13 - Added the <code>&lt;cnetsupport.h&gt;</code> header file,
    the <code>support</code> source directory,
    automatic linking against the <code>libcnetsupport.a</code> library,
    and its associated documentation.

    Each node's <code>outputfile</code> attribute may now be
    formatted like the <code>icontitle</code> attribute.

    Corrected a bug causing events to be lost when the
    simulation was paused from the GUI.

<li> v3.0.12 - Added the <code>EVENT_HANDLER</code> macro to
	<code>&lt;cnet.h&gt;</code>.

    Changed the data type of many function paramters describing
    length from <code>int</code> or <code>unsigned int</code> to <code>size_t</code>.

    New functions <code>CNET_printf</code>, <code>CNET_puts</code>, and
    <code>CNET_putchar</code> introduced to overcome Darwin's prebinding of
    shared libraries. These functions are not traced.

<li> v3.0.11 - The dataframes on any number of <code>LT_WAN</code>
    links may are now drawn on their own canvas.

    You may view a <code>LT_WAN</code> link's frames by clicking the
    right mouse button (control-click on Macintoshes) on the link.

    An internal default event handler for the <code>EV_DRAWFRAME</code> is provided.
    Added the <code>jitter</code> attribute to all linktypes.

<li> v3.0.10 - Datatypes <code>WLANRESULT</code> and <code>WLANSIGNAL</code>,
    and the function <code>CNET_set_wlan_model</code>, introduced.

    Datatype <code>CnetPosition</code> introduced, and functions
    <code>CNET_get_position</code> and <code>CNET_get_position</code>
    modified to receive their parameters of this type.

    <code>ER_CORRUPTDATA</code> renamed to <code>ER_CORRUPTFRAME</code>.
    Two new events - <code>EV_PERIODIC</code> and <code>EV_UPDATEGUI</code>.

    Introduced the <code>-x</code> option and support for extension modules.
    Corrected handling of <code>-N</code> option.

<li> v3.0.9 - Two new error values introduced: <code>ER_DUPLICATEMSG</code> and
    <code>ER_MISSINGMSG</code>.  These replace <code>ER_OUTOFSEQ</code>.

    New enumerated type <code>CnetColour</code> introduced.

    Function <code>CNET_set_LED</code> added.

    Tracing of Application and Physical Layer functions improved.

    Scheduling of EV_DEBUG events corrected.

<li> v3.0.8 - Each WLAN's signal strength "circle" expands so as to
    reach all nodes that hear its signal.

    Tcl/Tk scripting improved for macOS.

<li> v3.0.7 - New files scheduler.h and queuing.c support Calendar
    queuing of pending events, supporting much faster simulations with
    several hundred, or several thousand, pending events.

    Uses the POSIX <code>getopt</code> function to parse arguments,
    so we can now use:<br>
    <code>cnet&nbsp;-gsT&nbsp;-u100s&nbsp;FLOODING</code>
    <br>

    Event tracing now appears in an additional popup window,
    and highlights API calls that fail.

<li> v3.0.6 - Transmissions with <code>CNET_write_physical</code> on
    <code>LT_WLAN</code> links now 'cause' collisions at the destination(s)
    if two or more overlapping-in-time signals arrive.

    Transmissions with <code>CNET_write_physical_reliable</code> on
    <code>LT_WLAN</code> links do not 'cause' collisions.

    New function <code>CNET_carrier_sense</code> indicates if a
    <code>LT_LAN</code> or <code>LT_WLAN</code> link can sense any arriving signal.

    Nodes and NICs that are sleeping "remember" that a
    signal is passing them, so that when they awaken they may not
    immediately be able to transmit successfully.

    The new <code>-B</code> command-line option disables buffering on
    <code>LT_LAN</code> or <code>LT_WLAN</code> links -
    you cannot transmit a new frame while one is still being sent.
    Each link type accepts a new Boolean attribute in the topology file,
    such as  <code>wlan-buffered&nbsp;=&nbsp;false</code> to indicate
    if it's buffering.

    The new <code>-i</code> command-line option
    now reports instantaneous statistics
    (existing -s option reports cumulative statistics).

    The new <code>-J</code> command-line option
    permits you to just compile the indicated *.c files to their *.o files
    (to support pre-compiled libraries/layers for students).

    If the topology file name is "-",
    it will be read from standard input.

    The scheduler now detects/warns if there
    are no more (non-interactive) events scheduled.

    The first parameter passed to <code>CNET_read_physical</code>
    may be <code>NULL</code> if you don't require the link number of the
    arriving frame.

    New topology file attributes: <code>bgcolour</code>,
    <code>bghex</code>, <code>drawnodes</code>, and <code>drawlinks</code>.

<p>

<li> <b>major changes:</b>
<li> <i>cnet</i>'s own code, and the protocols that <i>cnet</i> executes
    are now written in ISO-C99 (no longer just ANSI-C89).
    This provides native 64-bit integers and the <code>bool</code> data type.

<li> First attempt at working under macOS (v10.3 onwards), still using Tcl/Tk.

<li> Much rewriting of <i>cnet</i>'s own code
     to support mobile and wireless network simulations.

<li> The MT19937 (Mersenne Twister) pseudo-random number generator is now
    used internally in place of the slower and less portable
    <code>rand48</code> family of functions.

<p>
<li> <b>new and changed datatypes and constants (via cnet.h):</b>

<li> All times are measured in microseconds and use the new
    <code>CnetTime</code> datatype, which is the 64-bit integer type
    <code>int64_t</code> in ISO-C99.

<li> The <code>CnetData</code> type is now guaranteed long enough to hold
    integer and pointer values.

<li> The new <code>CnetRandom</code> type introduced.

<li> The <code>CnetTimer</code> type is renamed to <code>CnetTimerID</code>.

<li> The <code>transmitbufsize</code> field of the <code>CnetLinkinfo</code> datatype,
     has been renamed <code>mtu</code> (maximum transmit unit).

<li> The constant <code>LT_POINT2POINT</code> has been renamed <code>LT_WAN</code>,
     the constant <code>LT_ETHERNET</code> has been renamed <code>LT_LAN</code>,
     and the new constant <code>LT_WLAN</code> introduced.

<li> Timer events now range from <code>EV_TIMER0..EV_TIMER9</code>
	(no longer 1..10), and
     debug events now range from <code>EV_DEBUG0..EV_DEBUG4</code>
	(no longer 1..5).

<li> Two new nodetypes, <code>NT_MOBILE</code> and <code>NT_ACCESSPOINT</code>
     have been added to support mobile and wireless network simulations.

<p>
<li> <b>new and changed APIs:</b>

<li> All functions accepting lengths (e.g. number of bytes in a frame)
    are now of type <code>size_t</code>.

<li> Several new functions make multiple MT19937 sequences available in
    each node:
    <code>CNET_srand</code>, <code>CNET_rand</code>, <code>CNET_newrand</code>, and
    <code>CNET_nextrand</code>.

<li> Several new functions supporting wireless LANs introduced:
    <a href="api_get_position.php"><code>CNET_get_position</code></a>,
    <a href="api_set_position.php"><code>CNET_set_position</code></a>,
    <a href="api_wlan_arrival.php"><code>CNET_wlan_arrival</code></a>,
    <a href="api_get_wlaninfo.php"><code>CNET_get_wlaninfo</code></a>, and
    <a href="api_set_wlaninfo.php"><code>CNET_set_wlaninfo</code></a>.

<li> The functions <a href="api_shmem.php"><code>CNET_shmem</code></a>
    and <a href="api_check_version.php"><code>CNET_check_version</code></a>
    introduced.

<li> Checksum and CRC functions have been renamed:
	<code>checksum_crc16</code>&nbsp;-&gt;
<a href="api_checksums.php"><code>CNET_crc16</code></a>,
	<code>checksum_crc32</code>&nbsp;-&gt;
<a href="api_checksums.php"><code>CNET_crc32</code></a>,
	<code>checksum_ccitt</code>&nbsp;-&gt;
<a href="api_checksums.php"><code>CNET_ccitt</code></a>, and
	<code>checksum_internet</code>&nbsp;-&gt;
<a href="api_checksums.php"><code>CNET_IP_checksum</code></a>.

<p>
<li> <b>changes to the Tcl/Tk windowing:</b>
<li> The speed of the simulation may now be controlled from the main window
	(under Tcl/Tk).

<li> The single-step button now correctly increments the simulation time.

<li> The main statistics window now displays instantaneous
     as well as total statistics.

<li> The current simulation time is now displayed on the main window.

<li> <b>Deprecated:</b>
<li> Everything previously requiring the <code>CnetInt64</code> datatype and
    the <code>int64_*</code> API has been replaced by the 64-bit integer type
    <code>int64_t</code> in ISO-C99.

<li> The <code>CNET_set_promiscuous</code> function.

<li> The <code>-P</code> option (which specified the source code files for a
     Physical Layer) is now longer supported.

<li> The <code>-k</code> option (which compiled protocols with an "old"
     Kernighan and Ritchie (K&amp;R) C compiler) is no longer supported.

<li> Each of the <i>very</i> old
    <code>CNET_set_cursor</code>,
    <code>CNET_get_cursor</code>,
    <code>CNET_clear_to_eos</code> and
    <code>CNET_clear_to_eoln</code>
    functions are no longer recognized.

</ul>

<h1>Version 2.0 - from February 2002 (no longer supported)</h1>

<ul>
<li> v2.0.10 - many modifications to source code to provide clean
    compilation of cnet and examples with new, more rigorous, versions of gcc.

<li> v2.0.9 - another attempt to correct a bug which permitted events to
	be delivered after a node had crashed.

<li> v2.0.8 - corrected a bug in the <code>&lt;cnet64bits.h&gt;</code> header file
     which permitted only constants to be passed as arguments to
     <code>int64_INIT</code>.

    Corrected a bug which permitted timer events to still expire
     after a node had crashed.

    Improved installation on FreeBSD (5.1-RELEASE) -
    thanks to Rohan Joyce
    &lt;joycer01(at)tartarus.uwa.edu.au&gt; for submitting a patch.

    Corrected the detection of PowerPC architectures.

<li> v2.0.7 - corrected the detection of SPARC architectures and some
    compiler warnings when using gcc and ANSI-C - thanks to Peter Neubert
    &lt;neubert(at)mcs.sci.kuniv.edu.kw&gt; for reporting the problem.

<li> v2.0.6 - fixed an off-by-one error in handling changing linkstates
    (re)reported by Donald Gordon.

<li> v2.0.5 - added facility for a short string to be drawn on animated
    frames - thanks to Alex Feldman
    &lt;alex(at)alexandrite.boisestate.edu&gt; for the suggestion.

<li> v2.0.4 - compilations with <i>gcc</i> now have the <code>-Werror</code>
    flag added by default.

    Improved the <code>CHECK()</code> macro in <code>&lt;cnet.h&gt;</code>.

    Improvements to installation scripts -
    thanks to John Murdie &lt;john(at)cs.york.ac.uk&gt; for these.

    Fixed an off-by-one error in handling changing linkstates -
    thanks to Donald Gordon &lt;Donald.Gordon(at)mcs.vuw.ac.nz&gt; for this.

<li> v2.0.3 - small change to the scheduling of Ethernet segments -
    thanks to Klaus Doerrscheidt &lt;kdoerrscheidt(at)web.de&gt; for this.

<li> v2.0.2 - small event scheduler problem corrected.

<li> Support for 10Mbps IEEE&nbsp;802.3 Ethernet segments has been added;
    physical links are now each of the new type
    <a href="datatypes.php#linktype"><code>CnetLinkType</code></a>.

<li> Network Interface Cards (NICs) connect nodes to Ethernet segments;
    the new datatype <a href="datatypes.php#nicaddr"><code>CnetNICaddr</code></a>
    provides support for each NIC's hardware address.

    The address may be set with the new function
    <a href="physical.php"><code>CNET_set_nicaddr</code></a>,
    and the new functions
    <a href="physical.php"><code>CNET_parse_nicaddr</code></a> and
    <a href="physical.php"><code>CNET_format_nicaddr</code></a>
    convert between character strings and the <code>CnetNICaddr</code> datatype.
    <br>

    NICs may be set into <i>promiscuous mode</i> with the new function
    <a href="physical.php"><code>CNET_set_promiscuous</code></a>.

<li> 64-bit integers are now used to store all times (now in microseconds)
	and large statistics.
	A new datatype, <code>CnetInt64</code>,
	and a number of arithmetic, conversion, and I/O routines are defined
	in the new header file
	<code>&lt;cnet64bits.h&gt;</code>.
	The new header file is included by the standard header file
	<code>&lt;cnet.h&gt;</code>.

<li> The values of <code>nodeinfo.messagerate</code>,
	<code>nodeinfo.time_in_usec</code>, and
	<code>linkinfo[i].propagationdelay</code>
	are now of type <code>CnetInt64</code>.

<li> The 2nd argument of
	<a href="api_start_timer.php"><code>CNET_start_timer</code></a>
	is now of type <code>CnetInt64</code> and requests a time in microseconds,
	not milliseconds.

<li> Three new constants,
	<code>HAVE_LONG_LONG</code>, <code>SIZEOF_INT</code>, and <code>SIZEOF_LONG</code>
	must now be specified in the <code>config.h</code> file.

<li> Nodes are now provided with
	<a href="eventdriven.php#argv">command-line arguments</a>
	when they reboot.

<li> The Application Layer is now consulted to check that user-requested
	message sizes are neither too big nor too small.

<li> Documentation extended, including some much-requested
	<a href="walkthrough.php">protocol walkthroughs</a>.

<li> Tcl/Tk scripts corrected to capture WM_DELETE_WINDOW messages for all
	top-level windows.

<li> Corrected the values displayed on each node's Tcl/Tk radiobuttons
	used to modify the node's attributes at run-time.

<li> Output via stdio functions (to Tcl/Tk windows) simplified and improved
	so that scrollbars do not "jump back" to bottom of the window
	on every output.

<li> All statistics are now "flushed" via a single Tcl/Tk periodic event,
	rather than via <i>cnet</i>'s main scheduler.

<li> Statistics windows are now only updated if they have changed values.

<li> Improved documentation.

</ul>

<h1>Version 1.7 - August 2001 (no longer supported)</h1>

<ul>
<li> The data-link frames of 2-node simulations may now be
	<a href="drawframes.php">animated</a>.
	A new <code>EV_DRAWFRAME</code> event provides the user's protocol code
	with the opportunity to specify how the each individual data-Link
	frame is to be drawn.  The protocols themselves do not need to
	provide any special windowing/drawing code.
	Up to 6 fields of each frame may be drawn in colours specified in
	the standard header file <code>&lt;cnet.h&gt;</code>.

<li> Event tracing now appears in a separate scrollable Tcl/Tk window
	under the main map window (rather than just to <code>stderr</code>).
	A separate file may also be specified via the new global
	<a href="attributes.php">attribute</a>
	<code>tracefile</code> (specified in the topology file),
	to receive a full copy of the simulation's trace.

<li> The link attributes of <code>costperframe</code> or <code>costperbyte</code>
	may now be drawn on each link on the topology map by setting the
	new Boolean <a href="attributes.php">attributes</a>
	<code>costperframe</code> or <code>costperbyte</code>
	to <code>true</code> in the topology file.
	<code>costperframe</code> is shown in preference to <code>costperbyte</code>.

<li> Added facility for protocol source and object files to be specified
	with full pathnames.

<li> Physical Layer corruption now only modifies two bytes of a frame
	to guarantee detection by the provided checksum functions.

<li> The Physical Layer may now to asked to corrupt frames by truncating
	them, by setting <code>MAY_TRUNCATE_FRAMES</code> in <code>config.h</code>.

<li> A background image (GIF) may now be displayed on the toplogy map under
	Tcl/Tk by specifying the new <code>bgimage</code>
	<a href="attributes.php">attribute</a> in the topology file.

<li> Support added for the FreeBSD platform -
	thanks to Jordan Hubbard &lt;jkh(at)freebsd.org&gt;
	and Michael Haro &lt;mharo(at)area51.fremont.ca.us&gt;

<li> Support added for the NetBSD platform -
	thanks to Mark Davies, &lt;mark(at)mcs.vuw.ac.nz&gt;

<li> Corrected a bug where any output to a node's window produced by
	an <code>EV_DEBUG?</code> event handler did not appear if using the
	<code>-q</code> comand-line option.

<li> Each node's statistics' window is now only updated if that window if
	displayed.

<li> The values of <code>CnetTimerID</code> returned by <code>CNET_start_timer</code>,
	are now an independent property of each node.

<li> A number of internal global variables consolidated into the
	<code>gattr</code> structure.

<li> Each node's name, in <code>nodeinfo.nodename</code>, is now stored in a
	fixed sized array of <code>MAX_NODENAME_LEN</code> (=32) bytes,
	rather than via a character pointer.

<li> Improved documentation.

</ul>

<h1>Version 1.6 - May 2000 (no longer supported)</h1>

<ul>
<li> The <i>cnet</i> functions
	<code>CNET_set_cursor</code>,
	<code>CNET_get_cursor</code>,
	<code>CNET_clear_to_eoln</code>, and
	<code>CNET_clear_to_eos</code> are no longer supported.

<li> When tracing events, arbitrary addresses/variables may now be traced
	by name (instead of their hexadecimal addresses) by calling
	<code>CNET_trace_name</code> at the top of an event's handler.

<li> The link attributes of <code>propagationdelay</code> and
	<code>bandwidth</code> may no longer be changed at run-time via the
	windowing interface.

<li> A new function, <code>CNET_timer_data</code>, enables a protocol to
	retrieve a timer's user-data before the timer expires.
	This permits a protocol to retrive and deallocate dynamically
	allocated storage before it calls <code>CNET_stop_timer</code>.

<li> No "raw" X-window API functions called.
	All windowing, mouse tracking, fonts etc, are provided by Tcl/Tk.
	No special support provided for monochrome-only displays.

<li> All windowing for statistics, etc, "pushed" into the Tck/Tk code.

<li> Support added for Tcl/Tk v8.0 and beyond.

<li> A warning message is porduced if a provided topology file is not
	connected.  Random topologies, requested via the <code>-r&nbsp;nnodes</code>
	command-line option, are now guaranteed to be connected.

<li> Node icons are now located in a directory via the value of
	<code>CNETPATH</code>, rather than as statically-compiled XPM structures.
	XPM operating system support is no longer required.

<li> Both <i>recieve</i> and <i>interupt</i> now recognized spelling errors.

<li> Improved documentation.

</ul>

<h1>Version 1.5 - April 1999 (no longer supported)</h1>

<ul>
<li> Support for Linux <i>a.out</i> format dropped
	(now only <i>ELF</i> format).
<li> Support for Motif and XView windowing dropped
	(now only Tcl/Tk).
<li> Improved documentation.

</ul>

<h1>Version 1.4 - February 1997 (no longer supported)</h1>

<p>
<h1>Version 1.3 - July 1996 (no longer supported)</h1>

<p>
<h1>Version 0.1 - June 1991 (no longer supported)</h1>

</div>

<?php require_once("cnet-footer.php"); ?>
