<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s datatypes, event types, and error types</h1>

<i>cnet's</i> provides a number of datatypes,
necessary to identify node types, link types, events, and errors.
Each datatype is defined in the <code>&lt;cnet.h&gt;</code> header file.

The datatypes are:

<ul>
<li> the <a href="#nodetype"><code>CnetNodeType</code></a> enumerated type
<li> the <a href="#linktype"><code>CnetLinkType</code></a> enumerated type
<li> the <a href="#cnetcolour"><code>CnetColour</code></a> datatype
<li> the <a href="#cneterror"><code>CnetError</code></a> enumerated type
<li> the <a href="#cnetevent"><code>CnetEvent</code></a> enumerated type
<li> the <a href="#cnettime"><code>CnetTime</code></a> datatype
<li> the <a href="#nicaddr"><code>CnetNICaddr</code></a> datatype
<li> the <a href="#wlanresult"><code>WLANRESULT</code></a> enumerated type
</ul>

<p></p>

<h1 id="nodetype">The <code>CnetNodeType</code> enumerated type</h1>

<p>
Each node is either a host (such as a workstation),
a router,
a mobile node (such as a wireless PDA), or
a wireless accesspoint.
The type of a node may be determined by examining its value of
<code>nodeinfo.nodetype</code>.
For example:
</p>

<div class="code">
<b>if</b>(nodeinfo.nodetype == NT_HOST)
    CNET_set_handler(EV_APPLICATIONREADY, appl_ready, 0);
</div>

<p></p>

<table class="thin" style="width: 100%;">

<tr>
    <th class="thin">CnetNodeType</th>
    <th class="thin">meaning</th>
</tr>
<tr>
    <td class="option0">NT_HOST</td>
    <td class="option0">this node is a host with an Application Layer and keyboard</td>
</tr>

<tr>
    <td class="option1">NT_ROUTER</td>
    <td class="option1">this node is a router without an Application Layer or keyboard</td>
</tr>
<tr>
    <td class="option0">NT_MOBILE</td>
    <td class="option0">this node may move, may only have wireless links,
	maintains a record of its battery level,
	and has an Application Layer and keyboard</td>
</tr>

<tr>
    <td class="option1">NT_ACCESSPOINT</td>
    <td class="option1">this node is a wireless accesspoint, must have at least one
	wireless link,
	and has no Application Layer or keyboard</td>
</tr>
</table>

<p>
Note that calls to the functions
</p>

<pre>    <code>CNET_write_application</code>,
    <code>CNET_read_application</code>,
    <code>CNET_enable_application</code>,
    <code>CNET_disable_application</code>,
    <code>CNET_set_handler(EV_APPLICATIONLAYER,...)</code>, and
    <code>CNET_set_handler(EV_KEYBOARDREADY,...)</code>
</pre>

<p>
are only valid if called from a node of
type <code>NT_HOST</code> or <code>NT_MOBILE</code>.
</p>

<p>
Calls to the functions
</p>

<pre>    <code>CNET_set_position</code>, and
    <code>CNET_set_battery</code>
</pre>

<p>
are only valid if called from a node of type <code>NT_MOBILE</code>.
</p>

<p></p>

<h1 id="linktype">The <code>CnetLinkType</code> enumerated type</h1>

<p>
Each node's links provide either a loopback service,
<i>wide-area-networking</i>,
<i>local-area-networking</i>, or
<i>wireless-local-area-networking</i>.
The type of a link may be determined by examining the value of
<code>linkinfo[link].linktype</code>.
For example:
</p>

<div class="code">
<b>if</b>(linkinfo[link].linktype == LT_LAN)
    <b>if</b>(CNET_lan_busy(link))
        ..........
</div>

<p></p>

<table class="thin" style="width: 100%;">

<tr>
    <th class="thin">CnetLinkType</th>
    <th class="thin">meaning</th>
