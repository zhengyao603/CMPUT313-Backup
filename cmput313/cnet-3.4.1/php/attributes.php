<?php require_once("cnet-header.php"); ?>

<h1 id="attrs">Simulation attributes</h1>

<p>
A large number of attributes
define and constrain the execution of the whole simulation.
Naturally, depending on the types of nodes and links being simulated,
some combinations of nodes, links, and attributes may not be defined because 
they make no sense.
</p>

<table class="thin" style="width: 100%;">
<tr>
   <th class="thin">&nbsp;</th>
   <th class="thin">NT_HOST</th>
   <th class="thin">NT_ROUTER</th>
   <th class="thin">NT_MOBILE</th>
   <th class="thin">NT_ACCESSPOINT</th>
</tr>

<tr>
   <td class="option0">Has an Application Layer</td>
   <td class="option0" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
   <td class="option0" style="text-align: center;">-</td>
   <td class="option0" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
   <td class="option0" style="text-align: center;">-</td>
</tr>

<tr>
   <td class="option1">May receive keyboard input</td>
   <td class="option1" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
   <td class="option1" style="text-align: center;">-</td>
   <td class="option1" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
   <td class="option1" style="text-align: center;">-</td>
</tr>

<tr>
   <td class="option0">May have <code>LT_WAN</code> links</td>
   <td class="option0" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
   <td class="option0" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
   <td class="option0" style="text-align: center;">-</td>
   <td class="option0" style="text-align: center;">-</td>
</tr>

<tr style="background-color: #e2e2e2;">
   <td class="option1">May have <code>LT_LAN</code> links</td>
   <td class="option1" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
   <td class="option1" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
   <td class="option1" style="text-align: center;">-</td>
   <td class="option1" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
</tr>

<tr>
   <td class="option0">May have <code>LT_WLAN</code> links</td>
   <td class="option0" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
   <td class="option0" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
   <td class="option0" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
   <td class="option0" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
</tr>

<tr>
   <td class="option1">Has a battery power source</td>
   <td class="option1" style="text-align: center;">-</td>
   <td class="option1" style="text-align: center;">-</td>
   <td class="option1" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
   <td class="option1" style="text-align: center;">-</td>
</tr>

<tr>
   <td class="option0">May move on simulation map</td>
   <td class="option0" style="text-align: center;">-</td>
   <td class="option0" style="text-align: center;">-</td>
   <td class="option0" style="text-align: center;"><img src="images/redtick.png" alt="redtick"></td>
   <td class="option0" style="text-align: center;">-</td>
</tr>
</table>

<p>
Calls to <i>cnet</i>'s API for inappropriate combinations of nodes and
links, will consistently return the value <code>-1</code> and set the
value of <code><a href="datatypes.php#cneterror">cnet_errno</a></code>
to <code>ER_NOTSUPPORTED</code>.
</p>

<dl>
<dt><b>NOTE:</b></dt>
    <dd> A few attribute names have a number of (undocumented) synonyms.
    For example, both <code>rebootargs</code> and <code>rebootargv</code>
    specify the same attribute.
    Support for these synonyms is simply designed to provide greater
    readability of your topology files.
    They do not introduce any ambiguity.
    </dd>
</dl>

<p></p>

<h1 id="gattrs">Global attributes</h1>

<p>
<i>Global attributes</i> are defined in the topology file
and define and constrain the execution of the whole simulation.
They may not be redefined on a per-node or per-link basis.
The global attributes are not accessible to the protocol's C code
at runtime.
</p>

<table class="thin" style="width: 100%;">
<tr>
    <th class="thin">Global&nbsp;attribute</th>
    <th class="thin">datatype</th>
    <th class="thin">explanation</th>
    <th class="thin">example</th>
</tr>
<tr>
    <td class="option0">drawlinks</td>
    <td class="option0">Boolean</td>
    <td class="option0">
	draw the links and propagation signals on the simulation map.</td>
    <td class="option0" style="white-space: nowrap">drawlinks = false</td>
