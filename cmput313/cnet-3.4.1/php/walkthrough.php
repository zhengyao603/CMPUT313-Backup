<?php require_once("cnet-header.php"); ?>

<h1 id="walkthrough">A protocol walkthrough</h1>

<p>
Firstly, as seems
<a
href="https://en.wikibooks.org/wiki/Computer_Programming/Hello_world">mandatory</a>
when introducing new programming languages,
let's look at the traditional ''Hello&nbsp;World'' example written as a
<i>cnet</i> protocol.
Although <i>cnet</i> protocols are written in ISO-C99,
this example looks quite different:
</p>

<div class="code" style="width: 43em;">
#include &lt;cnet.h&gt;

<b>void</b> reboot_node(CnetEvent ev, CnetTimerID timer, CnetData data)
{
    printf("hello world\n");
}
</div>

<p>
Things to first note are that the source code includes the standard
<i>cnet</i> header file, as must all <i>cnet</i> protocol source files,
and that there is no traditional <code>main()</code> function, nor a call to
<code>exit()</code>, nor a return value.
However, this ''protocol'' does run - each node implementing this protocol
is rebooted when <i>cnet</i> invokes its <i>event-handler</i> for the
<code>EV_REBOOT</code> event.
The handler is passed the parameters of
<code>ev=EV_REBOOT</code>,
<code>timer=NULLTIMER</code>, and
<code>data=0</code>,
none of which are used by this simplest handler.
The handler prints out its message
<code>"hello&nbsp;world\n"</code> using the C function
<code>printf()</code>,
the message appears on the standard output window of each node (if running
under Tcl/Tk), and the handler finally returns to whoever called it
(in this case <i>cnet</i>'s internal scheduler).
</p>

<p>
In fact, the above protocol is so simple that it doesn't even need the usual
<i>cnet</i> <a href="topology.php">topology file</a>.
We can commence its execution just using <i>cnet</i>'s
<a href="options.php">command-line options</a>:
</p>

<pre>    <span class="shell">shell&gt;&nbsp;</span><code>cnet -C helloworld.c -r 2</code></pre>

<p>
We can even replace the <code>2</code>, above, with <code>101</code> to run
the protocol on a much larger, random, network.
Once every node in the network has rebooted and printed
<code>"hello&nbsp;world\n"</code> the whole simulation keeps running,
but doing nothing else because there is nothing left for it to do
(strictly speaking, <i>cnet</i> could detect that there are no more
significant events to schedule, and just terminate).
All noteworthy but pointless.
</p>

<p>
To make out protocols easier to read,
these examples will often use the <code>EVENT_HANDLER</code> C macro,
defined in the <code>&lt;cnet.h&gt;</code> header file.
Its full definition is:
</p>

<div class="code" style="width: 43em;">
#define EVENT_HANDLER(name)     \
        <b>void</b> name(CnetEvent ev, CnetTimerID timer, CnetData data)
</div>

<p>
This provides greater readability in protocol code,
which can simply declare its event handling functions with, for example: 
</p>

<div class="code" style="width: 43em;">
EVENT_HANDLER(timeouts)
{
    ....
}
</div>

<p>
Use of <code>EVENT_HANDLER</code> does, however, introduce some potential confusion.
As an consequence of being declared with <code>EVENT_HANDLER</code>,
each such function "automatically" has three formal parameters:
<code>ev, timer</code> and <code>data</code>.
While this improves both readability and consistency,
it may introduce confusion as to where the parameters actually "come from".
</p>

<p></p>

<h1>Introducing timer events</h1>

<p>
Next, we'll introduce the concept of
<a href="timers.php"><i>cnet</i> timers</a>
with the protocol source file <a href="ticktock.c"><code>ticktock.c</code></a>
and its associated topology file
<a href="TICKTOCK"><code>TICKTOCK</code></a>.
We'll walkthrough this protocol in a different order to the way it appears
in its source file.
The C99 requires all identifiers to have been defined,
or at least declared,
before they are used,
but we'll describe the functions in the order they will be invoked.
However, we can't avoid first
including the standard <i>cnet</i> header file.
Firstly, we'll examine the <code>reboot_node()</code> event-handler,
always the first function to be called by the <i>cnet</i> scheduler:
</p>

<div class="code" style="width: 43em;">
#include &lt;cnet.h&gt;

EVENT_HANDLER(reboot_node)
{
<i>//  Indicate that we are interested in the EV_TIMER1 event</i>

    CHECK(CNET_set_handler(EV_TIMER1, timeouts, 0));

<i>//  Request that EV_TIMER1 occur in 1sec, ignoring the return value</i>

    CNET_start_timer(EV_TIMER1, (CnetTime)1000000, 0);
}
</div>

<p>
The first <i>cnet</i> function called is <code>CNET_set_handler()</code>.
This instructs <i>cnet</i> to remember that <i>for this node</i> that any
time the <code>EV_TIMER1</code> event occurs, that <i>cnet</i> should call the
function <code>timeouts()</code> to handle the event.
The third parameter to <code>CNET_set_handler()</code> is actually ignored for
this call, but must always be provided.
The call to <code>CNET_set_handler()</code> is also ''wrapped'' in the function
<code>CHECK()</code>, described in the
<a href="faq.php#check">Frequently Asked Questions</a>,
to ''automatically'' detect any error occuring from the call to
<code>CNET_set_handler()</code>.
</p>

<p>
Finally, in <code>reboot_node()</code>, the function <code>CNET_start_timer()</code>
is called to request that the <code>EV_TIMER1</code> event be raised (once)
in 1 second's time.
All times in <i>cnet</i> are measured in microseconds,
and so we use 64-bit integers to hold these values
(which can grow quite quickly).
We use <i>cnet</i>'s <code>CnetTime</code> 64-bit integer datatype to
simplify the use of these values.
</p>

<p>
When the <code>EV_TIMER1</code> event occurs,
the third parameter to <code>CNET_start_timer()</code>, here <code>0</code>,
will be faithfully passed to the event handler for <code>EV_TIMER1</code>,
which we know to be the <code>timeouts()</code> function. 
Next, let's look at the <code>timeouts()</code> function, which we know will be
called 1 second after the <code>reboot_node()</code> handler is finished:
</p>

<div class="code" style="width: 43em;">
EVENT_HANDLER(timeouts)
{
    <b>static int</b> which = 0;

    printf("%3d.\t%s\n", which, (which%2) == 0 ? "tick" : "\ttock");
    ++which;

<i>//  Reschedule EV_TIMER1 to occur again in 1 second</i>                     

    CNET_start_timer(EV_TIMER1, (CnetTime)1000000, 0);
}
</div>

<p>
The <code>timeouts()</code> function will be called with three parameters:
<code>ev=EV_TIMER1</code>,
<code>timer=<i>somevalue</i></code>, and
<code>data=0</code>.
The value of the second parameter, <code>timer</code> will actually be the
<i>return</i> value of the call to <code>CNET_start_timer()</code> in
<code>reboot_node()</code>.
The return value is of type <code>CnetTimerID</code>,
but we are not concerned with its value in this simple protocol.
The <code>data=0</code> value is the third parameter given to the
<code>CNET_start_timer()</code> call in <code>reboot_node()</code>.
</p>

<p>
The first time that <code>timeouts()</code> is called,
it will simply print the string <code>0.&nbsp;tick</code>.
It then calls <code>CNET_start_timer()</code> to again request that the handler
for <code>EV_TIMER1</code> be called in a further 1 second.
Although <code>timeouts()</code> is, itself, the handler for <code>EV_TIMER1</code>,
this is <i>not</i> a recursive call as no handler will be called until
this <i>current</i> handler has returned.
The <code>timeouts()</code> function will be called, again, in another 1
seconds and will, this time, simply print <code>1.&nbsp;tock</code>.
That's all it does - printing <code>0.&nbsp;tick</code>,
<code>1.&nbsp;tock</code>, <code>2.&nbsp;tick</code>,
<code>3.&nbsp;tock</code> ... every second.
It's still not really a protocol.
</p>

<p></p>

<h1>Introducing the Physical Layer and debug events</h1>

<p>
We'll next consider an example which demonstrates how to transmit data
across <i>cnet</i>'s Physical Layer and to handle the button-based
''debug'' events.
The example is imaginatively named
<a href="click.c">click.c</a>, supported by
<a href="CLICK">CLICK</a>.
Firstly some declarations and the global data (character strings)
that we'll randomly transmit:
</p>

<div class="code" style="width: 43em;">
#include &lt;cnet.h&gt;
#include &lt;ctype.h&gt;
#include &lt;string.h&gt;

<b>int</b>  count    = 0;
<b>char</b> *fruit[] = { "apple", "pineapple", "banana", "tomato", "plum" };

#define NFRUITS        (sizeof(fruit) / sizeof(fruit[0]))
</div>

<p>
The first function called is, of course, <code>reboot_node()</code> to handle
the <code>EV_REBOOT</code> event.
In this handler we simply register this node's interest in a number of
events, passing to <code>CNET_set_handler()</code> the addresses of the
functions to be called when each event is raised.
We also call <code>CNET_set_debug_string()</code> to place an indicated
string/label on two of the five debug buttons available under Tcl/Tk.
Out of habit, we wrap each call with <code>CHECK</code> to ensure that there
have been no errors.
</p>

<div class="code" style="width: 43em;">
EVENT_HANDLER(reboot_node)
{
//  Indicate our interest in EV_DEBUG1, EV_DEBUG2 and EV_PHYSICALREADY

    CHECK(CNET_set_handler(EV_PHYSICALREADY, frame_arrived, 0));

    CHECK(CNET_set_handler(EV_DEBUG1,        send_reliable, 0));
    CHECK(CNET_set_debug_string( EV_DEBUG1, "Reliable"));

    CHECK(CNET_set_handler(EV_DEBUG2,        send_unreliable, 0));
    CHECK(CNET_set_debug_string( EV_DEBUG2, "Unreliable"));
}
</div>

<p>
We next look at two very similar functions.
Each chooses a random character string (a <code>fruit</code>),
uses it to format a frame for transmission,
and determines the length of the frame
(adding <code>1</code> for its <code>NULL</code>-byte terminator).
The length of the frame and a checksum of the frame
(using the <code>CNET_IP_checksum()</code> function provided by <i>cnet</i>)
are next reported.
<p>

The frame is finally transmitted across the Physical Layer.
In handler <code>send_reliable()</code> we call
<code>CNET_write_physical_reliable()</code>
to bypass <i>cnet</i>'s <a href="themodel.php">Error Layer</a>.
Handler <code>send_unreliable()</code> calls <code>CNET_write_physical()</code>,
and because <a href="CLICK">CLICK</a> introduces frame corruption
with a probability of one in four,
some of the frames will be corrupt during transmission.
<p>

The three parameters to the <code>CNET_write_physical*</code> functions
provide the required link number (<code>1</code>),
the address of the frame to be transmitted,
and the length (in bytes) of the frame.
The length is passed by reference because,
on return, the functions indicate how many bytes they
accepted by possibly modifying this reference parameter.
We will assume that all went well, and that all bytes were actually
transmitted.
There is no real need to have two such similar functions - we could,
instead, have a single function which handles both of the
<code>EV_DEBUG1</code> and <code>EV_DEBUG2</code> events and calls the appropriate
transmission function after inspecting the value of <code>ev</code>.

<div class="code" style="width: 43em;">
EVENT_HANDLER(send_reliable)
{
    <b>char</b>         frame[256];
    size_t       length;

    sprintf(frame, "message %d is %s", ++count, fruit[rand()%NFRUITS]);
    length      = strlen(frame) + 1;

    printf("sending %u bytes, checksum=%6d\n\n",
                 length,
                 CNET_IP_checksum((<b>unsigned short</b> *)frame,(<b>int</b>)length));
    CHECK(CNET_write_physical_reliable(1, frame, &amp;length));
}

EVENT_HANDLER(send_unreliable)
{
    <b>char</b>         frame[256];
    size_t       length;

    sprintf(frame, "message %d is %s", ++count, fruit[rand()%NFRUITS]);
    length      = strlen(frame) + 1;

    printf("sending %u bytes, checksum=%6d\n\n",
                 length,
                 CNET_IP_checksum((<b>unsigned short</b> *)frame,(<b>int</b>)length));
    CHECK(CNET_write_physical(1, frame, &amp;length));
}
</div>

<p>
Finally we handle the arrival of a frame with the handler for
the <code>EV_PHYSICALREADY</code> event, <code>frame_arrived()</code>.
We first determine the maximum length of the frame that we are <i>able</i>
to receive.
If this length is sufficient to receive the incoming frame,
the next call to <code>CNET_read_physical()</code> will inform us of
the link number on which the frame arrived (here, it will be <code>1</code>),
copy the frame into the address/space that we have provided, and
inform us of the frame's actual length (i.e. <code>length</code> will be
modified).
</p>