</tr>
<tr>
    <td class="option0">LT_LOOPBACK</td>
    <td class="option0">this link (which will always be link <code>0</code>) is used to quickly
	transmit data from a node to <i>itself</i></td>
</tr>

<tr>
    <td class="option1">LT_WAN</td>
    <td class="option1">this link connects this node to one other node via a dedicated,
	point-to-point wide-area network link</td>
</tr>
<tr>
    <td class="option0">LT_LAN</td>
    <td class="option0">this link connects this node to other nodes via a simulation of
	an IEEE-802.3 shared segment</td>
</tr>

<tr>
    <td class="option1">LT_WLAN</td>
    <td class="option1">this link provides a wireless "connection"
	to all other wireless links that can receive its transmission</td>
</tr>
</table>

<p>
Calls to the function
</p>

<pre>    <code>CNET_set_nicaddr</code></pre>

<p>
may only be made for links of type <code>LT_LAN</code> or <code>LT_WLAN</code>.
</p>

<p></p>

<h1 id="cnetcolour">The <code>CnetColour</code> type</h1>

<p>
Colours are employed for some simple activities when <i>cnet</i>'s
execution is displayed via its GUI.

Colours are simple C strings,
such as "red" or "blue",
hexadecimal RGB-triples such as "#ffaa00",
or the special value <code>CNET_LED_OFF</code>.
</p>

<p>
When <a href="drawframes.php">drawing datalink frames</a>,
protocol code may specify the colour to be used to highlight
each field in each frame.
</p>

<p>
When wishing to present a quick indication of a node's status,
the function <a href="api_set_LED.php">CNET_set_LED</a> may be called with
the desired colour (string).
</p>

<p>
When drawing the wireless transmissions of
<a href="wlans.php">wireless LANs</a>,
the function <a href="api_set_wlancolour.php">CNET_set_wlancolour</a>
may be called to request how each transmission is drawn.
</p>

<p></p>

<h1 id="cneterror">The <code>CnetError</code> enumerated type</h1>

<p>
Most <i>cnet</i> API functions return the integer <code>0</code> on success
and the integer <code>-1</code> on failure.
The most recent error status is stored in
the global variable <code>cnet_errno</code>.
All values of <code>cnet_errno</code> will be instances of the
enumerated type <code>CnetError</code>.
Functions do not set the value of <code>cnet_errno</code> to
<code>ER_OK</code> if their execution was successful.
</p>

<p>
Errors may be reported to <code>stderr</code> with
<code>CNET_perror()</code> and their error message string accessed from
<code>cnet_errstr[(<b>int</b>)cnet_errno]</code>.
For example:
</p>

<div class="code">
<b>if</b>(CNET_write_application(msgbuffer, &amp;msglength) != 0) {
    // an error has occured
    <b>if</b>(cnet_errno == ER_BADSESSION) {
	// handle this special case
	....
    }
    <b>else</b> {
	CNET_perror("writing to application");
    }
}
</div>

<p></p>

<table class="thin" style="width: 100%;">

<tr>
    <th class="thin">CnetError</th>
    <th class="thin">meaning</th>
</tr>
<tr>
    <td class="option0">ER_OK</td>
    <td class="option0">No error</td>
</tr>

<tr>
    <td class="option1">ER_BADALLOC</td>
    <td class="option1">Allocation of dynamic memory failed</td>
</tr>
<tr>
    <td class="option0">ER_BADARG</td>
    <td class="option0">Invalid argument passed to a function</td>
</tr>

<tr>
    <td class="option1">ER_BADEVENT</td>
    <td class="option1">Invalid event passed to a function</td>
</tr>
<tr>
    <td class="option0">ER_BADLINK</td>
    <td class="option0">Invalid link number passed to a function</td>
</tr>

<tr>
    <td class="option1">ER_BADNODE</td>
    <td class="option1">Invalid node passed to a function</td>
</tr>
<tr>
    <td class="option0">ER_BADPOSITION</td>
    <td class="option0">Attempt to move mobile node off the map</td>
