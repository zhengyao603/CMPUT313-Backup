<?php require_once("cnet-header.php"); ?>

<h1><i>cnet's</i> Timers</h1>

<p>
A total of 10 software timer <i>queues</i>
are supported to provide a call-back mechanism for user code.
For example,
when a data frame is transmitted a timer is typically created which will
expire sometime after that frame's acknowledgement is expected.
Timers are referenced via unique values termed <i>timers</i>
of datatype <code>CnetTimerID</code>.
</p>

<p>
When a timer expires,
the event handler for the corresponding event
(one of <code>EV_TIMER0..EV_TIMER9</code>)
is invoked with the event and unique timer as parameters.
</p>

<p>
Timers may be cancelled with <code>CNET_stop_timer</code>
to prevent them expiring
(for example, if the acknowledgement frame arrives before the timer expires).
Timers are automatically cancelled as a result of their handler being invoked.
</p>

<hr>

<p></p>

<h1>There are an unlimited number of timers</h1>

<p>
It is important to understand that an unlimited number of timers may be
started on each <i>queue</i> - there are not just 10 timers.
For example, the following section of code:
</p>

<div class="code" style="width: 44em;">
<b>void</b> timeouts(CnetEvent ev, CnetTimerID timer, CnetData data)
{
    <b>int</b> i = (<b>int</b>)data;

    printf("tick number %d\n", i);
}

<b>void</b> reboot_node(CnetEvent ev, CnetTimerID timer, CnetData data)
{
    CNET_set_handler(EV_TIMER3, timeouts, 0);
    <b>for</b>(<b>int</b> sec=1 ; sec&lt;=10 ; ++sec)
        CNET_start_timer(EV_TIMER3, (CnetTime)sec*1000000, (CnetData)sec);
}
</div>

<p>
will produce output identical to that from:
</p>

<div class="code" style="width: 44em;">
<b>void</b> timeouts(CnetEvent ev, CnetTimerID timer, CnetData data)
{
    <b>int</b> i = (<b>int</b>)data;

    printf("tick number %d\n", i);
    <b>if</b>(i &lt; 10)
	CNET_start_timer(EV_TIMER3, (CnetTime)1000000, (CnetData)i+1);
}

<b>void</b> reboot_node(CnetEvent ev, CnetTimerID timer, CnetData data)
{
    CNET_set_handler(EV_TIMER3, timeouts, 0);
    CNET_start_timer(EV_TIMER3, (CnetTime)1000000, (CnetData)1);
}
</div>

<p>
In the first example, there are initially 10 timers running simultaneously.
When each expires, the (same) handler for <code>EV_TIMER3</code> will be called.
</p>

<p>
In the second example,
there is only ever 1 timer running at one time,
and when it expires a new timer is started in the <code>EV_TIMER3</code> event
handler.
</p>

<?php require_once("cnet-footer.php"); ?>
