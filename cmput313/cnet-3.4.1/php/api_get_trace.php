<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_get_trace - determine which event handlers are being traced
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_get_trace(<b>void</b>);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_set_trace</code> indicates which event handlers are currently being
traced.
The returned integer value represents a bitwise mask with each set bit
indicating that the corresponding event handler is being traced.
Each node maintains its own eventmask.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
The node's current eventmask.
There are no errors.

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_set_trace.php">CNET_set_trace</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
