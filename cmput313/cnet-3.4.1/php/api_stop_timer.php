<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_stop_timer - stop the asynchronous execution of an existing timer
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_stop_timer(CnetTimerID tid);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_stop_timer</code> requests that the timer,
indicated by <code>tid</code>,
be stopped before it has completed its execution
(and before its event handler has been called).
</p>

<p>
Timers are forgotten as soon as their event handler is invoked,
and so attempting to stop a timer that has already expired results in an error.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
The value <code>0</code> is returned on success.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to the
following value to describe the error:
<p>

<dl>
<dt><code>ER_BADTIMERID</code></dt>
    <dd>The value of <code>tid</code> does not represent a currently executing
    timer (the timer may have already expired).
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_start_timer.php">CNET_start_timer</a>, and
<a href="api_timer_data.php">CNET_timer_data</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
