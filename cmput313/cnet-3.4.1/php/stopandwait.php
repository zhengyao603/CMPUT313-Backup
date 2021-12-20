<?php require_once("cnet-header.php"); ?>

<h1>A complete <i>stopandwait</i> Data-Link Layer protocol</h1>

<p>
At the risk of stealing the thunder of other professors or instructors,
we finally present a complete example of the <i>stopandwait</i> Data-Link
Layer protocol.
No effort is made to describe <i>cnet</i> features that we've seen above,
nor how the protocol works - please consult a
good undergraduate textbook on data communications and computer
networking.
The example is imaginatively named
<a href="stopandwait.c">stopandwait.c</a>, supported by
<a href="STOPANDWAIT">STOPANDWAIT</a>.
</p>

<p>
This implementation is based on Tanenbaum's `protocol 4',
2nd edition, p227 (or his 3rd edition, p205).
This protocol employs only data and acknowledgement frames -
piggybacking and negative acknowledgements are not supported.
</p>

<p>
We first define some <i>global</i> types, data structures, and variables
for this protocol.
It is important to understand that each of these is <i>unique</i> to each
of the nodes in the simulation.
Although each of the nodes will typically use the same source code file,
each node has its own local copy of its variables.
It is not possible for one node to modify the variables in another node.
The only way for the nodes to communicate is via the Physical Layer.
</p>

<div class="code" style="width: 46em;">
#include &lt;cnet.h&gt;
#include &lt;stdlib.h&gt;
#include &lt;string.h&gt;

<b>typedef enum</b>    { DL_DATA, DL_ACK }   FRAMEKIND;

<b>typedef struct</b> {
    <b>char</b>        data[MAX_MESSAGE_SIZE];
} MSG;

<b>typedef struct</b> {
    FRAMEKIND    kind;       <i>// only ever DL_DATA or DL_ACK</i>
    size_t       len;        <i>// the length of the msg field only</i>
    <b>int</b>          checksum;   <i>// checksum of the whole frame</i>
    <b>int</b>          seq;        <i>// only ever 0 or 1</i>
    MSG          msg;
} FRAME;

#define FRAME_HEADER_SIZE  (sizeof(FRAME) - sizeof(MSG))
#define FRAME_SIZE(f)      (FRAME_HEADER_SIZE + f.len)

MSG             lastmsg;
size_t          lastlength              = 0;
CnetTimerID     lasttimer               = NULLTIMER;

<b>int</b>             ackexpected             = 0;
<b>int</b>             nextframetosend         = 0;
<b>int</b>             frameexpected           = 0;
</div>

<p>
We first declare a type, <code>MSG</code>,
to receive a message from the node's Application Layer.
We do not know, nor care, what will be in these messages,
and so it is reasonable to declare them as an array of bytes of some
maximum length, <code>MAX_MESSAGE_SIZE</code>.
We also declare a type, <code>FRAME</code>, to carry the messages across the
Physical Layer.
Each instance of <code>FRAME</code> consists of two parts - firstly,
the frame <i>header</i> consisting of four fields,
and then the frame <i>body</i> or <i>payload</i> which is actually a message.
We define two txtual constants in C, <code>FRAME_HEADER_SIZE</code>
and <code>FRAME_SIZE(f)</code> to simplify the coding of our protocol.
We finally define six global variables - three to keep a copy of,
and remember atttributes of the last message received from
the Application Layer,
and three integers to track the sequence numbers of the <i>stopandwait</i>
protocol.
Note that the variables
<code>lastmsg</code>,
<code>lastlength</code>,
<code>lasttimer</code>,
<code>nextframetosend</code>, and
<code>ackexpected</code> are all required by the <i>sender</i> of the protocol,
and that only <code>frameexpected</code> is required by the <i>receiver</i>.
However, because each node executes its own copy of the compiled code,
using its own variables,
and at any time takes on the role of either <i>sender</i> or <i>receiver</i>,
the approach of defining all variables together is considered reasonable.
</p>

<p>
We next look at the mandatory <code>reboot_node()</code> function,
and the simple handler of <code>EV_DEBUG1</code> which simply prints the
runtime <i>state</i> of the <i>stopandwait</i> protocol.
</p>