</tr>
<tr>
    <td class="option1">drawnodes</td>
    <td class="option1">Boolean</td>
    <td class="option1">
	draw the node icons on the simulation map.</td>
    <td class="option1" style="white-space: nowrap">drawnodes = true</td>
</tr>
<tr>
    <td class="option0">extension</td>
    <td class="option0">string</td>
    <td class="option0">provides the name of an
	<a href="compilation.php#extension">extension module</a>
	whose code and data will be shared amongst all nodes.
	A toplogy file may specify multiple <code>extension</code> modules.
    <td class="option0" style="white-space: nowrap">extension = "statistics.c"</td>
</tr>
<tr>
    <td class="option1">mapcolour</td>
    <td class="option1">string</td>
    <td class="option1">provides the name of the background colour of the
	simulation's main window.
    <td class="option1" style="white-space: nowrap">mapcolour = "wheat"</td>
</tr>
<tr>
    <td class="option0">mapgrid</td>
    <td class="option0">integer</td>
    <td class="option0">provides the lengths of the sides of squares to be drawn on the
	simulation's main window.
    <td class="option0" style="white-space: nowrap">mapgrid = 50</td>
</tr>
<tr>
    <td class="option1">mapheight</td>
    <td class="option1">integer</td>
    <td class="option1">specifies the height of the simulation map in metres.
    <td class="option1" style="white-space: nowrap">mapheight = 400m</td>
</tr>
<tr>
    <td class="option0">maphex</td>
    <td class="option0">integer</td>
    <td class="option0">provides the lengths of the sides of hexagons to be drawn on the
	simulation's main window.
    <td class="option0" style="white-space: nowrap">maphex = 40</td>
</tr>
<tr>
    <td class="option1">mapimage</td>
    <td class="option1">string</td>
    <td class="option1">provides the name of a GIF-format image file to be centered on the
	simulation's main window.
	The image file is sought via the <code>CNETPATH</code>
	environment variable if necessary.</td>
    <td class="option1" style="white-space: nowrap">mapimage = "australia.png"</td>
</tr>
<tr>
    <td class="option0">mapmargin</td>
    <td class="option0">integer</td>
    <td class="option0">indicates the width and height, in pixels,
	surrounding the simulation's main window.
    <td class="option0" style="white-space: nowrap">mapmargin = 20</td>
</tr>
<tr>
    <td class="option1">mapscale</td>
    <td class="option1">floatingpoint</td>
    <td class="option1">indicates how many real-world metres are represented by one pixel on
	the simulation's main window.
    <td class="option1" style="white-space: nowrap">mapscale = 0.5</td>
</tr>
<tr>
    <td class="option0">maptile</td>
    <td class="option0">string</td>
    <td class="option0">provides the name of a GIF-format image file to be tiled on the
	simulation's main window.
	The image file is sought via the <code>CNETPATH</code>
	environment variable if necessary.</td>
    <td class="option0" style="white-space: nowrap">maptile = "grass.png"</td>
</tr>
<tr>
    <td class="option1">mapwidth</td>
    <td class="option1">floatingpoint</td>
    <td class="option1">specifies the width of the simulation map in metres.
    <td class="option1" style="white-space: nowrap">mapwidth = 600m</td>
</tr>
<tr>
    <td class="option0">positionerror</td>
    <td class="option0">integer</td>
    <td class="option0">requests that a error is introduced in a node's reported position
	when calling <code>CNET_get_position</code>.
	Errors are uniformly distributed in a circle around a node's
	true position.
    <td class="option0" style="white-space: nowrap">positionerror = 20m</td>
</tr>
<tr>
    <td class="option1">showcostperbyte</td>
    <td class="option1">Boolean</td>
    <td class="option1">requests that each link's <code>costperbyte</code> attribute value be
	displayed on the simulation's main window over each link.
	The use of <code>showcostperframe</code> overrides that
	of <code>showcostperbyte</code>.</td>
    <td class="option1" style="white-space: nowrap">showcostperbyte = false</td>
