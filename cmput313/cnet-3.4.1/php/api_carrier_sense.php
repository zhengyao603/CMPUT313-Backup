<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_carrier_sense - determines if a <code>LT_LAN</code> or <code>LT_WLAN</code> link is busy.
<p></dd>

<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_carrier_sense(<b>int</b> link);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_carrier_sense</code> indicates if the indicated <code>LT_LAN</code>
or <code>LT_WLAN</code> link is currently transmitting or receiving a signal.
</p>

<p>
<dt>RETURN VALUE</dt>
<dd>
The value <code>1</code> is returned if the link is currently
transmitting or receiving a signal.
The value <code>0</code> is returned if there is no error,
and the link is neither transmitting nor receiving a signal.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to one of the
following values to describe the error:
</p>

<p>
<dl>
<dt><code>ER_BADLINK</code></dt>
    <dd>The value of <code>link</code> is not a valid link number.
    </dd>

<dt><code>ER_LINKDOWN</code></dt>
    <dd>The indicated link is down.
    </dd>

<dt><code>ER_NOTREADY</code></dt>
    <dd>The current node is rebooting.
    </dd>

<dt><code>ER_NOTSUPPORTED</code></dt>
    <dd>The indicated link is not of type <code>LT_LAN</code> or <code>LT_WLAN</code>.
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_write_physical.php">CNET_write_physical</a>.
</dd>

</dl>
<?php require_once("cnet-footer.php"); ?>
