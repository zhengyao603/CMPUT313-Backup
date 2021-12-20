<?php require_once("cnet-header.php"); ?>

<h1 id="eventdriven">The event driven programming style</h1>

<p>
<i>cnet</i> employs an <i>event-driven</i> style of programming similar,
though not identical,
to the data-link layer protocols presented in A.S. Tanenbaum
[Prentice-Hall,1988,...2003].
Execution proceeds when <i>cnet</i>
informs protocols that an <i>event of interest</i> has occurred.
Protocols are expected to respond to these events.
</p>

<p>
Events occur when
a node reboots,
the Application Layer has a message for delivery,
the Physical Layer receives a frame on a link,
a timer event expires,
a debugging button (under Tcl/Tk) is selected,
and a node is (politely) shutdown.
No event is delivered if a node pauses, crashes or suffers a hardware failure.
These last few events only occur in simulations designed to
address the higher layers of the OSI model (say, the Session Layer).
</p>

<dl>
<dt><b>IMPORTANT:</b></dt>
    <dd> <i>cnet</i> employs an <i>event-driven</i> style of
    programming, not an <i>interrupt-driven</i> style.
    In particular,
    while an event handler is executing it will <i>not</i> be interrupted by
    the arrival of another event.
    In support of this,
    there are no facilities to specify non-interruptable, high-priority
    handlers nor to protect data structures with semaphores or monitors
    (you won't need them!).
    </dd>
</dl>

<p>
Event-handling functions must first be registered to receive incoming
events with a call to <code>CNET_set_handler()</code>.
Event-handling functions will be later called by <i>cnet</i>
with three parameters.
The first is the type of event (the reason the handler is being called),
one of the <code>CnetEvent</code> enumerated values.
The second parameter is a unique timer (described later)
and the third,
some user-specified data.
</p>

<p>
Each node is initially rebooted by calling its <code>reboot_node()</code> function.
This is the only function that you must provide and is assumed to have
the name <code>reboot_node()</code> unless overridden with either the
<a href="options.php#option-R">-R</a> option
or the <code>rebootfunc</code> node attribute.
The purpose of calling <code>reboot_node()</code> is to give protocols
a chance to allocate any necessary dynamic memory,
initialize variables,
inform <i>cnet</i> in which events protocols are interested,
and which handlers that <i>cnet</i> should call when these events occur.
</p>

<dl>
<dt><b>IMPORTANT:</b></dt>
    <dd>Event-handling functions must execute to their completion -
    they must perform their actions and then simply return.
    <i>cnet</i> does not employ pre-emptive scheduling - once an event
    handling function is being executed, it <i>will not</i> be interrupted
    by the arrival of another event.
    Event-handling functions are of type <code>void</code> -
    that is, they do not return a value.
    If event-handling functions do not return,
    the whole simulation, including all windowing,
    will block and <i>cnet</i> must be interrupted via the <i>shell</i>.
    </dd>
</dl>

<p></p>

<h1>An example of <i>cnet</i>'s event handlers</h1>

Consider the following protocol skeleton.
<p>
Like all <i>cnet</i> protocol files,
the standard <i>cnet</i> header file is first included.
This contains all definitions and function prototypes necessary for protocols.
</p>

<p>
Execution commences at the <code>reboot_node()</code> function
(like commencing at <code>main()</code> in a standard C program).
<code>reboot_node()</code> first informs <i>cnet</i>
that when the Application Layer has a message for delivery to another host
(because <code>EV_APPLICATIONREADY</code> occurs)
<i>cnet</i> should call the function <code>new_message()</code> which
reads the new message from the Application Layer to commence the
delivery process.
The function <code>frame_arrived()</code> will similarly be called when the
<code>EV_PHYSICALREADY</code> event occurs.

<div class="code" style="width: 42em;">
#include &lt;cnet.h&gt;

<b>void</b> new_message(CnetEvent ev, CnetTimerID timer, CnetData data)
{
    ...
    success = CNET_read_application( ... );
    ...
}

<b>void</b> frame_arrived(CnetEvent ev, CnetTimerID timer, CnetData data)
{
    ...
    success = CNET_read_physical( ... );
    ...
}

<b>void</b> reboot_node(CnetEvent ev, CnetTimerID timer, CnetData data)
{
    ...
    success = CNET_set_handler(EV_APPLICATIONREADY, new_message, 0);
    success = CNET_set_handler(EV_PHYSICALREADY,    frame_arrived, 0);
    ...
}
</div>

<p>
A user-defined data value must be
initially provided as the third parameter to <code>CNET_set_handler()</code>.
When the handler's event eventually occurs,
the same value is passed as the third parameter to the handler.
Within more complex protocols,
you will typically want to pass an integer or, with care,
a pointer, via this third parameter.
The user-defined data value for timeout handlers
(for <code>EV_TIMER0..EV_TIMER9</code>)
must also be provided as the third parameter to <code>CNET_start_timer()</code>.
</p>

<p>
We can also write the above code as:
</p>

<div class="code" style="width: 42em;">
#include &lt;cnet.h&gt;

EVENT_HANDLER(new_message)
{
    ...
    success = CNET_read_application( ... );
    ...
}

EVENT_HANDLER(frame_arrived)
{
    ...
    success = CNET_read_physical( ... );
    ...
}

EVENT_HANDLER(reboot_node)
{
    ...
    success = CNET_set_handler(EV_APPLICATIONREADY, new_message, 0);
    success = CNET_set_handler(EV_PHYSICALREADY,    frame_arrived, 0);
    ...
}
</div>

<p>
<code>EVENT_HANDLER</code> is simply a C macro
defined in the &lt;cnet.h&gt; header file.
While this (completely optional)
style improves both readability and consistency,
it can introduce confusion as to where the three formal parameters,
<code>ev, timer</code> and <code>data</code>,
actually "come from".
However, the parameters passed to event handlers are rarely used in
practice, so this form is considered more convenient.
</p>

<p></p>

<h1 id="argv">Providing command-line parameters when a node reboots</h1>

<p>
As a special case, the <code>data</code> (third) parameter to each node's
handler for the <code>EV_REBOOT</code> event provides "command-line"
arguments when that node reboots.
The value passed in <code>data</code> is a pointer to a
<code>NULL</code>-terminated vector of character strings,
akin to the value of <code>argv</code> in a traditional C program.
Consider the following example code:
</p>

<div class="code" style="width: 42em;">
#include &lt;cnet.h&gt;

<b>void</b> reboot_node(CnetEvent ev, CnetTimerID timer, CnetData data)
{
    <b>char</b>    **argv  = (<b>char</b> **)data;
    <b>int</b>     argc    = 0;

    <b>if</b>(argv[0] != NULL) {
	printf("command line arguments:");
        <b>for</b>(argc=0 ; argv[argc] != NULL ; ++argc)
            printf(" '%s'", argv[argc]);
        printf("\n");
    }
    <b>else</b>
        printf("no command line arguments\n");
    ...
}
</div>

<p>
The optional command-line arguments for the <code>EV_REBOOT</code> handler
may either be passed on <i>cnet</i>'s own command-line
(after the name of the topology file or
the <a href="options.php#option-r">-r</a> option),
or provided (as a single string) via the
<a href="attributes.php#nodeattrs"><code>rebootargs</code></a>
node attribute in the topology file.
</p>

<p></p>

<h1 id="timers">Timers</h1>

<p>
<i>cnet</i> supports 10 timer event <i>queues</i>
providing a call-back mechanism for the protocol code.
For example,
the event <code>EV_TIMER1</code> may be requested to be "raised"
in <code>5000000usec</code>, and <i>cnet</i> will call
the <code>EV_TIMER1</code> event-handler in <code>5</code> seconds' time.
Timers are referenced via <i>unique</i> values of type <code>CnetTimerID</code>.
For example:
</p>

<div class="code" style="width: 42em;">
CnetTimerID  timer1;
.....
timer1 = CNET_start_timer(EV_TIMER1, (CnetTime)5000000, 0);
</div>

<p>
The timer has significance for functions handling timer events;
all other handlers will simply receive the special <code>NULLTIMER</code>.
Notice that timers do not reflect the current time,
nor how much time remains until they expire;
they simply specify <i>which</i> timer has expired.
When a timer expires,
the event-handler for the corresponding event is invoked with the event and
the unique timer as parameters.
Timers may be cancelled prematurely
with <code>CNET_stop_timer()</code>
to prevent them expiring,
for example:
</p>

<pre>    <code>(<b>void</b>)CNET_stop_timer(timer1);</code></pre>

<p>
though they are automatically cancelled
as a result of their handler being invoked.
</p>

<p></p>

<h1>Determining which physical link has just been severed or reconnected</h1>

<p>
As a special case, the <code>data</code> (third) parameter to each node's
handler for the <code>EV_LINKSTATE</code> event indicates which
physical link has just been severed or reconnected.
Consider the following example code:
</p>

<div class="code" style="width: 42em;">
#include &lt;cnet.h&gt;

<b>void</b> link_state_changed(CnetEvent ev, CnetTimerID timer, CnetData data)
{
    <b>int</b>     link = (<b>int</b>)data;

    <b>if</b>(linkinfo[link].linkup) {
	......
    }
    <b>else</b> {
        ......
    }
}
</div>

<p>
When the <code>EV_LINKSTATE</code> hander is invoked,
the node's values of <code>linkinfo[]</code> reflect
the new (current) state of each link.

<?php require_once("cnet-footer.php"); ?>
