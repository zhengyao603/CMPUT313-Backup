<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_set_wlancolour - set the colour of the WLAN signal on the graphical interface
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_set_wlancolour(<b>int</b> link, CnetColour colour);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>When using <i>cnet</i>'s graphical interface,
    <code>CNET_set_wlancolour</code> sets the colour of the wireless signal
    drawn on the simulation map.
    <p>
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
<dt><code>ER_BADARG</code></dt>
    <dd>The value of <code>colour</code> is not a valid value of the
    <code>CnetColour</code> enumerated type.
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
<a href="api_get_wlaninfo.php">CNET_get_wlaninfo</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