<div class="code" style="width: 46em;">
EVENT_HANDLER(reboot_node)
{
    <b>if</b>(nodeinfo.nodenumber &gt; 1) {
	fprintf(stderr,"This is not a 2-node network!\n");
	exit(1);
    }

    CHECK(CNET_set_handler( EV_APPLICATIONREADY, application_ready, 0));
    CHECK(CNET_set_handler( EV_PHYSICALREADY,    physical_ready, 0));
    CHECK(CNET_set_handler( EV_DRAWFRAME,        draw_frame, 0));
    CHECK(CNET_set_handler( EV_TIMER1,           timeouts, 0));
    CHECK(CNET_set_handler( EV_DEBUG1,           showstate, 0));

    CHECK(CNET_set_debug_string( EV_DEBUG1, "State"));

    <b>if</b>(nodeinfo.nodenumber == 1)
	CNET_enable_application(ALLNODES);
}

EVENT_HANDLER(show_state)
{
    printf(
    "\tackexpected\t= %d\n\tnextframetosend\t= %d\n\tframeexpected\t= %d\n",
		    ackexpected, nextframetosend, frameexpected);

}
</div>

<p>
As this file only provides a Data-Link layer protocol,
we first ensure that this is only a network of 2 nodes.
Note that if <i>any</i> node calls the C function <code>exit()</code>,
that the whole simulation will terminate.
There is little else new here other than handlers for the
<code>EV_APPLICATIONREADY</code> and <code>EV_DRAWFRAME</code> events.
</p>

<p>
<i>cnet</i> provides the ability for our interior protocols to control
the rate of new messages coming ''down'' from the Application Layer.
We do this by <i>enabling</i> and <i>disabling</i> the Application Layer or,
more particularly,
by enabling and disabling the generation of messages for certain remote hosts.
We need to call <code>CNET_enable_application()</code> in at least one
node for anything further to happen.
This protocol is written so that only one node (number 0) will
generate and transmit messages and the other (number 1) will receive them.
This self-imposed restriction makes it easier to understand early protocols.
The restriction can easily be removed by removing the line
</p>

<pre>    <code><b>if</b>(nodeinfo.nodenumber == 1)</code></pre>

<p>
in <code>reboot_node()</code>.
Both nodes will then transmit and receive (why?).
The meaning and handling of the <code>EV_DRAWFRAME</code> event is fully
described elsewhere -
see <a href="drawframes.php">Drawing data frames in <i>cnet</i></a>.
</p>

<p>
The first thing of interest that will occur after each node has rebooted
is that one node's Application Layer will generate and announce a new
message for delivery.
We handle the <code>EV_APPLICATIONREADY</code> event with
our <code>application_ready()</code> function:
</p>

<div class="code" style="width: 46em;">
EVENT_HANDLER(application_ready)
{
    CnetAddr destaddr;

    lastlength  = <b>sizeof</b>(MSG);
    CHECK(CNET_read_application(&amp;destaddr, (<b>char</b> *)&amp;lastmsg, &amp;lastlength));
    CNET_disable_application(ALLNODES);

    printf("down from application, seq=%d\n",nextframetosend);
    transmit_frame(&amp;lastmsg, DL_DATA, lastlength, nextframetosend);
    nextframetosend = 1-nextframetosend;
}
</div>

<p>
We first determine the maximum sized message that our protocol can handle
and pass that, by reference, to the <code>CNET_read_application()</code> function.
Asssuming that we have provided enough buffer space,
on return <code>CNET_read_application()</code> informs our interior protocol of
the intended network destination of the new message's destination,
copies the actual message into our variable <code>lastmsg</code>,
and modifies <code>lastlength</code> to tell us how long the message is.
We next call <code>CNET_disable_application()</code> to tell <i>our</i>
node's Application Layer to stop generating messages (for any node).
We finally pass the new message to <i>our</i> function,
<code>transmit_frame()</code> (shown shortly), along with parameters in
support of our <i>stopandwait</i> protocol.
<p>

Our <code>transmit_frame()</code> function performs the final actions before
something is transmitted across the Physical Layer.
Parameters provide the message to be transmitted,
an indication as to whether it is data or an acknowledgment,
its length, and its sequence number as part of the <i>stopandwait</i> protocol.
</p>

