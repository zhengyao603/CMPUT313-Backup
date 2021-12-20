<?php require_once("cnet-header.php"); ?>

<h1>Wireless LANs and mobile nodes</h1>

<p>
<i>cnet</i> supports mobile and wireless networking,
with functions supporting mobile nodes (of node type <code>NT_MOBILE</code>)
with wireless local area network links (of link type <code>LT_WLAN</code>).
Only nodes of type <code>NT_MOBILE</code> may move during the simulation,
but all types of nodes may have links of type <code>LT_WLAN</code>.
Information described here:
</p>

<ul>
    <li> <a href="#links">Wireless links</a></li>
    <li> <a href="#lifetime">The lifetime of a wireless signal</a></li>
    <li> <a href="#defaults">The default characteristics of WLAN links</a></li>
    <li> <a href="#setmodel">Defining your own WLAN propagation model</a></li>
    <li> <a href="#mobility">Node mobility</a></li>
</ul> 

<p style="text-align: center;"><img src="images/wlans.png" alt="wlans"></p>

<hr>

<p></p>

<h1>Wireless links</h1>

<p>
All node types may have one or more wireless links,
and mobile nodes may <i>only</i> have wireless links.
Links of type <code>LT_WLAN</code> are, by default,
modelled on Orinoco PCMCIA Silver/Gold cards,
but most <a href="attributes.php">link attributes</a>
may be set in the topology file to override the defaults.
</p>

<p>
A WLAN link may be in one of four states.
In <i>sleep</i> state, a link cannot transmit nor receive signals,
and consumes very little energy.
From <i>idle</i> state, the link may be asked to temporarily
enter <i>transmit</i> state to transmit a signal,
and will temporarily enter <i>receive</i> state to receive each signal
within range.
Idle, transmit, and receive states all consume considerably more energy
than the sleep state.
The battery energy consumed by these four states depends on how long the link
is in each state.
</p>

<p>
<a href="api_set_wlanstate.php"><code>CNET_get_wlanstate</code></a>
determines the current state of a WLAN link, and
<a href="api_set_wlanstate.php"><code>CNET_set_wlanstate</code></a>
may be called to set the link into either <i>sleep</i> or <i>idle</i> state.
It is not possible to set a WLAN link's state to either <i>transmit</i> or
<i>receive</i>.
Transitions to these states occur automatically, from the <i>idle</i> state,
whenever a link is asked to transmit a signal,
or when a signal arrives.
</p>

<p>
During simulations,
nodes may examine and modify the transmission and reception
characteristics of their wireless links by calling
<a href="api_get_wlaninfo.php"><code>CNET_get_wlaninfo</code></a> and
<a href="api_set_wlaninfo.php"><code>CNET_set_wlaninfo</code></a>.
</p>

<p>
All wireless power attributes are measured in decibel-milliwatts (dBm),
units that are related to milliWatts by the relationship
<code>dBm&nbsp;=&nbsp;10xlog<sub>10</sub>(Watts / 0.001)</code>.
</p>

<p>
The only wireless link attribute that cannot be modified during a
simulation is the link's frequency of transmission.
As an example, we can change the transmission power of a wireless link
with the function:
</p>

<div class="code" style="width: 48em;">
<b>void</b> set_TX_power(<b>int</b> link, <b>double</b> new_power)
{
    WLANINFO    wlaninfo;
    
    CHECK( CNET_get_wlaninfo(link, &amp;wlaninfo) );
    printf("previous power value was %.2fdBm\n", wlaninfo.tx_power_dBm);

    wlaninfo.tx_power_dBm = new_power;
    CHECK( CNET_set_wlaninfo(link, &amp;wlaninfo) );
}
</div>

<p>
Nodes may determine the signal strength and direction of signals arriving via
their wireless links.
The function
<a href="api_wlan_arrival.php"><code>CNET_wlan_arrival</code></a>
should be called within the event handler for <code>EV_PHYSICALREADY</code>,
to determine the characteristics of the most recently arrived signal:
The signal strength is measured in dBm, and the angle of arrival
is measured in radians (0 = 3 o'clock, pi/2 = 12 o'clock).
</p>

<div class="code" style="width: 48em;">
EVENT_HANDLER(wlan_ready)
{
    <b>char</b>          packet[1024];
    size_t        length = <b>sizeof</b>(packet);
    <b>int</b>           link;
    <b>double</b>        signalstrength, angle;

    CHECK( CNET_read_physical(&amp;link, packet, &amp;length) );

    CHECK( CNET_wlan_arrival(link, &amp;signalstrength, &amp;angle) );
    <b>if</b>(angle &gt; -M_PI_4 &amp;&amp; angle &lt; M_PI_4)
        printf("a %.3fdBm signal has arrived from the east\n",
                signalstrength):
}
</div>