</tr>

<tr>
    <td class="option1">ER_BADSENDER</td>
    <td class="option1">Application Layer given message from an unknown node</td>
</tr>
<tr>
    <td class="option0">ER_BADSESSION</td>
    <td class="option0">Application Layer given message from incorrect session</td>
</tr>

<tr>
    <td class="option1">ER_BADSIZE</td>
    <td class="option1">Indicated length is of incorrect size</td>
</tr>
<tr>
    <td class="option0">ER_BADTIMER</td>
    <td class="option0">Invalid CnetTimerID passed to a function</td>
</tr>

<tr>
    <td class="option1">ER_CORRUPTFRAME</td>
    <td class="option1">Attempt to transfer corrupt data
	(only seen if <a href="options.php#option-e">-e</a> provided)</td>
</tr>
<tr>
    <td class="option0">ER_DUPLICATEMSG</td>
    <td class="option0">Application Layer given a duplicate message</td>
</tr>

<tr>
    <td class="option1">ER_LINKDOWN</td>
    <td class="option1">Attempt to transmit on a link which is down</td>
</tr>
<tr>
    <td class="option0">ER_MISSINGMSG</td>
    <td class="option0">Application Layer given a message before all previous ones</td>
</tr>

<tr>
    <td class="option1">ER_NOBATTERY</td>
    <td class="option1">Battery exhaused on a mobile node</td>
</tr>
<tr>
    <td class="option0">ER_NOTFORME</td>
    <td class="option0">Application Layer given a message for another node</td>
</tr>

<tr>
    <td class="option1">ER_NOTREADY</td>
    <td class="option1">Function called when service not available</td>
</tr>
<tr>
    <td class="option0">ER_NOTSUPPORTED</td>
    <td class="option0">Invalid operation for this node or link type</td>
</tr>

<tr>
    <td class="option1">ER_TOOBUSY</td>
    <td class="option1">Link is too busy/congested to handle request</td>
</tr>
</table>

<p></p>

<h1 id="cnetevent">The <code>CnetEvent</code> enumerated type</h1>

<p>
All events in <i>cnet</i> are of type <code>CnetEvent</code>.
Events are <i>raised</i> when a number of important things occur
that (possibly) require action from your protocols.
Interest may be registered in each event by calling the function
<a href="api_set_handler.php"><code>CNET_set_handler</code></a>
and passing to it a function, an <i>event handler</i>,
to be called when the event is raised.
By default, no events are of interest (all are ignored).
</p>

<p>
When an event of interest is raised, its event handler is called,
with the event (an instance of <code>CnetEvent</code>)
passed as the first parameter.
</p>

<p></p>

<table class="thin" style="width: 100%;">

<tr>
    <th class="thin">CnetEvent</th>
    <th class="thin">meaning</th>
</tr>
<tr>
    <td class="option0">EV_NULL</td>
    <td class="option0">this event is used internally and is never seen by your protocols</td>
</tr>

<tr>
    <td class="option1">EV_REBOOT</td>
    <td class="option1">raised as reboot_node(EV_REBOOT, ... , ...)</td>
</tr>
<tr>
    <td class="option0">EV_SHUTDOWN</td>
    <td class="option0">raised before cnet is (cleanly) terminated</td>
</tr>

<tr>
    <td class="option1">EV_APPLICATIONREADY</td>
    <td class="option1">raised when there is a message ready for delivery</td>
</tr>
<tr>
    <td class="option0">EV_PHYSICALREADY</td>
    <td class="option0">raised when a frame arrives at one of the links</td>
</tr>

<tr>
    <td class="option1">EV_FRAMECOLLISION</td>
    <td class="option1">raised when a frame collides on LT_LAN or LT_WLAN</td>
</tr>
<tr>
    <td class="option0">EV_KEYBOARDREADY</td>
    <td class="option0">raised when an input line is entered from the keyboard</td>
</tr>