<div class="code" style="width: 46em;">
<b>void</b> transmit_frame(MSG *msg, FRAMEKIND kind, size_t msglen, <b>int</b> seqno)
{
    FRAME       f;

    f.kind      = kind;
    f.seq       = seqno;
    f.checksum  = 0;
    f.len       = msglen;

    <b>switch</b>(kind) {
      <b>case</b> DL_ACK :
        printf("ACK transmitted, seq=%d\n",seqno);
        <b>break</b>:

      <b>case</b> DL_DATA : {
        CnetTime   timeout;

        memcpy(&amp;f.msg, (<b>char</b> *)msg, (<b>int</b>)msglen);
        printf(" DL_DATA transmitted, seq=%d\n",seqno);

	timeout   = FRAME_SIZE(f)*(CnetTime)8000000 / linkinfo[1].bandwidth) +
				linkinfo[1].propagationdelay;
        lasttimer = CNET_start_timer(EV_TIMER1, timeout, 0);
        <b>break</b>:
      }
    }
    msglen      = FRAME_SIZE(f);
    f.checksum  = CNET_ccitt((<b>unsigned char</b> *)&amp;f, (<b>int</b>)msglen);
    CHECK(CNET_write_physical(1, (<b>char *</b>)&amp;f, &amp;msglen));
}
</div>

<p>
We initialize the <i>header</i> fields of a frame, of type <code>FRAME</code>,
and, if data, <i>embed</i> the message into the frame,
by copying the bytes of the message into the corresponding field of the frame.
Again, if the message is data, we need to estimate the amount of time that
it will take for the message to travel to its destination,
be processed by the remote node,
and for its acknowledgment frame to return.
It is important that we keep the units of our calculation correct -
a link's propagation delay is measured in microseconds,
the frame's size in bytes,
and a link's bandwidth in bits per second.
We multiply the whole calculation by <code>3</code> for a reasonable estimate
of the upper bound for the complete round-trip time.
We call <code>CNET_start_timer()</code> to have the <code>EV_TIMER1</code> event
raised sometime <i>after</i> we expect the acknowledgment to return.
<p>
We finally calculate a checksum of the frame to be transmitted,
embed the value of the checksum in the frame itself(!), and call
<code>CNET_write_physical()</code> to transmit the frame on link <code>1</code>.
<p>

Next, we provide the most complex handler of the <code>EV_PHYSICALREADY</code>
event, which is invoked when a frame arrives, via a link, at the Physical layer.
We first call <code>CNET_read_physical()</code> to read in the frame,
first telling it how much buffer space we are providing to receive the frame.
On return, the function tells us on which link the frame arrived,
copies the frame to our provided buffer space,
and tells us how long (in bytes) the frame is.
We again use <code>CHECK()</code> to automatically detect any errors.
<p>

We next use one of the provided checksum functions to determine if the
frame has been corrupted in its travel.
Although not demanded by <i>cnet</i>,
is is necessary to use the same checksum function on both sender and receiver.
We extract the <i>expected</i> checksum,
as calculated by the sender,
from the frame itself(!) and compare it with the locally calculated value.
It is unwise to attempt to make any sense of <i>any</i> of the contents
of a corrupted frame.
If we detect corruption, we simply ignore the newly arrived frame,
confident that it will be retransmitted in the future.
<p>

If the frame is an expected acknowledgment, we know that its corresponding
data frame has arrived safely, and so we stop the retransmission timer.
Gloating with pride, we call <code>CNET_enable_application()</code> so that the
Application Layer may generate the <i>next</i> message for delivery.
<p>

If the frame is expected data, we write a copy of the frame's embedded
message (only) to our Application Layer with <code>CNET_write_application()</code>.
We again use <code>CHECK()</code> to automatically detect if our protocol has
let through any errors.
Finally, if the frame was a data frame,
the expected one or not, we reply with an acknowledgment frame using
<code>transmit_frame()</code>, described earlier.
</p>

<div class="code" style="width: 46em;">
EVENT_HANDLER(physical_ready)
{
    FRAME        f;
    size_t       len;
    <b>int</b>          link, checksum;

    len         = <b>sizeof</b>(FRAME);
    CHECK(CNET_read_physical(&amp;link, (<b>char</b> *)&amp;f, &amp;len));

    checksum    = f.checksum;
    f.checksum  = 0;
    <b>if</b>(CNET_ccitt((<b>unsigned char</b> *)&amp;f, (<b>int</b>)len) != checksum) {
        printf("\t\t\t\tBAD checksum - frame ignored\n");
        <b>return</b>;           // bad checksum, ignore frame
    }

    <b>switch</b>(f.kind) {
      <b>case</b> DL_ACK : {
        <b>if</b>(f.seq == ackexpected) {
            printf("\t\t\t\tACK received, seq=%d\n", f.seq);
            CNET_stop_timer(lasttimer);
            ackexpected = 1-ackexpected;
            CNET_enable_application(ALLNODES);
        }
        <b>break</b>:
      }
      <b>case</b> DL_DATA : {
        printf("\t\t\t\tDATA received, seq=%d, ", f.seq);
        <b>if</b>(f.seq == frameexpected) {
            printf("up to application\n");
            len = f.len;
            CHECK(CNET_write_application((<b>char</b> *)&amp;f.msg, &amp;len));
            frameexpected = 1-frameexpected;
        }
        <b>else</b>
            printf("ignored\n");
        transmit_frame((MSG *)NULL, DL_ACK, 0, f.seq);
        <b>break</b>:
      }
    }
}
</div>