<p></p>
<hr>

<p></p>

<h1 id="lifetime">The lifetime of a wireless signal</h1>

It is instructive to follow the <i>lifetime of a wireless signal</i>
<p>
in <i>cnet</i>,
to determine how it is transmitted, propagates, and is received.
The following picture,
reproduced with permission from
<a href="https://www.proxim.com/">Terabeam Wireless</a>,
explains the principle components in wireless transmission.
Terabeam Wireless also provide a helpful
<a href="https://www.proxim.com/en/products/link-calculation-tools">signal loss
calculator</a> which may be used to support your <i>cnet</i> experiments.
</p>

<p style="text-align: center;"><img src="images/fsl.png" alt="fsl"></p>

<p>
The typical sequence of execution of <i>cnet</i> wireless protocols
is as follows:
</p>

<p>
<ol>
<li> A node calls <a href="api_write_physical.php">CNET_write_physical</a>,
providing a link of type <code>LT_WLAN</code> as the first parameter,
and the bytes to be transmitted as the second.

<li> The bytes are encoded by the wireless network interface card and
output at the <i>transmission power level</i> of the card.

<li> The signal first travels along a cable to the antenna,
and may experience some <i>cable signal loss</i> in the cable.
For PCMCIA cards, we assume the cable is extremely short and exhibits no loss.

<li> The signal is transmitted from an antenna and,
depending on the design(shape) of the antenna,
may appear to be amplified (have an <i>antenna gain</i>) because the
signal is directed and does not propagate outwards in a perfect sphere.

<li> By default,
<i>cnet</i> currently employs a simple free-space-loss (FSL) model of
signal propagation, with the signal's <i>propagation loss</i> being related
determined by the <i>transmission frequency</i> and the <i>distance</i>
between nodes.
The signal's strength decreases in an inverse-squared relationship,
with nodes further from the source obviously receiving weaker signals.

<li> The signal propagates in all directions at the speed of light,
which <i>cnet</i> manages at 300m/usec.

<p>
The following points now apply to all nodes that are able to "hear" the
signal:
</p>

<li> If a node's receiving antenna receives signals at the same frequency,
the signal is gathered by the antenna, with its power level possibly
increased (an <i>antenna gain</i>) due to the antenna's shape.

<li> The signal travels from the antenna along a cable,
possibly experiencing some <i>cable signal loss</i>,
and arrives at the receiver's network interface card.

<li> The signal arriving at the network interface card can be "heard"
if the signal's strength exceeds the <i>sensitivity</i> of the interface.

<li> The content of the signal (our originally transmitted bytes) may
be discerned from the background noise
if the signal's strength exceeds the strength of the noise by more than
the card's <i>signal to noise</i> ratio.

<li> The <code>EV_PHYSICALREADY</code> event is raised in the receiving node's code.
An event handler calls
<a href="api_read_physical.php">CNET_read_physical</a> to obtain the bytes
and determine the link on which they arrived.
Finally,
<a href="api_wlan_arrival.php">CNET_wlan_arrival</a> may be called to
determine the strength and angle of arrival of the just arrived signal.
</ol>

<hr>

<p></p>

<h1 id="defaults">The default characteristics of WLAN links</h1>

<p>
<i>cnet</i> models its <code>LT_WLAN</code> links
on Orinoco PCMCIA Silver/Gold cards,
with the following characteristics:
</p>

<table class="thin" style="width: 100%;">
<tr>
    <th class="thin">characteristic</th>
    <th class="thin">default value</th>
</tr>
<tr>
    <td class="option0">transmission frequency</td>
    <td class="option0">2.45GHz</td>
</tr>
<tr>
    <td class="option1">transmission power</td>
    <td class="option1">14.771dBm</td>
</tr>
<tr>
    <td class="option0">cable loss in transmitter</td>
    <td class="option0">0.0dBm</td>
</tr>
<tr>
    <td class="option1">antenna gain in transmitter</td>
    <td class="option1">2.14dBi</td>
</tr>
<tr>
    <td class="option0">free-space-loss equation</td>
    <td class="option0" style="white-space: nowrap;">92.467 + 20xlog<sub>10</sub>(km_between_nodes) + 20xlog<sub>10</sub>(freq_GHz)</td>
</tr>
<tr>
    <td class="option1">antenna gain in receiver</td>
    <td class="option1">2.14dBi</td>
</tr>
<tr>
    <td class="option0">cable loss in receiver</td>
    <td class="option0">0.0dBm</td>
</tr>
<tr>
    <td class="option1">interface card sensitivity</td>
    <td class="option1">-82.0dBm</td>
