<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_set_wlan_model - define a WLAN signal propagation function
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>typedef enum</b> { WLAN_TOOWEAK, WLAN_TOONOISY, WLAN_RECEIVED } WLANRESULT;

<b>typedef struct</b> {
    <b>int</b>          tx_n;
    CnetPosition tx_pos;
    WLANINFO     *tx_info;

    <b>int</b>          rx_n;
    CnetPosition rx_pos;
    WLANINFO     *rx_info;

    <b>double</b>       rx_strength_dBm;
} WLANSIGNAL;

<b>int</b> CNET_set_wlan_model( WLANRESULT (*newmodel)(WLANSIGNAL *sig) );
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_set_wlan_model</code> permits a simulation to register a
function that determines the extent and success of wireless signal
propagation. Only one such function is recorded per-simulation.
</p>

<p>
If <code>NULL</code> is provided as the single parameter,
<i>cnet</i> uses its own internal (default) function.
</p>

<p>
Each time a wireless signal leaves its transmitting node,
the new propagation model function is called with a pointer to a
<code>WLANSIGNAL</code> structure whose elements describe the
transmitting (tx_*) and receiving nodes (rx_*) and their WLAN links.
</p>

<p>
The first 4 fields of the <code>WLANSIGNAL</code> structure
provide the transmitter's node number,
the transmitter's <code>x</code> and <code>y</code> coordinates on the simulation map,
and the characteristics of the transmitter's link.
The next 4 fields provide the same information about the receiving node.
The final field enables the function to report (to <i>cnet</i>)
the strength of the signal arriving at the receiver (in dBm).
</p>

<p>
The return type of the function is <code>WLANRESULT</code> -
the function must return
<code>WLAN_TOOWEAK</code> (if the receiver cannot hear the signal at all),
<code>WLAN_TOONOISY</code> (if the receiver cannot discern the signal from the
background noise), or
<code>WLAN_RECEIVED</code> (if the signal is heard and decodable).
</p>

<p>
If the result is <code>WLAN_TOOWEAK</code>,
the (potential) receiver will be unaware of the signal at all,
otherwise the receiver may learn of the signal by calling
<code>CNET_carrier_sense</code>.
If the result is <code>WLAN_RECEIVED</code>,
the <code>EV_PHYSICALREADY</code> event will (soon) be raised in the receiver. 
</p>
</dd>


<dt>RETURN VALUE</dt>
<dd>
The value <code>0</code> is always returned.

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_get_wlaninfo.php">CNET_get_wlaninfo</a> and
<a href="api_carrier_sense.php">CNET_carrier_sense</a>.
</dd>
</dl>
</dd>

<?php require_once("cnet-footer.php"); ?>
