<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_read_physical - read a data frame from the Physical Layer
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_read_physical(<b>int</b> *link, <b>void</b> *frame, size_t *length);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_read_physical</code> requests that a data frame be read from the
Physical Layer.
The specified maximum number of bytes from the Physical Layer
are copied to the address pointed to by <code>frame</code>.
On invocation, <code>length</code> must point to an integer indicating the
maximum number of bytes that may be copied into <code>frame</code>.
</p>

<p>
Each node has a fixed number of links,
the first available physical link is number <code>1</code>,
the second is number <code>2</code>, and so on.
As a special case,
a node may <i>reliably</i> transmit a frame to itself by requesting
the <code>LOOPBACK(=0)</code> link.
</p>

<p>
On return, the integer pointed to by <code>length</code> will contain the number
of bytes read from the Physical Layer.
If <code>link</code> is not <code>NULL</code>,
then the integer pointed to by <code>link</code> will contain the link number
on which the frame arrived.
<p></dd>


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
    <dd>Either <code>frame</code> or <code>length</code>
    is a <code>NULL</code> pointer.
    </dd>

<dt><code>ER_BADSIZE</code></dt>
    <dd>The value of <code>length</code> is shorter than next available data frame.
    </dd>

<dt><code>ER_CORRUPTFRAME</code></dt>
    <dd>The recently arrived data frame was corrupted in the Physical Layer
    and the <a href="options.php#option-e"><b>-e</b></a>
    command-line option was given.
    </dd>

<dt><code>ER_NOTREADY</code></dt>
    <dd>The current node has not yet finished rebooting.
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_write_physical.php">CNET_write_physical</a>,
<a href="api_write_physical.php">CNET_write_physical_reliable</a>, and
<a href="api_write_direct.php">CNET_write_direct</a>
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
