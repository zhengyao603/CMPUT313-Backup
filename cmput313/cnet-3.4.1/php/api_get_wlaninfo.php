<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_get_wlaninfo - get the transmission and reception characteristics of a WLAN link
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>typedef struct</b> {
    <b>double</b>    frequency_GHz;
    <b>double</b>    tx_power_dBm;
    <b>double</b>    tx_cable_loss_dBm;
    <b>double</b>    tx_antenna_gain_dBi;

    <b>double</b>    rx_antenna_gain_dBi;
    <b>double</b>    rx_cable_loss_dBm;
    <b>double</b>    rx_sensitivity_dBm;
    <b>double</b>    rx_signal_to_noise_dBm;

    <b>double</b>    sleep_current_mA;
    <b>double</b>    idle_current_mA;
    <b>double</b>    tx_current_mA;
    <b>double</b>    rx_current_mA;
} WLANINFO;

<b>int</b> CNET_get_wlaninfo(<b>int</b> link, WLANINFO *wlaninfo);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_get_wlaninfo</code> retrieves the transmission and reception
characteristics of a link of type <code>LT_WLAN</code>.
</p>

<p>
<code>CNET_get_wlaninfo</code> assumes that its second argument is a pointer
to a <code>WLANINFO</code> structure, whose definition is provided
in <code>&lt;cnet.h&gt;</code> .
The fields defining the transmitting "half" of each <code>LT_WLAN</code> link
are prefixed by <code>tx_</code>,
and the fields defining the receiving "half"
are prefixed by <code>rx_</code> .
</p>

<p>
The units of transmission and reception power are decibel-milliwatts (dBm),
with values near 15.0dBm being typical for a PCMCIA-type wireless card.
An equivalent power measured in Watts (typically 30mW for a PCMCIA card)
is related to power measured in decibel-milliwatts using the formula:
</p>

<p>
<pre>    dBm  =  10*log10(Watts / 0.001)</pre>
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
than idle state.
The battery energy consumed by these four states depends on how long the link
is in each state.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
<dd>
The value <code>0</code> is returned on success.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to one of the
following values to describe the error:
<p>

<dl>
<dt><code>ER_BADLINK</code></dt>
    <dd>The value of <code>link</code> is not a valid link number.
    </dd>

<dt><code>ER_NOTSUPPORTED</code></dt>
    <dd>The indicated link is not of type <code>LT_WLAN</code>.
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_set_wlaninfo.php">CNET_set_wlaninfo</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
