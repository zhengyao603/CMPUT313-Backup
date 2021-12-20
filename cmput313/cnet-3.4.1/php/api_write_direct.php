<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_write_direct - write a data frame directly to an indicated node
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_write_direct(CnetAddr destaddr, <b>const void</b> *frame, size_t *length);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_write_direct</code> requests that the indicated number of bytes,
pointed to by <code>frame</code>,
be written directly to the node indicated by <code>destaddr</code>.
This function thus 
provides a reliable network/routing layer for asynchronous message
passing, even if the source and destination nodes are not connected.
</p>

<p>
Messages transmitted using <code>CNET_write_direct</code> are considered to be
transmitted on, and arrive on, link number <code>1</code>.
The special destination address <code>ALLNODES</code> may be used to transmit a
message to all nodes except the sender.
Regardless of the number of hops, propagation delays, and bandwidth,
all frames sent via <code>CNET_write_direct</code> reach their destination in
just 1000usecs.
</p>

<p>
On invocation, <code>length</code> must point to an integer indicating the number
of bytes to be copied from <code>frame</code>.
On return, the integer pointed to by <code>length</code> will now contain
the number of bytes accepted by the Physical Layer.
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
    <dd>Either <code>frame</code> is a <code>NULL</code> pointer,
    or <code>length</code> is equal to zero.
    </dd>

<dt><code>ER_BADNODE</code></dt>
    <dd>The value of <code>destaddr</code> refers to the current node.
    </dd>

<dt><code>ER_NOTREADY</code></dt>
    <dd>The current node has not yet finished rebooting.
    </dd>

<dt><code>ER_TOOBUSY</code></dt>
    <dd>An attempt has been made to write more than 1000 frames to the
    indicated destination before any of them have been read.
    This restriction is imposed to trap obvious errors in protocols.
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_write_physical.php">CNET_write_physical</a>,
<a href="api_write_physical.php">CNET_write_physical_reliable</a>, and
<a href="api_read_physical.php">CNET_read_physical</a>
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