</tr>
<tr>
    <td class="option0">showcostperframe</td>
    <td class="option0">Boolean</td>
    <td class="option0">requests that each link's <code>costperframe</code> attribute value be
	displayed on the simulation's main window over each link.
	The use of <code>showcostperframe</code> overrides that
	of <code>showcostperbyte</code>.</td>
    <td class="option0" style="white-space: nowrap">showcostperframe = true</td>
</tr>
<tr>
    <td class="option1">tracefile</td>
    <td class="option1">string</td>
    <td class="option1">requests that the <i>execution trace</i> be mirrored in the named
	file when the <a href="options.php#option-t">-t</a> option is given.
	<b>Warning&nbsp;-</b> trace files can grow very large
	(to several megabytes),
	very quickly.</td>
    <td class="option1" style="white-space: nowrap">tracefile = "badtrace.txt"</td>
</tr>
</table>

<p></p>

<h1 id="nodeattrs">Node attributes</h1>

<p>
<i>Node attributes</i>
may be defined globally,
to define the default attributes of every node,
or defined locally,
within the definition of each node,
to override the default attributes for just that node.
</p>

<p>
A special type of <i>named</i> node attribute,
preceded by the <code><b>var</b></code> keyword,
enables nodes to access
(at runtime, by calling <a href="api_getvar.php">CNET_getvar</a>)
arbitrary <i>string</i> values defined in topology files.
Like all node attributes,
these may be defined globally or within any node's definition.
For example:
<p></p>

<div class="code">
<b>var</b> beacon_freq    = "1024"
<b>var</b> mobility_style = "Manhattan"
</div>

<p></p>

<table class="thin" style="width: 100%;">
<tr>
    <th class="thin">Node attribute</th>
    <th class="thin">datatype</th>
    <th class="thin">explanation</th>
    <th class="thin">example</th>
</tr>
<tr>
    <td class="option0">address</td>
    <td class="option0">integer</td>
    <td class="option0">the unique network address of each node</td>
    <td class="option0" style="white-space: nowrap">address = 238</td>
</tr>
<tr>
    <td class="option1">compile</td>
    <td class="option1">string</td>
    <td class="option1">a <a href="compilation.php">compilation string</a>
	    to declare the sourcefile names
	    containing the protocols for each node
	    (locally overrides the <a href="options.php#option-C">-C</a>
	    option)</td>
    <td class="option1" style="white-space: nowrap">compile = "protocol.c stats.c -lm"</td>
</tr>
<tr>
    <td class="option0">icontitle</td>
    <td class="option0">string</td>
    <td class="option0">specifies the string to appear under each node's icon on the GUI.
    <br>
    The following formatting substitutions may be requested:
    <p>

    <table style="width:100%;">
	<tr><td style="width: 10%;">%a</td><td>node's address as an integer</td></tr>
	<tr><td>%d</td><td>node's number</td></tr>
	<tr><td>%I</td><td>node's address in IPv4 dotted-decimal notation</td></tr>
	<tr><td>%n</td><td>node's name</td></tr>
    </table>
    </td>

    <td class="option0" style="white-space: nowrap">icontitle = "%d - %n"</td>
</tr>
<tr>
    <td class="option1">messagerate</td>
    <td class="option1">time</td>
    <td class="option1">the rate at which the Application Layer can generate new
	    messages for delivery</td>
    <td class="option1" style="white-space: nowrap">messagerate = 10000usecs<br>
	       messagerate = 2s</td>
</tr>
<tr>
    <td class="option0">minmessagesize</td>
    <td class="option0">bytes</td>
    <td class="option0">the minimum size of messages generated by the Application Layer</td>
    <td class="option0" style="white-space: nowrap">minmessagesize = 100bytes<br>
	       minmessagesize = 4KB</td>
