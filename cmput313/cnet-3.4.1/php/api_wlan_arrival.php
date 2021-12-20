<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_wlan_arrival - determine the characteristics of a recently arrived WLAN signal
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_wlan_arrival(<b>int</b> link, <b>double</b> *rx_signal_dBm, <b>double</b> *rx_angle);
</div>
</dt>
<p>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_wlan_arrival</code> provides the characteristics of the
signal that has recently arrived on the indicated <code>LT_WLAN</code> link.
</p>

<p>
The received signal strength, <code>rx_signal_dBm</code>,
is measured in decibel-milliwatts (dBm),
and the angle of arrival, <code>rx_angle</code>,
is in radians (0 = 3 o'clock, pi/2 = 12 o'clock, -pi/2 = 6 o'clock).
</p>

<p>
If <code>NULL</code> is presented for either signal attribute,
then that attribute is not reported.
</p>
</dd>


<dt>RETURN VALUE</dt>
<dd>
The value <code>0</code> is returned on success.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to one of the
following values to describe the error:
</p>

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
<a href="api_get_wlaninfo.php">CNET_get_wlaninfo</a> and
<a href="api_set_wlaninfo.php">CNET_set_wlaninfo</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
