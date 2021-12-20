<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_set_LED - set, or turn off, one of the node's status LEDs
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_set_LED(<b>int</b> led, CnetColour colour);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
When running under the GUI, each open node's window has a number of LEDs
that may be set to provide a quick indication of the node's running state.
</p>

<p>
Each LED may be set to one of the provided colours,
specified as a value of the <code>CnetColour</code> type,
or to the special value <code>CNET_LED_OFF</code>.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
The value <code>0</code> is returned on success.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to one of the
following values to describe the error:
<p>

<dl>
<dt><code>ER_BADARG</code></dt>
    <dd>Either the value of <code>led</code> is less than zero or greater than
    or equal to the number of LEDs (<code>CNET_NLEDS</code>),
    or the value of <code>colour</code> is <code>NULL</code>.
    </dd>

</dl>
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
