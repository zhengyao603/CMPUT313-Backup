<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_set_trace - indicate which event handlers should be traced
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_set_trace(<b>int</b> eventmask);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
Event tracing is normally an "all-or-nothing" situation -
if requested via <i>cnet's</i> <code>-t</code> command-line switch,
the execution of all event handlers is annotated.

More specific event tracing may be requested at runtime by
specifying an eventmask,
such as <code>TE_APPLICATIONREADY|TE_PHYSICALREADY</code>.
If event tracing is requested,
just the indicated events will be annotated.
Each node maintains its own eventmask.
</p>

<p>
The annotation of all event handlers may be requested by calling
<code>CNET_set_trace(TE_ALLEVENTS)</code>, this is the default, and
all event handler annotation may be disabled by calling
<code>CNET_set_trace(TE_NOEVENTS)</code>.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
The node's previous eventmask is returned.
There are no errors.

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_get_trace.php">CNET_get_trace</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