<tr>
    <td class="option1">EV_LINKSTATE</td>
    <td class="option1">raised when a link changes state (either up or down)</td>
</tr>
<tr>
    <td class="option0">EV_DRAWFRAME</td>
    <td class="option0">raised when a frame is to be drawn in 2-node world</td>
</tr>

<tr>
    <td class="option1">EV_PERIODIC</td>
    <td class="option1">raised periodically if the
    <a href="options.php#option-f">-f</a> option provided</td>          
</tr>
<tr>
    <td class="option0">EV_UPDATEGUI</td>
    <td class="option0">raised whenever the Tcl/Tk GUI is being updated,
    as requested by the <a href="options.php#option-u">-u</a> option</td>
</tr>

<tr>
    <td class="option1">EV_DEBUG0..EV_DEBUG4</td>
    <td class="option1">raised when one of the debug buttons (under Tcl/Tk) is pressed</td>
</tr>
<tr>
    <td class="option0">EV_TIMER0..EV_TIMER9</td>
    <td class="option0">raised when a timer on any of the 10 timer queues expires</td>
</tr>
</table>

<p></p>

<h1 id="nicaddr">The <code>CnetNICaddr</code> datatype</h1>

<p>
Each Physical Layer link of type <code>LT_WAN</code>,
<code>LT_LAN</code>, or
<code>LT_WLAN</code>
has a specific Network Interface Card (NIC) address.
<i>cnet</i> provides the <code>CnetNICaddr</code> datatype to represent the
addresses of its NICs,
as an array of <code>LEN_NICADDR</code> (=6) unsigned characters.
Although <i>cnet</i> does not require it,
it is anticipated that frames will carry the address of their source and
destination Network Interface Cards (NIC) near the beginning of the frame.
</p>

<p>
<i>cnet</i> provides the functions
<a href="physical.php"><code>CNET_parse_nicaddr</code></a> and
<a href="physical.php"><code>CNET_format_nicaddr</code></a>
to convert between character strings and the <code>CnetNICaddr</code> datatype.
</p>

<p></p>

<h1 id="cnettime">The <code>CnetTime</code> datatype</h1>

<p>
All times and periods in <i>cnet</i> are stored as an integral number
of microsconds.
This requires a sufficiently long integer representation to
avoid values "wrapping around" in most simulations.
<i>cnet</i> employs ISO-C99's standard <code><b>int64_t</b></code> datatype
to represent time:
</p>

<pre>    <code><b>typedef int64_t</b>    CnetTime;</code></pre>

<p>
and all function arguments and structure fields
requiring a number of microseconds,
employ the <code>CnetTime</code> type.

Standard integer arithmetic, such as addition and subtraction,
and comparisons may be performed on <code>CnetTime</code> values,
and they may be conveniently formatted
with <a href="api_format64.php">CNET_format64</a>.
</p>

<p></p>

<h1 id="wlanresult">The <code>WLANRESULT</code> enumerated type</h1>

<p>
A simulation needing to define its own WLAN signal propagation model,
will call
<a href="api_set_wlan_model.php"><code>CNET_set_wlan_model</code></a>
to register a function that determines the
extent and success of wireless signal propagation.
This function must return one of the values of <code>WLANRESULT</code>:
</p>

<p></p>

<table class="thin" style="width: 100%;">

<tr>
    <th class="thin">WLANRESULT</th>
    <th class="thin">meaning</th>
</tr>
<tr>
    <td class="option0">WLAN_TOOWEAK</td>
    <td class="option0">the receiver cannot hear the WLAN signal at all</td>
</tr>

<tr>
    <td class="option1">WLAN_TOONOISY</td>
    <td class="option1">the receiver can hear the WLAN signal, but cannot discern its
	contents from the background noise</td>
</tr>
<tr>
    <td class="option0">WLAN_RECEIVED</td>
    <td class="option0">the WLAN signal is both heard and decodable</td>
</tr>
</table>

<?php require_once("cnet-footer.php"); ?>