<div class="code" style="width: 43em;">
EVENT_HANDLER(frame_arrived)
{
    <b>char</b>         frame[256];
    size_t       length;
    <b>int</b>          link, i, ch;

    length   = <b>sizeof</b>(frame);
    CHECK(CNET_read_physical(&amp;link, frame, &amp;length));

    printf("    %u bytes arrived on link %d, checksum=%6d : \"",
              length, link,
              CNET_IP_checksum((<b>unsigned short</b> *)frame,(<b>int</b>)length));
    <b>for</b>(i=0 ; i&lt;length-1 ; ++i) {
        ch = frame[i];
        <b>if</b>(!(isalnum(ch) || ch == ' '))
            ch = '?';
        putchar(ch);
    }
    printf("\"\n\n");
}
</div>

<p>
We next report the length and link number of the new frame,
and again print its checksum (using the same checksum function as used by
the sender).
If the frame was corrupted in transmit,
we will observe that the ''before and after'' checksum values will be
different.
Identical checksum values indicate that the frame arrived intact.
We finally print out the actual bytes of the message -
if the frame arrives intact, we will see the expected message carrying tha
name of one of the fruits.
If the frame was corrupted, we will see a '?' character for any unexpected
byte.
</p>

<p>
OK, now that we've understood all of the above,
let's walk through
<a href="stopandwait.php">a complete <i>stopandwait</i> Data-Link Layer protocol</a>.
</p>


<?php require_once("cnet-footer.php"); ?>
