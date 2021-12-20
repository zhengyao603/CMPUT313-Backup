<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_start_timer - start the asynchronous execution of a new timer
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

CnetTimerID CNET_start_timer(CnetEvent ev, CnetTime usec, CnetData data);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_start_timer</code>
requests that a new timer be created which will expire in the
indicated number of microseconds.
</p>

<p>
A unique timer identifier is returned to distinguish this
newly started timer from all others.
</p>

<p>
When this timer expires (after <code>usecs</code> have elapsed),
the event handler of the indicated timer event,
<code>EV_TIMER0..EV_TIMER9</code>, will be called.
The parameters passed to the event handler will be <code>ev</code>,
the unique timer identifier, and the value of <code>data</code>.
</p>

<p>
If <code>data</code> refers to dynamically allocated memory (allocated via
<code>malloc</code>),
then the timer's handler should deallocate this memory,
else protocols will have a memory leak.
Similarly, if <code>CNET_stop_timer</code> is required to prematurely stop a
running timer, <code>CNET_timer_data</code> should first be used to recover
the value of <code>data</code>.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
A unique timer identifier of type <code>CnetTimerID</code> is returned on success.
On failure, the value <code>NULLTIMER</code> is returned,
and the global variable <code>cnet_errno</code> is set to one of the
following values to describe the error:
</p>

<p>
<dl>
<dt><code>ER_BADARG</code></dt>
    <dd>The value of <code>usec</code> is less than or equal to 0.
    </dd>

<dt><code>ER_BADEVENT</code></dt>
    <dd>The value of <code>ev</code> is not one of <code>EV_TIMER0..EV_TIMER9</code>.
    </dd>
</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_stop_timer.php">CNET_stop_timer</a>, and
<a href="api_timer_data.php">CNET_timer_data</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
