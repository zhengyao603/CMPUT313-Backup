<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_write_physical, CNET_write_physical_reliable - write data frames
to the Physical Layer
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_write_physical(<b>int</b> link, <b>const void</b> *frame, size_t *length);
<b>int</b> CNET_write_physical_reliable(<b>int</b> link, <b>const void</b> *frame, size_t *length);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_write_physical</code> requests that the indicated number of bytes,
pointed to by <code>frame</code>,
be written "down to" the Physical Layer.
If accepted, the Physical Layer will attempt to transmit the data frame
on the indicated <code>link</code>,
which can be of type
<code>LT_LOOPBACK</code>, <code>LT_WAN</code>, <code>LT_LAN</code>, or <code>LT_WLAN</code>.
Depending on the characteristics of the link,
the data frame may be subject to corruption, loss, or collisions.
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
On invocation, <code>length</code> must point to an integer indicating the number
of bytes to be copied from <code>frame</code>.
On return, the integer pointed to by <code>length</code> will now contain
the number of bytes accepted by the Physical Layer.
</p>

<p>
<code>CNET_write_physical_reliable</code> performs identically to
<code>CNET_write_physical</code>
except that the written data frame will not suffer any
corruption, loss, or collisions in the Physical Layer.
In addition,
<code>CNET_write_physical_reliable</code> permits new frames to be
written to a link while the previous one is still being transmitted.
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
    <dd>Either <code>frame</code> is a <code>NULL</code> pointer,
    or <code>length</code> is equal to zero.
    </dd>

<dt><code>ER_BADLINK</code></dt>
    <dd>The value of <code>link</code> is less than zero, or greater than the
    number of physical links of the current node.
    </dd>

<dt><code>ER_BADSIZE</code></dt>
    <dd>The value of <code>length</code> exceeds the capacity of the Physical
    Layer link being written to.
    </dd>

<dt><code>ER_LINKDOWN</code></dt>
    <dd>The link being written to is currently down.
    </dd>

<dt><code>ER_NOBATTERY</code></dt>
    <dd>The current mobile node's battery is exhausted.
    </dd>

<dt><code>ER_NOTREADY</code></dt>
    <dd>The current node has not yet finished rebooting,
    the indicated WLAN link is in sleep mode,
    or the link has not yet completed transmitting the previous frame.
    </dd>

<dt><code>ER_TOOBUSY</code></dt>
    <dd>
    The link has not yet completed transmitting the previous frame,
    or an attempt has been made to write more than 1000 frames to the
    indicated link before any of them have been read by the receiving node
    (this restriction is imposed to trap obvious errors in protocols).
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_write_direct.php">CNET_write_direct</a> and
<a href="api_read_physical.php">CNET_read_physical</a>
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