</tr>
<tr>
    <td class="option1">maxmessagesize</td>
    <td class="option1">bytes</td>
    <td class="option1">the maximum size of messages generated by the Application Layer
	    (bounded by <code>MAX_MESSAGE_SIZE</code>)</td>
    <td class="option1" style="white-space: nowrap">maxmessagesize = 200bytes<br>
	       maxmessagesize = 8KB</td>
</tr>
<tr>
    <td class="option0">nodemtbf</td>
    <td class="option0">time</td>
    <td class="option0">the expected time between node hardware failures</td>
    <td class="option0" style="white-space: nowrap">nodemtbf = 60000s<br>
	       nodemtbf = 1000s</td>
</tr>
<tr>
    <td class="option1">nodemttr</td>
    <td class="option1">time</td>
    <td class="option1">the expected time taken to repair a hardware failure</td>
    <td class="option1" style="white-space: nowrap">nodemttr = 5000s<br>
	       nodemttr = 100s</td>
</tr>
<tr>
    <td class="option0">outputfile</td>
    <td class="option0">string</td>
    <td class="option0">a file into which a node's <code>printf</code> output is mirrored.
    <br>
    The following formatting substitutions may be requested:
    <p>

    <table style="width: 100%;">
	<tr><td style="width: 10%;">%a</td><td>node's address as an integer</td></tr>
	<tr><td>%d</td><td>node's number</td></tr>
	<tr><td>%I</td><td>node's address in IPv4 dotted-decimal notation</td></tr>
	<tr><td>%n</td><td>node's name</td></tr>
    </table>
    </td>

    <td class="option0" style="white-space: nowrap">outputfile = "output.%n"</td>
