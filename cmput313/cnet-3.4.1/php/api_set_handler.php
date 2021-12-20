<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_set_handler - register function to be called when an event occurs.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_set_handler(CnetEvent ev, <b>void</b> (*function)(), CnetData data);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_set_handler()</code> registers a function (its address)
to be called when one of <i>cnet</i>'s events occurs.
Calls to <code>CNET_set_handler()</code> will typically be made during the
execution of a node's <code>EV_REBOOT</code> handler,
to register all handlers for the remainder of the simulation.
</p>

<p>
Multiple calls may be made to <code>CNET_set_handler()</code>
to register the same handler for multiple events.
It is then up to the event handler to determine why it was called.
Event handlers are properties of each node,
and each node may have different handlers for each of the events in which
it is interested.
</p>

<p>
Registering a <code>NULL</code> handler indicates that the calling
node has no interest in the indicated event (this is the default).
</p>

<p>
In most circumstances,
a copy of the third parameter, <code>data</code>,
is passed as the third parameter to the registered event handler.
The most significant exception to this rule is for the timer events,
for which each call to <code>CNET_start_timer()</code> provides the
<code>data</code> value to be delivered to the event handler.
</p>
</dd>


<dt>RETURN VALUE</dt>
<dd>
The value <code>0</code> is returned on success.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to one of the
following values to describe the error:
<p>

<dl>
<dt><code>ER_BADEVENT</code></dt>
    <dd>The first parameter was not a valid <i>cnet</i> event.
    </dd>

<dt><code>ER_NOTSUPPORTED</code></dt>
    <dd>An attempt was made to register a handler for an event that
    cannot occur on the current node.
    Examples include registering a handler for <code>EV_APPLICATIONREADY</code>
    from nodes without an Application Layer,
    or registering a handler for <code>EV_KEYBOARDREADY</code>
    from nodes without a keyboard.
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_get_handler.php">CNET_get_handler</a>,
<a href="api_unused_debug_event.php">CNET_unused_debug_event</a>,
<a href="api_unused_timer_event.php">CNET_unused_timer_event</a>, and
<a href="api_start_timer.php">CNET_start_timer</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