</tr>
<tr>
    <td class="option0">receiver signal-to-noise ratio</td>
    <td class="option0">16.0dBm</td>
</tr>
<tr>
    <td class="option1">current drawn in sleep state</td>
    <td class="option1">9.0mA</td>
</tr>
<tr>
    <td class="option0">current drawn in idle state</td>
    <td class="option0">156.0mA</td>
</tr>
<tr>
    <td class="option1">current drawn in transmit state</td>
    <td class="option1">285.0mA</td>
</tr>
<tr>
    <td class="option0">current drawn in receive state</td>
    <td class="option0">185.0mA</td>
</tr>
</table>

<p>
In combination, these default characteristics permit (theoretically, perfect)
transmissions to be heard (detected and decoded) up to 173 metres away,
and the wireless carrier to be sensed (just detected) 1096 metres away.
The functions
<a href="api_get_wlaninfo.php"><code>CNET_get_wlaninfo</code></a> and
<a href="api_set_wlaninfo.php"><code>CNET_set_wlaninfo</code></a>
may be called to change all characteristics.
</p>

<p>
A transmitting node does not receive a copy of its own signal.
If a new signal arrives at a node already receiving another signal,
a collision results, and neither signal is fully received
(and no <code>EV_PHYSICALREADY</code> event is raised).
</p>

<hr>

<p></p>

<h1 id="setmodel">Defining your own WLAN propagation model</h1>

<p>
The WLAN characteristics and the circular free-space-loss equation,
described above,
form <i>cnet</i>'s default signal propagation model.
</p>

<p>
More realistic simulations may wish to employ different models that define
other signal propagation equations,
introduce randomness into the propagation,
or account for impenetrable obstacles on the simulation map
(knowledge of such obstacles could also be "shared" when managing node mobilty).
</p>

<p>
<i>cnet</i>'s
<a href="api_set_wlan_model.php"><code>CNET_set_wlan_model</code></a>
function permits a simulation to register a function that determines the
extent and success of wireless signal propagation.
Only one such function is recorded per-simulation,
and so, say, only node 0 needs to call <code>CNET_set_wlan_model</code>
during its <code>EV_REBOOT</code> handler.
<code>CNET_set_wlan_model</code> just expects a single parameter -
(the address of) the new propagation model function.
</p>

<p>
Consider this simple example -
within 50 metres of a transmitter its signal is perfectly detected and decoded,
between 50 metres and 100 metres the signal may be decoded
with a decreasing likelihood,
and beyond 100 metres the signal cannot be detected at all.
</p>

<div class="code" style="width: 48em;">
WLANRESULT simple_WLAN_model(WLANSIGNAL *sig)
{
    <b>double</b>      dx, dy, dz;
    <b>double</b>      metres;

<i>//  CALCULATE THE DISTANCE TO THE RECEIVER</i>
    dx       = sig-&gt;tx_pos.x - sig-&gt;rx_pos.x;
    dy       = sig-&gt;tx_pos.y - sig-&gt;rx_pos.y;
    dz       = sig-&gt;tx_pos.z - sig-&gt;rx_pos.z;
    metres   = sqrt(dx*dx + dy*dy + dz*dz);

    <b>if</b>(metres &lt; 50)
        <b>return</b> WLAN_RECEIVED;

    <b>if</b>(metres &lt; 100)
        <b>return</b> ((rand()%50) &gt;= (metres-50)) ?
                 WLAN_RECEIVED : WLAN_TOONOISY;

    <b>return</b> WLAN_TOOWEAK;
}
</div>

<p>
Each time a wireless signal leaves its transmitting node,
the propagation model function is called with a pointer to a
<code>WLANSIGNAL</code> structure whose elements describe the transmitting (tx_)
and receiving nodes (rx_) and their WLAN links.
</p>

<p>
The first 4 fields of the <code>WLANSIGNAL</code>
structure provide the transmitter's node number,
the transmitter's <code>x</code> and <code>y</code> coordinates on the simulation map,
and the characteristics of the transmitter's link.
The next 4 fields provide the same information about the receiving node.
The final field enables the function may pass back (to <i>cnet</i>)
the strength of the signal arriving at the receiver (in dBm).
</p>

<p>
The return type of the function is
<a href="datatypes.php#wlanresult"><code>WLANRESULT</code></a>.
The function must return one of the values:
</p>

<ul>
<li> <code>WLAN_RECEIVED</code> -
    the signal is detected and decodable.
    The receiver's <code>EV_PHYSICALREADY</code> event will (soon) be raised.

<li> <code>WLAN_TOONOISY</code> -
    the receiver cannot decode the signal from the background noise.