</tr>
<tr>
    <td class="option1">rebootargs</td>
    <td class="option1">string</td>
    <td class="option1">provide one or more white-space separated
	<a href="eventdriven.php#argv">command-line arguments</a>
	to be passed to the node's <code>EV_REBOOT</code> handler.
	(locally overrides any arguments passed on
	<i>cnet</i>'s own command-line)</td>
    <td class="option1" style="white-space: nowrap">rebootargs = "-fast -nostats"</td>
</tr>
<tr>
    <td class="option0">rebootfunc</td>
    <td class="option0">string</td>
    <td class="option0">the C function to call when the node reboots
	(locally overrides the <a href="options.php#option-R">-R</a>
	option)</td>
    <td class="option0" style="white-space: nowrap">rebootfunc = "reboot_function"</td>
</tr>
<tr>
    <td class="option1">trace</td>
    <td class="option1">Boolean</td>
    <td class="option1">a Boolean indicating if event tracing is required
	(overrides the <a href="options.php#option-t">-t</a>
	option on a per-node basis)</td>
    <td class="option1" style="white-space: nowrap">trace = true</td>
</tr>
<tr>
    <td class="option0">winopen</td>
    <td class="option0">Boolean</td>
    <td class="option0">Boolean attribute requesting that a node's window be
	 opened on startup</td>
    <td class="option0" style="white-space: nowrap">winopen = false</td>
</tr>
<tr>
    <td class="option1">winx, winy</td>
    <td class="option1">integer</td>
    <td class="option1">screen coordinates of the node's window under Tcl/Tk</td>
    <td class="option1" style="white-space: nowrap">winx = 100, winy = 200</td>
</tr>
<tr>
    <td class="option0">x, y</td>
    <td class="option0">integer</td>
    <td class="option0">coordinates of either the centre of a node's icon,
	or the left-hand end of an Ethernet segment on the main window</td>
    <td class="option0" style="white-space: nowrap">x = 80, y = 120</td>
</tr>
</table>

<p></p>

<h1 id="linkattrs">Link attributes</h1>

<p>
<i>Link attributes</i>
may be defined globally,
to define the default attributes of each link,
or defined locally,
within the definition of each link,
to override the default attributes for just that link.
</p>

<p>
<i>cnet</i> supports three different types of physical links -
<code>LT_WAN</code>, <code>LT_LAN</code>, and <code>LT_WLAN</code>.
We thus need to specify the link type for which we are setting an attribute.
There are many more link attributes than node attributes -
for example all of
<code>wan-bandwidth</code>,
<code>lan-bandwidth</code>, and
<code>wlan-bandwidth</code>
are recognized and set the attribute for the appropriate link type.
If an attribute name is not prefixed with one of the link link types,
then a <code>wan-</code> attribute is assumed
(maintaining backwards compatability with older versions of <i>cnet</i>).
</p>

<p>
While defining attributes locally for a particular link type,
only the attributes appropriate for that link type may be set.
For example, the attribute <code>wan-bandwidth</code> may not appear inside
the definition of a <code>LAN</code> link.
</p>

<p>
Some link attribute names are only meaningful for specific link types,
and they are explicitly listed in the following table.
</p>

<p>
<table class="thin" style="width: 100%;">
<tr>
    <th class="thin">Link attribute</th>
    <th class="thin">datatype</th>
    <th class="thin">explanation</th>
    <th class="thin">example</th>
</tr>
<tr>
    <td class="option0">bandwidth</td>
    <td class="option0">integer</td>
    <td class="option0">the full-duplex bandwidth along a link</td>
    <td class="option0" style="white-space: nowrap">bandwidth = 10Mbps<br>
	       bandwidth = 56Kbps</td>
</tr>
<tr>
    <td class="option1">buffered</td>
    <td class="option1">Boolean</td>
    <td class="option1">whether the link's NIC buffers frames ready to be transmitted</td>
    <td class="option1" style="white-space: nowrap">buffered = false
</tr>
<tr>
    <td class="option0">costperbyte</td>
    <td class="option0">integer</td>
    <td class="option0">the cost per byte along this link</td>
    <td class="option0" style="white-space: nowrap">costperbyte = 1</td>
</tr>
<tr>
    <td class="option1">costperframe</td>
    <td class="option1">integer</td>
    <td class="option1">the cost per frame along this link</td>
    <td class="option1" style="white-space: nowrap">costperframe = 5</td>
</tr>
<tr>
    <td class="option0">jitter</td>
    <td class="option0">time</td>
    <td class="option0">the random transmission jitter on WAN, LAN, and WLAN links</td>
    <td class="option0" style="white-space: nowrap">wan-jitter = 5usec</td>
</tr>
<tr>
    <td class="option1">lan-slottime</td>
    <td class="option1">time</td>
    <td class="option1">the interframe timing gap for LAN links</td>
    <td class="option1" style="white-space: nowrap">lan-slottime = 52usec</td>
</tr>
<tr>
    <td class="option0">linkmtbf</td>
    <td class="option0">time</td>
    <td class="option0">the expected time between link hardware failures</td>
    <td class="option0" style="white-space: nowrap">linkmtbf = 60000s<br>
	       linkmtbf = 1000s</td>
</tr>
<tr>
    <td class="option1">linkmttr</td>
    <td class="option1">time</td>
    <td class="option1">the expected time taken to repair a link hardware failure</td>
    <td class="option1" style="white-space: nowrap">linkmttr = 5000s<br>
	       linkmttr = 100s</td>
</tr>
<tr>
    <td class="option0">mtu</td>
    <td class="option0">integer</td>
    <td class="option0">the maximum number of bytes that may be written to the link in a
	single write</td>
    <td class="option0" style="white-space: nowrap">mtu = 1000bytes</td>
</tr>
<tr>
    <td class="option1">probframecorrupt</td>
    <td class="option1">probability</td>
    <td class="option1">the probability that a frame on this link will be corrupted</td>
    <td class="option1" style="white-space: nowrap">probframecorrupt = 3</td>
</tr>
<tr>
    <td class="option0">probframeloss</td>
    <td class="option0">probability</td>
    <td class="option0">the probability that a frame on this link will be lost
	    altogether</td>
    <td class="option0" style="white-space: nowrap">probframeloss = 4</td>
</tr>
<tr>
    <td class="option1">propagationdelay</td>
    <td class="option1">time</td>
    <td class="option1">the propagation delay along a link</td>
    <td class="option1" style="white-space: nowrap">propagationdelay = 200usecs<br>
	       propagationdelay = 1s</td>
</tr>
<tr>
    <td class="option0">wlan-frequency</td>
    <td class="option0">floatingpoint</td>
    <td class="option0">the frequency of transmission of this wireless link</td>
    <td class="option0" style="white-space: nowrap">wlan-frequency = 2.4GHz</td>
</tr>
<tr>
    <td class="option1">wlan-rxantennagain</td>
    <td class="option1">floatingpoint</td>
    <td class="option1">the power gain of a link's antenna while receiving a signal</td>
    <td class="option1" style="white-space: nowrap">wlan-rxantennagain = 2.8dBm</td>
</tr>
<tr>
    <td class="option0">wlan-rxcableloss</td>
    <td class="option0">floatingpoint</td>
    <td class="option0">the power lost by a link while transfering a received signal</td>
    <td class="option0" style="white-space: nowrap">wlan-rxcableloss = 1.0dBm</td>
</tr>
<tr>
    <td class="option1">wlan-rxsensitivity</td>
    <td class="option1">floatingpoint</td>
    <td class="option1">the minimum signal strength required so that a link can "hear"
	that signal</td>
    <td class="option1" style="white-space: nowrap">wlan-rxsensitivity = -75.0dBm</td>
</tr>
<tr>
    <td class="option0" style="white-space: nowrap;">wlan-rxsignaltonoise</td>
    <td class="option0">floatingpoint</td>
    <td class="option0">the ratio of a signal's strength to that of the background noise
	required so that a link can separate the signal from the noise</td>
    <td class="option0" style="white-space: nowrap">wlan-rxsignaltonoise = 12.0dBm</td>
</tr>
<tr>
    <td class="option1">wlan-txantennagain</td>
    <td class="option1">floatingpoint</td>
    <td class="option1">the power gain of a link's antenna while transmitting a signal</td>
    <td class="option1" style="white-space: nowrap">wlan-txantennagain = 2.8dBm</td>
</tr>
<tr>
    <td class="option0">wlan-txcableloss</td>
    <td class="option0">floatingpoint</td>
    <td class="option0">the power lost by a link while transfering a transmitted signal</td>
    <td class="option0" style="white-space: nowrap">wlan-txcableloss = 1.0dBm</td>
</tr>
<tr>
    <td class="option1">wlan-txpower</td>
    <td class="option1">floatingpoint</td>
    <td class="option1">the initial power used by a link to transmit a signal</td>
    <td class="option1" style="white-space: nowrap">wlan-txpower = 15.0dBm</td>
</tr>

<tr>
    <td class="option0">wlan-sleepcurrent</td>
    <td class="option0">floatingpoint</td>
    <td class="option0">the current drawn by a wireless link in the sleep state</td>
    <td class="option0" style="white-space: nowrap">wlan-sleepcurrent = 20.0mA</td>
</tr>
<tr>
    <td class="option1">wlan-idlecurrent</td>
    <td class="option1">floatingpoint</td>
    <td class="option1">the current drawn by a wireless link in idle state</td>
    <td class="option1" style="white-space: nowrap">wlan-idlecurrent = 150.0mA</td>
</tr>
<tr>
    <td class="option0">wlan-rxcurrent</td>
    <td class="option0">floatingpoint</td>
    <td class="option0">the current drawn by a wireless link in the receive state</td>
    <td class="option0" style="white-space: nowrap">wlan-rxcurrent = 200.0mA</td>
</tr>
<tr>
    <td class="option1">wlan-txcurrent</td>
    <td class="option1">floatingpoint</td>
    <td class="option1">the current drawn by a wireless link in the transmit state</td>
    <td class="option1" style="white-space: nowrap">wlan-txcurrent = 300.0mA</td>
</tr>
</table>
<p>

<?php require_once("cnet-footer.php"); ?>
