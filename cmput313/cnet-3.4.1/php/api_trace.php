<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_trace - print formatted output to <code>cnet</code>'s trace stream.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_trace(<b>const char</b> *format, ...);
</div>
</dd>
<p>


<dt>DESCRIPTION</dt>
<dd>
If the execution of the <code>cnet</code> event currently being handled
by the current node is being traced,
a call to <code>CNET_trace()</code> will format and print the requested output to
<code>cnet</code>'s trace stream.
</p>

<p>
If execution is not currently being traced,
a call to <code>CNET_trace()</code> has no effect and, so, may be safely left
in a protocol's source code.
</p>

<p>
The arguments to <code>CNET_trace()</code> are just like those of the
standard-C function <code>printf()</code>,
and all of the standard formatting sequences (introduced with %)
are supported.
</p>

<p>
If the current simulation has registered a tracefile
(via its topology file),
the output of <code>CNET_trace()</code> will always be appended to that file.
</p>

<p>
When running under the Tcl/Tk graphical interface,
the output of <code>CNET_trace()</code>
also appears in a graphical pane below the main network "map".
</p>

<p>
When running without the Tcl/Tk graphical interface,
the output of <code>CNET_trace()</code>
also appears on <code>cnet</code>'s <code>stderr</code> output stream.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
This function always succeeds and returns the value <code>0</code>.
</dd>

<?php require_once("cnet-footer.php"); ?>
