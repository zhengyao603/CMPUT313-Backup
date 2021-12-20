<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_unused_timer_event - find a timer event, EV_TIMER*, that does not
have an associated event handler.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>CnetEvent</b> CNET_unused_timer_event(<b>void</b>);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_unused_timer_event</code> finds (at runtime) an unused timer event -
one that does not have associated event handler.
This enables independent source-code files in a large protocol to
find and use a timer event without interfering with
the actions of other source-code files.
</p>

<p>
If the function call is successful,
the returned event is not 'reserved' by <i>cnet</i>.
It is anticipated that a call to
<a href="api_set_handler.php">CNET_set_handler</a> will next be made,
passing the returned event as the first parameter.
</p>
</dd>


<dt>RETURN VALUE</dt>
<dd>
On success,
one of the standard timer events,
<code>EV_TIMER0</code> to <code>EV_TIMER9</code>,
will be returned.
On failure,
if there are no unused timer events,
the value <code>EV_NULL</code> will be returned.
<p>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_set_handler.php">CNET_set_handler</a>,
<a href="api_start_timer.php">CNET_start_timer</a>, and
<a href="api_timer_data.php">CNET_timer_data</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
