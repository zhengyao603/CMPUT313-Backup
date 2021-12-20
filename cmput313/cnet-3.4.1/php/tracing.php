<?php require_once("cnet-header.php"); ?>

<h1>Tracing <i>cnet</i>'s execution</h1>

<p>
The development and debugging of network protocols is a difficult task.
Without the support of a development environment,
the development of even a two-node protocol requires access to both nodes
and, possibly, the physical communication medium.
This is, of course, one of the primary reasons that we use network
simulators, such as <i>cnet</i>.
We have the ability to "peek" inside each network node,
and even the communication links,
to see what is happening and to, hopefully, expose errors in our protocols.
</p>

<p>
Although <i>cnet</i> permits protocols to be written in C and
executed natively in a single operating system process,
it does not provide traditional debugging support.
Moreover (unfortunately) because of the way <i>cnet</i> manipulates the
single process's data segments to transparently schedule nodes,
standard debuggers, such as <i>gdb</i>,
can't "keep up" with what is happening and begin reporting incorrect
information.
</p>

<p>
<i>cnet</i> aids the development and debugging of network protocols with a
minimum of intrusion.
<i>cnet</i> enables the delivery and execution of events and <i>cnet</i>'s
own functions to be <i>traced</i>.
Each event's commencement and termination, and each function's invocation,
parameters, and return value annotated.
The picture below shows a <i>cnet</i> simulation which was commenced with
the <a href="options.php#option-t">-t</a> option to enable tracing.
</p>

<img src="images/tracing.png" alt="tracing">

<p>
The displayed first line of the trace, above, indicates that the
handler for the <code>EV_APPLICATIONREADY</code> event
for the node Hobart is being invoked at time <code>40,134,044usecs</code>.
Four lines later, execution leaves the same handler.
While executing the handler,
three of <i>cnet</i>'s standard functions were invoked.
</p>

<p>
The first of these (line 2) was
<a href="api_read_application.php"><code>CNET_read_application</code></a>.
On invocation the first two parameters are addresses
(such as requested with C's &amp; operator) to receive the destination
address and actual contents of the next message.
These addresses are printed as
hexadecimal values because no interpretation can be placed on their
initial contents, nor the memory to which these addresses refer.
In reality, the third parameter is also passed by address,
but we know that it represents the maximum possible length of the second
parameter (to receive the new message), so we are able to report that the
maximum length "provided" on entry to the function was <code>8192</code>.
</p>

<p>
The return value of <code>CNET_read_application</code> was <code>0</code>,
indicating success,
and the side-effects of the function,
modifying the destination address and length of the new message are also
reported with the new values of <code>4</code> and <code>1603</code> respectively.
If an error had been detected,
the trace would indicate a return value of <code>-1</code> together with the
new value of the <code>CnetError</code> type in <code>cnet_errno</code>.
</p>

<p>
Note that due to <i>cnet</i>'s
<a href="eventdriven.php">event driven</a> programming style,
that events do not interrupt or preempt one another.
The trace stream will always show what is being executed with only one
level of indentation.
</p>

<p>
With reference to the this screenshot,
we can see that the next event for Melbourne, at <code>40,136,855usecs</code>,
was a frame arriving on the Physical Layer's link 1.
In response to this frame arrival,
Melbourne has written 6843 bytes to its own Application Layer
(probably after removing one or more headers from the just arrived frame),
and has then transmitted a short 24 bytes frame, also on link 1.
Such a short frame, and the use of link 1 again,
suggests that this is an acknowledgment frame being sent to the Data Link
Layer of the node on the other end of this link.
</p>

<p>
The tracing of function parameters using only their hexadecimal addresses
is error-prone and confusing.
Moreover, different local variables in different event
handlers will have the same hexadecimal addresses (as they'll be on the
function's runtime stack), leading to more confusion.
Additional <i>cnet</i> API calls may be added to the protocol's code,
such as:
</p>

<div class="code">
CNET_trace_name(&amp;destaddr, "dest");
CNET_trace_name(lastmsg,   "newmessage");
</div>

<p>
to request that the strings
<code>"dest"</code> and <code>"newmessage"</code>
be printed whenever the addresses of the variables
<code>destaddr</code> and <code>lastmsg</code> would otherwise be printed in
hexadecimal.
Calls to <code>CNET_trace_name</code> should be placed near the entry of each
event handler, and obviously before an address is to be traced.
The <code>CNET_trace_name</code> function is not, itself, traced.
</p>

<p>
By default, a copy of <i>cnet</i>'s <i>trace stream</i> appears in
the trace-window when <i>cnet</i> is invoked with
the <a href="options.php#option-t">-t</a> option.
Alternatively, tracing may be toggled using the windowing interface,
by selecting a checkbox to change the default or specific node's attributes.
When executing without the Tcl/Tk interface,
the trace stream appears via <i>cnet</i>'s <i>standard error</i> stream.
The complete trace stream may also be mirrored to a named file by setting the
<a href="attributes.php#gattrs">tracefile</a> global attribute. 
</p>

<p>
From within the C code of a protocol it is possible to trace only certain
events, possibly for only certain nodes of interest.
For example, a call such as
<code>CNET_set_trace(TE_APPLICATIONREADY)</code> will trace just
the <code>EV_APPLICATIONREADY</code> event for the invoking node.

The parameter to <code>CNET_set_trace</code> is really a bitmap of events of
interest, and so we may add or remove particular events
using C's bitwise operators:
</p>

<div class="code">
<b>if</b>(nodeinfo.nodenumber == 1) {

    <b>int</b>   oldmask, newmask;

     oldmask  =  CNET_get_trace();
     newmask  =  oldmask | TE_PHYSICALREADY | TE_TIMER2;

    CNET_set_trace(newmask);
    ......
    CNET_set_trace(oldmask);
}
</div>

<p>
All required <code>TE_*</code> constants are defined in <i>cnet</i>'s header
file, along with the useful <code>TE_ALLEVENTS</code> and <code>TE_NOEVENTS</code>.
During the execution of an event handler that is being traced,
an arbitrary string may also be displayed with <code>CNET_trace</code> function,
which accepts a standard C <i>printf</i> format specification.

<?php require_once("cnet-footer.php"); ?>