<li> <code>WLAN_TOOWEAK</code> -
    the (potential) receiver will be completely unaware of the signal.
</ul>

<p>
If the result is other than <code>WLAN_TOOWEAK</code>,
a receiver may determine the presence of signal by calling
<a href="api_carrier_sense.php"><code>CNET_carrier_sense</code></a>.
If two or more signals arrive at a receiver at the same time,
the receiver's <code>EV_FRAMECOLLISION</code> event will (soon) be raised.
</p>

<p>
The code for <i>cnet</i>'s default (internal) function,
based on the simple free-space-loss (FSL) model,
appears below.
</p>

<div class="code" style="width: 48em;">
WLANRESULT fsl_WLAN_model(WLANSIGNAL *sig)
{
    <b>double</b>      dx, dy, dz;
    <b>double</b>      metres;
    <b>double</b>      TXtotal, FSL, budget;

<i>//  CALCULATE THE TOTAL OUTPUT POWER LEAVING TRANSMITTER</i>
    TXtotal     = sig-&gt;tx_info-&gt;tx_power_dBm - sig-&gt;tx_info-&gt;tx_cable_loss_dBm +
                    sig-&gt;tx_info-&gt;tx_antenna_gain_dBi;

<i>//  CALCULATE THE DISTANCE TO THE RECEIVER</i>
    dx          = sig-&gt;tx_pos.x - sig-&gt;rx_pos.x;
    dy          = sig-&gt;tx_pos.y - sig-&gt;rx_pos.y;
    dz          = sig-&gt;tx_pos.z - sig-&gt;rx_pos.z;
    metres      = sqrt(dx*dx + dy*dy + dz*dz);

<i>//  CALCULATE THE FREE-SPACE-LOSS OVER THIS DISTANCE</i>
    FSL         = (92.467 + 20.0*log10(sig-&gt;tx_info-&gt;frequency_GHz)) +
                    20.0*log10(metres/1000.0);

<i>//  CALCULATE THE SIGNAL STRENGTH ARRIVING AT THE RECEIVER</i>
    sig-&gt;rx_strength_dBm   = TXtotal - FSL +
         sig-&gt;rx_info-&gt;rx_antenna_gain_dBi - sig-&gt;rx_info-&gt;rx_cable_loss_dBm;

<i>//  CAN THE RECEIVER DETECT THIS SIGNAL?</i>
    budget      = sig-&gt;rx_strength_dBm - sig-&gt;rx_info-&gt;rx_sensitivity_dBm;
    <b>if</b>(budget &lt; 0.0)
        <b>return</b> WLAN_TOOWEAK;

<i>//  CAN THE RECEIVER DECODE THIS SIGNAL?</i>
    <b>return</b> (budget &lt; sig-&gt;rx_info-&gt;rx_signal_to_noise_dBm) ?
        WLAN_TOONOISY : WLAN_RECEIVED;
}
</div>

<p>
(Messy details!)
Any user-defined propagation function is evaluated in the
context of the transmitting node.
The function needs to be very fast -
it will be called <i>millions</i> of times in a typical simulation.
The function should not modify any fields of <code>sig-&gt;tx_info</code> or
<code>sig-&gt;rx_info</code>.
</p>

<hr>

<p></p>

<h1 id="mobility">Node mobility</h1>

<p>
<i>cnet</i> simulations run on a rectangular simulation map,
whose dimensions, in metres, may be specified by the
<a href="attributes.php">global attributes</a> of
<code>mapwidth</code> and <code>mapheight</code>.
Distances, in metres,
are used in the default calculations of wireless signal strength and
propagation delay of <code>LT_WLAN</code> transmissions.
</p>

<p>
Mobile nodes may determine their own position,
and the dimensions of the simulation map,
by calling <a href="api_get_position.php"><code>CNET_get_position</code></a>,
and may then change their location on the map
by calling <a href="api_set_position.php"><code>CNET_set_position</code></a>.
</p>

<p>
There is no direct support in <i>cnet</i> for a node to undertake steady motion,
but if <code>CNET_set_position</code> is called from within a handler for a
<a href="timers.php">timer event</a>, then we can attain the same result.
For example, the following code moves a node along a diagonal path every second:
</p>

<div class="code" style="width: 48em;">
EVENT_HANDLER(walk_diagonal)
{
    CnetPosition   now, max;

    CHECK( CNET_get_position(&amp;now, &amp;max) );
    <b>if</b>(now.x &lt; max.x &amp;&amp; now.y &lt; max.y) {
        ++now.x;
        ++now.y;
	CHECK( CNET_set_position(now) );
        CNET_start_timer(ev, 1000000, data);
     }
}
</div>

<?php require_once("cnet-footer.php"); ?>
