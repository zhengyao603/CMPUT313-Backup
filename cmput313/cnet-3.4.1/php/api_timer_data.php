<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_timer_data - recover the data value associated with a running timer
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

CnetTimerID CNET_timer_data(CnetTimerID tid, CnetData *data);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_timer_data()</code>
enables recovery of the <code>CnetData()</code> value associated with the
timer identified by <code>tid</code>.
The data value was originally provided with a call to
<code>CNET_start_timer()</code>.
</p>

<p>
A typical use of <code>CNET_timer_data()</code> is to recover the address of
some dynamically allocated memory (allocated via <code>malloc()</code>)
just before calling <code>CNET_stop_timer()</code>.
If <code>CNET_timer_data()</code> is not used to recover dynamically allocated
memory in this manner, protocols will have a memory leak.
</p>

<p>
On success, the saved <code>CnetData</code> value is copied to the address
indicated by <code>data</code>.
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
    <dd>The value of <code>data</code> is an invalid pointer.
    </dd>

<dt><code>ER_BADTIMERID</code></dt>
    <dd>The value of <code>tid</code> does not represent a currently executing
	timer (the timer may have already expired).
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_start_timer.php">CNET_start_timer</a>, and
<a href="api_stop_timer.php">CNET_stop_timer</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