<p>
If the topology file sets either of the <code>probframecorrupt</code> or
<code>probframeloss</code> link attributes, and the data frame is corrupt or
lost, then the standard <code>stopandwait</code> protocol will not send
an acknowledgment from the receiver back to the sender.
Moreover, even if the data frame arrives safely,
the acknowledgment frame itself may be corrupt or lost on its return.
We thus require a ''timeout'' function to cause the retransmission of
a frame if the sender has not seen a valid acknowledgment frame after
some period of time.
Our <code>timeouts()</code> function handles the <code>EV_TIMER1</code> event for
the timer that was initially started in <code>transmit_frame()</code>.
Note that we do not need to explicitly stop a timer if its handler is
invoked - it is stopped implicitly by <i>cnet</i>.
</p>

<div class="code" style="width: 46em;">
EVENT_HANDLER(timeouts)
{
    <b>if</b>(timer == lasttimer) {
        printf("timeout, seq=%d\n", ackexpected);
        transmit_frame(&amp;lastmsg, DL_DATA, lastlength, ackexpected);
    }
}
</div>

<p>
Done. A real Data-Link Layer protocol providing reliable delivery in
the presence of frame corruption and loss.
</p>

<p></p>

<h1>Lessons learnt</h1>

<p>
Although <i>cnet</i> tries not to dictate how you write your interior
protocols, there are obviously a number of common ideas that appear in
these example protocols.
Some <i>are</i> necessary to enable correct interaction between the
<i>cnet</i> event scheduler and your event handlers,
but others may simply be considered as good style to both minimize errors
and to make your protocols readable by others:
</p>

<ol>
<li>  Each protocol source file must include the &lt;cnet.h&gt;
	header file.

<li>  All nodes actually execute the same (read-only) copy of the compiled
	protocol code, but each node has its own copy of any variables
	in the code - after all, each node is a simulating a distinct
	computer, and they don't share their RAM.
	Nodes may only communicate using the Physical Layer.

<li>  Each node's protocol code must have one function to receive the initial
	<code>EV_REBOOT</code> event.
	By default, this is named <code>reboot_node()</code> but may be renamed
	with the <a href="options.php#option-R">-R</a> command-line option.

<li>  All event handlers are invoked with three parameters providing
	the event (the reason for being invoked),
	a timer (often <code>NULLTIMER</code> if there is no meaningful timer),
	and a user provided data value.

<li>  The <code>reboot_node()</code> handler should indicate which future
	events are of interest with <code>CNET_set_handler()</code> and place
	labels on the debug buttons with <code>CNET_set_debug_string()</code>.

<li>  Event handlers should simply perform their responsibilities as
	quickly as possible, and then return to enable other handlers
	to be invoked.  They should not loop indefinitely, nor attempt
	to sleep, wait or poll for other events.

<li>  Calls to some functions, such as <code>CNET_read_application()</code> and
	<code>CNET_read_physical()</code>, must first indicate,
	using a parameter passed by reference, how much buffer space they are
	<i>providing</i> to receive some data.
	On return, these functions modify the same parameter to
	report how much buffer space was actually required and used.

<li>  Variables and function parameters used to hold the lengths of
      messages and frames should be of type <code>size_t</code>.

<li>  If a frame appears to have been corrupted in its travel
	(as determined by one of the provided checksum functions),
	it is unwise to attempt to make any sense of <i>any</i> of the
	contents of the frame.

<li>  Most functions provided by <i>cnet</i> return <code>0</code> on success
	and <code>1</code> on failure (with the obvious exception of the
	<code>CNET_start_timer()</code> function).
	Most function calls may be ''wrapped'' with the
	<a href="faq.php#check"><code>CHECK()</code></a>
	function to automatically detect and report most errors.
	It indicates a serious error in your protocols if one of the
	<i>cnet</i> functions reports an error and your protocol ignores it.

<li>  We do not need to explicitly stop a timer if its handler is
	invoked - it is stopped by <i>cnet</i>.
	However, it is not really a fatal error to stop a timer that
	has already expired.
</ol>

<p></p>
Good luck.

<?php require_once("cnet-footer.php"); ?>
