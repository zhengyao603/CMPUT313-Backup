<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_read_application - obtain a new message to be delivered
<p>
</dd>

<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_read_application(CnetAddr *destaddr, <b>void</b> *message, size_t *length);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_read_application</code> requests that the next message for delivery
be copied into the provided message buffer.
<code>CNET_read_application</code> should only be called as the result of
receiving an <code>EV_APPLICATIONREADY</code> event.

<p>
On invocation, <code>length</code> must point to an integer indicating the
maximum number of bytes that may be copied into <code>message</code>.

<p>
On return,
the network address of the required destination node
will have been copied into <code>destaddr</code>,
the new message will have been copied into <code>message</code>,
and
the location pointed to by <code>length</code> will contain the number
of bytes copied into <code>message</code>.
<p>
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
    <dd>Any of <code>destaddr</code>, <code>message</code> or <code>length</code>
    is an invalid pointer.
</dd>

<dt><code>ER_BADSIZE</code></dt>
    <dd>The value pointed to by <code>length</code> is too short to receive
	the new message.
</dd>

<dt><code>ER_NOTREADY</code></dt>
    <dd>The Application Layer does not have a new message for delivery.
</dd>

<dt><code>ER_NOTSUPPORTED</code></dt>
    <dd>The current node does not have an Application Layer.
</p>
</dd>
</dl>

<dt>SEE ALSO</dt>
<dd>
<a href="api_write_application.php">CNET_write_application</a>
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
