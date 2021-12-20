<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_get_wlanstate, CNET_get_wlanstate - get or set a WLAN link's state
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_get_wlanstate(<b>int</b> link, WLANSTATE *state);

<b>int</b> CNET_set_wlanstate(<b>int</b> link, WLANSTATE newstate);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
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
</p>

<p>
<code>CNET_get_wlanstate</code> determines the current state of a WLAN link.
The variable of type <code>WLANSTATE</code> pointed to by <code>state</code>
will be set to the current state of the link.
</p>

<p>
<code>CNET_set_wlanstate</code> sets a WLAN link into either sleep or idle state.
Passing <code>WLAN_SLEEP</code> as the second parameter will set the link into
sleep state;
passing <code>WLAN_IDLE</code> will set the link into idle state.
It is not possible to set a WLAN link's state to either <code>WLAN_TX</code> or
<code>WLAN_RX</code>.
Transitions to these states occur automatically,
from the <code>WLAN_IDLE</code> state,
whenever a link is asked to transmit a signal,
or when a signal arrives.
</p>
</dd>


<dt>RETURN VALUE</dt>
<dd>
The value <code>0</code> is returned on success.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to one of the
following values to describe the error:
<p>

<dl>
<dt><code>ER_BADARG</code></dt>
    <dd>The value of <code>newstate</code> is neither <code>WLAN_SLEEP</code> or
	<code>WLAN_IDLE</code>.
    </dd>

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
