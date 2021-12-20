<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_read_keyboard - read a line of input from the node's keyboard
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_read_keyboard(<b>void</b> *line, <b>int</b> *length);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
Requests the specified maximum number of bytes from the keyboard
buffer placing them in the address pointed to by <code>line</code>.
On invocation, <code>length</code> will point to an integer indicating the maximum
number of bytes that may be copied into <code>line</code>.
</p>

<p>
On return, <code>line</code> will contain a NULL-byte terminated
string of characters (not including a newline character)
and the integer pointed to by <code>length</code> will
contain <code>strlen(line)+1</code>.
</p>

<p>
<code>CNET_read_keyboard()</code> should be called
from within the handler for the <code>EV_KEYBOARD</code> event.
There is no mechanism to "poll" the keyboard to see if any key has been pressed.
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
    <dd>Either <code>line</code> or <code>length</code> is an invalid pointer,
    or the value pointed to by <code>length</code> is less than or equal to zero.
    </dd>

<dt><code>ER_BADSIZE</code></dt>
    <dd>The value pointed to by <code>length</code> is not long enough to
	receive the keyboard input.
    </dd>

<dt><code>ER_NOTREADY</code></dt>
    <dd>The function has not been called in response to
	an <code>EV_KEYBOARD</code> event.
    </dd>

<dt><code>ER_NOTSUPPORTED</code></dt>
    <dd>The function has been called from a nodetype
	that does not have a keyboard.
    </dd>

</dl>
</dd>

<!--
<dt>SEE ALSO</dt>
<dd>
aaa,
bbb,
ccc
</dd>
-->

</dl>

<?php require_once("cnet-footer.php"); ?>
