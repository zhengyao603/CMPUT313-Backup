<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i> Frequently Asked Questions</h1>

<p>
This page contains a number of Frequently Asked/Answered Questions (FAQs)
about the <i>cnet</i> network protocol simulator.
The questions here have been collated from students' actual questions
over recent years.
Please read this page first to ensure that you fully understand
what is happening and then be able to anticipate any errors that
you may confront.
</p>

<p>
Please email
<a href="mailto:Chris.McDonald@uwa.edu.au"><i>Chris.McDonald@uwa.edu.au</i></a>
if you find any errors here,
or think that some additional material should be added.
</p>

<b>Getting started</b>
<ul>
    <li> <a href="#start">How can I get started with <i>cnet</i>?</a>
    <li> <a href="#nowindows">Where can I get <i>cnet</i> for Windows?</a>
    <li> <a href="#compile">How can I compile my <i>cnet</i> protocol
		source files?</a>
    <li> <a href="#linking">How can my protocols access external functions?</a>
    <li> <a href="#terminate">Why does <i>cnet</i> terminate after 5 minutes?</a>
    <li> <a href="#multiple">How can I develop my <i>cnet</i> protocols
		in multiple files?</a>
</ul>

<b>Identity</b>
<ul>
    <li> <a href="#nnodes">How many nodes are there in my simulation?</a>
    <li> <a href="#nlinks">How many links does my node have?</a>
    <li> <a href="#addrs">What is the difference between a node's number
			    and its node address?</a>
</ul>

<b>Developing protocols</b>
<ul>
    <li> <a href="#link0">What is link zero ever used for?</a>
    <li> <a href="#nopreemption">What if an event occurs while I'm currently
		handling an event?</a>
    <li> <a href="#hangs">Why does my simulation, and the whole GUI,
		appear to hang?</a>
    <li> <a href="#debug">How can I debug my <i>cnet</i> programs?</a>
    <li> <a href="#output">Where did my code's output go?</a>
    <li> <a href="#tricks">Are there any simple tricks that can
		help my understanding?</a>
    <li> <a href="#eventhandler">What is the <code>EVENT_HANDLER</code> function
		that appears in most examples?</a>
    <li> <a href="#check">What is the <code>CHECK</code> function
		that appears in most examples?</a>
    <li> <a href="#drawframes">Can I see my protocol's datalink frames?</a>
</ul>

<b>Managing time and periodic activity</b>
<ul>
    <li> <a href="#timenow">How can I determine the current time?</a>
    <li> <a href="#printtime">How can I print a CnetTime value?</a>
    <li> <a href="#timers">What are timers and <code>CnetTimerID</code>s?</a>
    <li> <a href="#timers10">Why does <i>cnet</i> only provide 10 timers?</a>
    <li> <a href="#timerdata">What is the third parameter to
			    <code>CNET_start_timer</code> ever used for?</a>
    <li> <a href="#ownevents">Can I add my own <code>CnetEvent</code> events?</a>
</ul>

<b>Hidden meanings</b>
<ul>
    <li> <a href="#spelling">What is the meaning of
		"spelling mistake on line 83 of protocol.c"?</a>
    <li> <a href="#efficiency">What is the meaning of the statistic
		"Efficiency (bytes AL) / (bytes PL)"?</a>
    <li> <a href="#notready">What is the meaning of the error
		"ER_NOTREADY - Function called when service not available"?</a>
    <li> <a href="#toobusy">What is the meaning of the error
		"ER_TOOBUSY - Function is too busy/congested to handle request"?</a>
    <li> <a href="#signals">What is the meaning of
	    "caught signal number XX while (last) handling ......."?</a>
    <li> <a href="#nomore">What is the meaning of
	    "warning: no more events are scheduled"?</a>
</ul>

<b>Getting some real protocol simulation done</b>
<ul>
    <li> <a href="#speedup">How can I speed up my simulations?</a>
    <li> <a href="#plotting">How can I collate <i>cnet</i> statistics
		for plotting?</a>
    <li> <a href="#ownstats">How can each node collate its own statistics?</a>
    <li> <a href="#sharedstats">How can I collate my own global statistics?</a>
</ul>

<!-- ===================================================================== -->

<hr>

<h1 id="start">How can I get started with <i>cnet</i>?</h1>

<p>
There are many on-line WWW pages to help you to get
started with <i>cnet</i>.  Allow about two hours to read each of these
links and this FAQ:
</p>

<ul>
    <li><a href="introduction.php">
	    An introduction to <i>cnet</i></a> (with some screenshots).
    <li><a href="themodel.php">
		    The <i>cnet</i> simulation model</a>.
    <li><a href="topology.php">
		    Topology files</a>.
    <li><a href="attributes.php">
		    Global, node, and link attributes</a>.
    <li><a href="eventdriven.php">The event driven programming style</a>.
    <li><a href="walkthrough.php">Walk through some introductory protocols</a>.
</ul>

<p>
Firstly, read the <i>cnet</i> specific header file
(typically installed at <code>/usr/local/include/cnet.h</code>).
All <i>cnet</i> programs must include the line
</p>

<pre>    <code>#include &lt;cnet.h&gt;</code></pre>

<p>
to include the contents of this file.
In particular,
it is important that you understand the <code>CnetNodeinfo</code>
and <code>CnetLinkinfo</code> structures,
the <code>CnetEvent</code> and <code>CnetError</code> enumerated types
and the protoypes of commonly used functions.
These are all described in much greater detail in another set of web-pages:
</p>

<ul>
<li> <a href="api.php"><i>cnet's</i> layers and functions -
		the API</a>.
<li> <a href="options.php"><i>cnet's</i> many command line options</a>.
<li> <a href="datatypes.php"><i>cnet's</i> datatypes</a>.
<li> <a href="tracing.php">Tracing <i>cnet's</i> execution</a>.
<li> <a href="drawframes.php">Drawing datalink frames in <i>cnet</i></a>.
</ul>

<!-- ===================================================================== -->

<hr>

<h1 id="nowindows">Where can I get <i>cnet</i> for Windows?</h1>

<p>
<i>cnet</i> does not currently run under Windows,
and there are no current plans to port <i>cnet</i> to Windows.
All of <i>cnet</i>'s source code is released under the
GNU Public Licence (GPL).  Good luck.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="compile">How can I compile my <i>cnet</i> protocol source files?</h1>

<p>
You do not need to compile your protocol files yourself.
Simply executing
</p>

<pre>    <span class="shell">shell&gt;&nbsp;</span><code>cnet TOPOLOGY</code></pre>

<p>
will cause <i>cnet</i> to locate and compile your
C source files and produce a shared object file in your working directory
(e.g. <code>protocol.cnet</code>).
This shared object is then dynamically linked with
the <i>cnet</i> simulator at run-time.
</p>

<p>
The system's standard C compiler is used, preferably GNU's <i>gcc</i>.
All C error messages are reported by the compiler (not <i>cnet</i>).
All fatal and warning messages should be eliminated before your protocol
code can be considered syntactically correct.
You will probably receive many more error
messages than you've experienced before - the reason being that
the compiler  is invoked with extra compilation switches to be very
pedantic (this is good for your soul and in fact is how you should
always compile C code).
If you are concerned about any "black magic" destroying your code,
observe what happens by invoking <i>cnet</i> as:
</p>

<pre>    <span class="shell">shell&gt;&nbsp;</span><code>cnet <a href="options.php#option-d">-d</a> TOPOLOGY</code></pre>

<!-- ===================================================================== -->

<hr>

<h1 id="linking">How can my protocols access external functions?</h1>

<p>
Protocols written in <i>cnet</i> may access external functions,
such as functions in the Mathematics library.
For example, to access the old UNIX <code>sqrt</code> function,
we first need to add function prototypes to our protocols -
this is usually involves including a header file in our C code:
</p>

<pre>    <code>#include &lt;math.h&gt;</code></pre>

<p>
and then indicating in our topology file
that we need to link against an external library, with (for example):
</p>

<pre>    <code>compile = "protocol.c -lm"</code></pre>

<p>
The embedded switches <code>-l</code> and <code>-L</code>,
and any filenames ending in <code>.o</code> or <code>.a</code>,
are recognized as (assumed to be) arguments for the linker.
All other switches are assumed to be C-preprocessor and C-compiler switches.
</p>

<p>
<b>NOTE:</b>  By default, <i>cnet</i>'s header file
includes the header file <code>&lt;math.h&gt;</code>,
and links against the standard C mathematics library by appending <code>-lm</code>.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="terminate">Why does <i>cnet</i> terminate after 5 minutes?</h1>

<p>
Errors in your protocols which prevent an event handler from returning
when expected, prevent the <i>cnet</i> scheduler from performing correctly.
In particular,
the scheduler cannot service events from the windowing
system - for example your requests to kill <i>cnet</i> itself when you detect
a problem.
To overcome this major problem, <i>cnet</i> itself times-out after
5 minutes just in case you have written incorrect protocols which have
become 'stuck'.
Once you are confident that your protocols are working
as expected you can easily extend this 5 minute period with, for example,
</p>

<pre>    <code>cnet <a href="options.php#option-m">-m</a> 10 TOPOLOGY</code></pre>

<p>
where the command line option requests execution for
the required number of minutes.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="multiple">How can I develop my <i>cnet</i> protocols in multiple files?</h1>

<p>
As <i>cnet</i> projects become larger,
it's naturally wise to develop protocols in a number of different source files.
A natural method to partition the files is based on their responsibilities.
C (and of course many other programming languages) allow you to place
relatively independent sections of source code in separate files,
compile each source file individually, and to then link the resulting
object files to form a single executable file.
</p>

<p>
<i>cnet</i> also allows you to do this, but simplifies the activity. In your
topology file, replace a line such as
</p>

<pre>    <code>compile = "protocol.c"</code></pre>
with
<pre>    <code>compile = "dll.c nl.c routing.c queueing.c fragments.c"</code></pre>

<p>
(or whatever) and <i>cnet</i> will quietly compile and link all of the pieces.
Only one of the C source files needs to have a <code>reboot_node()</code> function.
</p>

<p>
<i>cnet</i> handles the compilation and linking quite happily,
unless it is interrupted.
If individual files appear to be not being compiled,
just remove all object files with
<code>rm *.o</code> and re-run <i>cnet</i>.
If you're interested in what's going on, invoke <i>cnet</i> with its
<a href="options.php#option-v"><code>-v</code></a>
switch to see the executed compilation and linking commands.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="nnodes">How many nodes are there in my simulation?</h1>

<p>
By default, <i>cnet</i> does not reveal the total
number of nodes in the simulation.
This encourages the development of protocols which
make no assumptions about the size of the network.
</p>

<p>
By setting the
<a href="options.php#option-N"><code>-N</code></a> command line option,
the number of nodes in the simulation is available in the
global integer variable <code>NNODES</code>.
Without <code>-N</code>, the value of <code>NNODES</code> is zero.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="nlinks">How many links does my node have?</h1>

<p>
The number of <i>physical</i> links connecting a node
(i.e. those of type <code>LT_WAN</code>, <code>LT_LAN</code>, or <code>LT_WLAN</code>),
is always available in the
global integer variable <code>nodeinfo.nlinks</code>.
</p>

<p>
Links are numbered within each node
from <code>0</code> to <code>nodeinfo.nlinks</code>.
Link number <code>0</code> is always the node's <code>LOOPBACK</code> link,
which simply delivers anything transmitted to it straight back to the same node.
</p>

<p>
The first physical link is number <code>1</code>,
and every node will have a link number <code>1</code>.
Each node's link attributes may be accessed, at runtime,
via elements of the C structure variables
<code>linkinfo[0]</code>,
<code>linkinfo[1]</code>,
<code>linkinfo[2]</code>, and so on.
</p>

<p>
When allocating an array of structures,
and then iterating across all physical links indexed by their link number,
you'll require code similar to:
</p>

<div class="code">
linkthings = calloc(nodeinfo.nlinks+1, <b>sizeof</b>(LINKTHING));
    ....
<b>for</b>(link=1 ; link&lt;=nodeinfo.nlinks ; ++link)
    linkthings[link].field = ....
</div>
<p></p>

<!-- ===================================================================== -->

<hr>

<h1 id="addrs">What is the difference between a node's number and its node address?</h1>

<p>
Nodes have both a number and an address -
node numbers (available in <code>nodeinfo.nodenumber</code>)
range from 0,1,2,.....NNODES-1,
whereas each node's address (available in <code>nodeinfo.address</code>)
can be any unique non-negative value.
<i>By default</i>
node numbers and node addresses are the same (0,1,2,....).
</p>

<p>
Setting a node address attribute in the topology file,
as with
</p>

<div class="code">
<b>host</b> Perth {
    <b>address</b>     = 351
    ....
}
</div>

<p>
should reveal a problem if your protocols are assuming that
node numbers and node addresses are always the same.
In particular,
the destination node addresses provided by
<a href="api_read_application.php"><code>CNET_read_application</code></a>
and expected by
<a href="api_write_direct.php"><code>CNET_write_direct</code></a>
are node addresses and not node numbers.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="link0">What is link zero ever used for?</h1>

<p>
Links are numbered within each node
from <code>0</code> to <code>nodeinfo.nlinks</code>.
Link number <code>0</code> is always the node's <code>LOOPBACK</code> link,
which simply delivers anything transmitted to it straight back to the same node.
</p>

<p>
The <code>LOOPBACK</code> link may be used when developing and debugging
protocols.  A node may construct, "transmit", and instrument data to itself,
to debug and test code receiving erroneous data,
without sending that data across the physical layer.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="nopreemption">What if an event occurs while I'm currently handling an event?</h1>

<p>
<i>cnet</i> does not employ pre-emptive scheduling - once an event
handling function is being executed,
it <i>will not</i> be interrupted by the arrival of another event.
</p>

<p>
Event-handling functions must execute to their completion in a timely
manner - they must perform their actions and then simply return.
Only then, will other pending events be delivered to their event handlers.
</p>

<p>
This style of event-driven programming makes protocol development much
easier.  Your code does not need to manage interrupts or semaphores,
or employ critical regions.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="hangs">Why does my simulation, and the whole GUI, appear to hang?</h1>

<p>
If one of your event handlers becomes stuck in an unbounded loop,
or does not return,
the whole simulation and its GUI will appear to hang.
The flow of execution must return to <i>cnet</i>'s scheduler,
in a timely manner,
so that any interaction with the GUI is received and further <i>cnet</i>
events are raised.
Your process is probably still executing,
but one of your protocol's event handlers is performing all activity.
</p>

<p>
You will need to terminate <i>cnet</i> from the command-line
(probably with Control-C).
Then, re-run the simulation with <i>cnet</i>'s 
<a href="tracing.php">trace window</a> displayed.
This will provide an annotation of each node's event handlers
and the <i>cnet</i> API's invoked while your event handlers are executing.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="debug">How can I debug my <i>cnet</i> programs?</h1>

<p>
Because many things appear to be happening simultaneously in <i>cnet</i>,
debugging <i>cnet</i> protocols can be difficult.
However, it is far easier than debugging protocols on different computers
in different geographic locations!
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
Most importantly, most <i>cnet</i> functions return an integer indicating
their success or failure (0 for success, -1 for failure).
<i>IT IS ESSENTIAL</i>
that you examine the function's return value to ensure that
it performed as expected.  If you ignore this return value your
protocols may fail at a much later stage in their execution and it will
be extremely difficult to track down your error.  If a function detects
an error (and returns -1) it will also set the node-specific variable
<code>cnet_errno</code>
to reflect what went wrong.
The most recent error detected
by <i>cnet</i> may then be printed from each node (to <code>stderr</code>)
with the function
<a href="api.php"><code>CNET_perror</code></a>
or you may construct your own error messages
using the error descriptions in
<code>*cnet_errname[]</code> or
<code>*cnet_errstr[]</code>.
</p>

<p>
It is also helpful to trace your protocols to see the exact ordering
and arguments of <i>cnet</i> function calls.
Tracing may be selected with the
<a href="options.php#option-t"><code>-t</code></a> command line option,
setting the trace node attribute to true for
all or individual nodes in the topology file or by selecting the trace
checkbox on either the default or specific node panels under
the windowing system.
Tracing will appear on the <code>trace</code> stream of <i>cnet</i>
(either the separate Tcl/Tk trace window or the shell's tty)
and shows each node's event handling
functions being invoked (and returned from) and, within each handler,
all function calls, their arguments and the function return values.
Any function arguments that are modified by the functions (arguments passed
by reference) are also shown after the function return values.
If any errors are detected by the functions themselves, these will be
reported within the trace.
See <a href="tracing.php">Tracing <i>cnet</i>'s execution</a>.
</p>

<p>
As a special case,
networks of only 2-nodes may request that all datalink frames traversing the
Physical Layer be drawn in a special window.
Drawing frames requires a small addition to the protocol's topology file,
and a special event handler to describe how the frames are to be drawn.
A careful choice of colours and frame (field) lengths can assist in the
debugging of Data Link layer protocols.
See <a href="drawframes.php">Drawing datalink frames in <i>cnet</i></a>.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="output">Where did my code's output go?</h1>

<p>
All output implicitly sent to C's standard output stream
with calls to <code>printf()</code> or <code>puts()</code>,
appears on each node's output window.
Clicking a node's icon on the simulation map will reveal this window,
and you can scroll back through a limited number of previous lines.
</p>

<p>
Each node's output printed via <code>printf()</code> or <code>puts()</code>
can also be copied to an individual file using the
<a href="options.php#option-o"><code>-o</code></a> option to <i>cnet</i>.
For example, if running a two node network with
</p>

<pre>    <span class="shell">shell&gt;&nbsp;</span><code>cnet <a href="options.php#option-o">-o</a> debug TOPOLOGY</code></pre>

<p>
all output will be copied (typically) to the files <i>debug.node0</i>
and <i>debug.node1</i>.
</p>

<p>
All output explicitly sent to the <code>stdout</code> or <code>stderr</code> streams,
requested with calls to <code>fprintf()</code> or <code>fputs()</code>,
appears on the invoking terminal/shell window (tty or pty).
Such output (merged output from all nodes)
can be captured using traditional output redirection in your shell.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="tricks">Are there any simple tricks that can help my understanding?</h1>

<p>
Many people get confused with <i>cnet</i>'s apparent ability to manage
multiple nodes simultaneously within a single process
(which is, in fact, one of its unique features).
In addition,
it can be initially confusing to understand how a single protocol can
act as both a sender and receiver simultaneously.
A simple trick to ease this confusion is
to only allow one node to transmit and the other to receive
(in a network of just 2 nodes).
As nodes have nodenumbers of 0, 1, 2, ...  adding the lines
</p>

<div class="code">
<b>if</b>(nodeinfo.nodenumber == 0)
    (<b>void</b>)CNET_enable_application(ALLNODES);
</div>

<p>
to your handler for <code>EV_REBOOT</code>,
typically <code>reboot_node()</code>,
will only permit node <code>#0</code> to generate messages for delivery.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="eventhandler">What is the <code>EVENT_HANDLER</code> function that appears in most examples?</h1>

<p>
<code>EVENT_HANDLER</code> is actually not a function provided by
<i>cnet</i> (or your operating system) but a C macro
defined in the &lt;cnet.h&gt; header file.
Its full definition is:
</p>

<div class="code">
#define EVENT_HANDLER(name)     \
        <b>void</b> name(CnetEvent ev, CnetTimerID timer, CnetData data)
</div>

<p>
This provides greater readability in protocol code,
which can simply declare its event handling functions with, for example: 
</p>

<div class="code">
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

<!-- ===================================================================== -->

<hr>

<h1 id="check">What is the <code>CHECK</code> function that appears in most examples?</h1>

<p>
CHECK is actually not a function provided by
<i>cnet</i> (or your operating system) but a C macro
defined in the &lt;cnet.h&gt; header file.
</p>

<p>
Most of <i>cnet's</i> library (builtin) functions return
<code>0</code> on success and something else,
typically <code>-1</code>, on failure.
In fact, if any of these
functions fail, it probably indicates a serious error in a protocol
(there are a few exceptions to this generalization, such as cancelling a
timer that has already expired).
Moreover, all functions will set the global error variable
<code>cnet_errno</code>
on failure and this may be used as an index into the globally accessible
array of error strings,
<code>cnet_errstr</code>.
This is similar to the use of
<code>errno</code> and <code>sys_errlist</code> in C.
</p>

<p>
By enveloping most calls to <i>cnet's</i>
library routines with <code>CHECK</code>,
we can get an accurate and immediate report on the location
(source file, function name, line number, and nodename) and type of each error.
These values are passed to <i>cnet's</i> function <code>CNET_exit</code>
which, if able, pops up a window highlighting the exact location of
the runtime error.
Looking at the definition of <code>CHECK</code> in &lt;cnet.h&gt;
may expose the "black magic":
</p>

<div class="code">
#define CHECK(call)  <b>do</b>{ <b>if</b>(call) != 0) \
                     CNET_exit(__FILE__, __func__, __LINE__);} <b>while</b>(false)
</div>

<p>
<code>CHECK</code> may not strictly belong in <i>cnet's</i> header file,
but it's such a useful macro, it saves everyone from re-inventing the wheel.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="drawframes">Can I see my protocol's datalink frames?</h1>

<p>
<i>cnet</i> presents a limited visualization of data
frames traversing any <code>LT_WAN</code> link.
Using just colours and lengths, it is possible to display both data and
acknowledgment frames, and the contents of some of their fields.
In combination, these features may be used to debug
implementations of Data Link Layer protocols.
</p>

<p>
You may view a <code>LT_WAN</code> link's frames by clicking the
right mouse button (control-click on Macintoshes) on the link.
<i>cnet</i> provides a simple default representation of frames
which may be overridden by defining an <code>EV_DRAWFRAME</code> event handler.
See also <a href="drawframes.php">Drawing data frames in <i>cnet</i></a>.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="timenow">How can I determine the current time?</h1>

<p>
Do not attempt to use your operating system's
<code>time()</code> or <code>gettimeofday()</code> functions.
</p>

<p>
In <i>cnet</i> each node's "system-time" is provided in
the global integer variable <code>nodeinfo.time_in_usec</code>,
which measures the time, in microseconds, since the node was last rebooted.
This value will (usually) have increased <i>between</i> calls to event
handlers, but its value will not change <i>during</i> the execution of an
event handler.
</p>

<p>
The current time of day, i.e. the "wall clock time" of each node,
is available via the structure <code>nodeinfo.time_of_day</code>, i.e. in
<code>nodeinfo.time_of_day.sec</code> and <code>nodeinfo.time_of_day.usec</code>.
The integer value in <code>nodeinfo.time_of_day.sec</code>
represents the number of seconds elapsed since 00:00:00 on January 1, 1970,
and can thus be used as an argument to standard operating system
functions such as <code>ctime()</code>.
</p>

<p>
Unless <i>cnet</i> is invoked with the
<a href="options.php#option-c"><code>-c</code></a> option,
the wall clock time of all nodes is initially different on each node.
If <a href="options.php#option-c"><code>-c</code></a> is specified,
the clocks in all nodes will initially be synchronized.
Protocols may be developed, which call
<a href="api_set_time_of_day.php"><code>CNET_set_time_of_day</code></a>
to synchronize the clocks.
</p>

<p>
<i>cnet</i> provides no support for timezones or daylight saving.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="printtime">How can I print a CnetTime value?</h1>

<p>
All times in <i>cnet</i> are measured in microseconds,
and the datatype <code>CnetTime</code> is a 64-bit integer - long enough to
hold about 580,000 years of simulation.
To print a value of <code>CnetTime</code>, we have two choices:
</p>

<pre>    <code>printf("time = %lld usecs\n", value);</code></pre>
or
<pre>    <code>printf("time = %s usecs\n", CNET_format64(value));</code></pre>

<p>
where the <a href="api_format64.php">CNET_format64</a> function formats
the value with commas included every 3 digits to increase the readability.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="timers">What are timers and <code>CnetTimerIDs</code>?</h1>

<p>
The event-driven nature of <i>cnet</i> means that your protocols cannot simply
'wait' for something to happen.  The <i>cnet</i> scheduler will inform your
protocols when important things need doing (messages to deliver, frames
to receive, etc).
In particular, your protocols cannot simply wait a
nominated period of time and then do something appropriate after that
time.
</p>

<p>
<b>YOUR PROTOCOLS SHOULD NOT CALL <code>sleep()</code></b>
or any similar functions.
Instead, <i>cnet</i> provides timers so that the scheduler may inform your
protocol when a nominated period of time has elapsed.
You may have an almost unlimited number timers quietly "ticking away" -
they are each uniquely identified by a <code>CnetTimerID</code>.
</p>

<p>
When you create a new timer you must indicate one of 10 timer events
<code>EV_TIMER0..EV_TIMER9</code>
and a period of time (in microseconds) in the future.
The function
<a href="api_start_timer.php"><code>CNET_start_timer</code></a>
will return to you a <code>CnetTimerID</code>
so that you may keep track of which timer has expired
when your timer event handler is invoked.
For example:
</p>

<div class="code">
CnetTimerID  saved_timer;

saved_timer = CNET_start_timer(EV_TIMER1, (CnetTime)1000000, 0);
</div>

<p>
will cause the event handler for <code>EV_TIMER1</code> to be called in 1 second.
The value of <code>saved_timer</code> will be passed as the second parameter to the
handler so that you can see which timer expired. You can have as many
outstanding timers on the <code>EV_TIMER1</code> <i>queue</i> as you want.
<b>PLEASE NOTE:</b> there are not only 10 timers available -
however, each timer must be tagged with one of the 10 available timer events.
</p>

<p>
If you decide that you no longer want to be informed when a timer
expires, you should call
<a href="api_stop_timer.php"><code>CNET_stop_timer</code></a>
with the <code>CnetTimerID</code> in which you are no longer interested.
For example,
</p>

<pre>    <code>(<b>void</b>)CNET_stop_timer(saved_timer);</code></pre>

<p>
If the <i>cnet</i> scheduler invokes your timer handler,
then you do not need to cancel the corresponding timer
(it will be done for you).
However, if you wish a timer event to be raised periodically,
then you'll need to start a <i>new</i> timer in the handler of an
expiring timer,
i.e. timers only expire once, not repeatedly.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="timers10">Why does <i>cnet</i> only provide 10 timers?</h1>

<p>
<i>cnet</i> provide 10 distinct timer <i>queues</i> -
not just 10 timers.
Each timer queue may have an unlimited number of timers "ticking-away" on it
and,
when each expires,
the event handler for the associated queue will be invoked.
</p>

<p>
When writing protocols in multiple layers,
it's a nice separation of concerns to employ different timers in each layer.
For example, in a Data Link Layer protocol,
we could use <code>EV_TIMER1</code> for a frame retransmission timer,
and <code>EV_TIMER2</code> for a piggyback timer.
At the same time, the Network layer may use <code>EV_TIMER3</code> to flush any
queued packets if it uses a leaky bucket for congestion control,
and <code>EV_TIMER4</code> to periodically exchange routing table
information with neighbours.
</p>

<p>
Employing a distinct timer queue for each activity allows us to use
a separate handler to manage the requirements of each activity,
and to "hide" the handler in the protocol layer or source file of concern.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="timerdata">What is the third parameter to <code>CNET_start_timer</code> ever used for?</h1>

<p>
Any value passed as
the third parameter to <code>CNET_start_timer</code> is remembered,
internally, along with the timer.
When the timer expires, this saved value is passed as the third parameter
to the handler for the timer's event.
This parameter is of type <code>CnetData</code> (a long integer in C)
which allows it to store integral values or a pointer to a variable or
dynamically allocated data structure.
Typical uses for this parameter are to pass a sequence number used in a
protocol,
or perhaps a pointer to a list or tree structure,
to the timer event's handler.
</p>

<p>
If the parameter is used to store a pointer,
care must be taken to ensure that the pointer is still valid at the time
the timer's event handler is called.
In particular,
the parameter should never be used to store the address of any variable or
structure on C's runtime stack.
</p>

<p>
It is reasonable to pass a pointer to dynamically allocated storage
to <code>CNET_start_timer</code> (i.e. allocated with <code>malloc</code>),
and then have the timer's event handler deallocate this storage
(i.e.  deallocated with <code>free</code>).
</p>

<p>
If you need to call <code>CNET_stop_timer</code> before a timer expires,
take care to first deallocate any dynamic storage associated with the timer
as a <code>CnetData</code> value.
You can "recover" the <code>CnetData</code> value
by calling the function <code>CNET_timer_data</code>.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="ownevents">Can I add my own <code>CnetEvent</code> events?</h1>

<p>
No, not unless you wish to change and recompile the source code of <i>cnet</i>
itself.
However, there are a few "spare" standard <code>EV_TIMER</code> events that
could be re-used or "renamed" to suit your purpose.
For example,
if you'd like a new event for the Data Link Layer to signal the Network
Layer, you could (ab)use the C-preprocessor and say:
</p>

<div class="code">
#define  EV_DLL_2_NL                 EV_TIMER8
#define  raise_dll_2_nl_event(data)  CNET_start_timer(EV_DLL_2_NL, 1, data)
</div>

<p>
and then simply call <code>raise_dll_2_nl_event()</code>
with an instance of <code>CnetData</code> when you want to raise the pseudo-event.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="spelling">What is the meaning of "spelling mistake on line 83 of protocol.c"?</h1>

<p>
There is a spelling mistake on line 83 of <code>protocol.c</code>
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="signals">What is the meaning of "caught signal number XX while (last) handling Perth.EV_APPLICATIONREADY"?</h1>

<p>
Old tricks for young players.
</p>

<p>
Fatal error messages of this form generally indicate a major problem
with your protocols.
The number (typically 2, 10 or 11) refers to an
operating system signal number intercepted by <i>cnet</i>
(see <code>/usr/include/signal.h</code>).
For example,
signal number 2 will be caught and reported by <i>cnet</i> if you
<i>interrupt</i> <i>cnet</i> from the shell level
(<code>signal 2 = SIGINT</code>).
The other common signals,
10 and 11, reveal significant flaws in the implementation of your protocols.
</p>

<p>
Signal 10 (<code>SIGBUS</code>, a bus error)
occurs when the CPU attempts to execute
an instruction not on an instruction boundary
(on many architectures,
you've requested to execute an instruction whose address is not a
multiple of 4).
This error will generally occur when your programming
corrupts your program's stack and,
in particular, you corrupt the
return address of the currently executing function.
When the current
function attempts to return (to a now incorrect address) and then fetches
an instruction whose address is invalid, signal 10 will result.
</p>

<p>
Signal 11 (<code>SIGSEGV</code>, segmentation violation)
occurs when your program
attempts to address memory that has not been mapped into your address
space.  Typically, by accessing a pointer that has not been correctly
initialized or has been modified/overwritten incorrectly, that pointer
will point to memory that you do not "own",
it being owned by either
the operating system or another (person's) process.
When attempting to
access outside of your memory segment, you will get a segmentation
violation.
Operating systems that do not provide memory protection
(segmentation), for example DOS, will not report this error as the
(single) process on those operating systems "own" all of the address
space.  Your program there will still (maybe!) exhibit errors but these
may not be reported to you.
The operating system is in fact doing you a favour.
</p>

<p>
Signals 10 and 11 spell disaster for your programs - there is obviously
something seriously wrong with your program if they happen.  Both forms
of error most frequently occur when you are incorrectly managing
pointers and/or dynamic memory.
</p>

<p>
Such problems are very difficult to diagnose - your first action should
be to check your programming logic.  By their nature, errors which
often *cause* signals 10 and 11 to be reported, do not necessarily
raise the signal immediately.  You may do the wrong thing many
instructions or even seconds before the signal is reported.  For this
reason, the best <i>cnet</i> can do is state which event handler it was
executing (or it was most recently executing) when the signal occurs.
This <i>does not necessarily</i> indicate that your programming error is in
that event handler though experience shows that this is likely.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="nomore">What is the meaning of "warning: no more events are scheduled"?</h1>

<p>
This message means that <i>cnet</i> has nothing more to do (for your
simulation) -
all Application Layers are disabled and so no new messages will be generated,
all frames have been delivered (or have been lost) via the Physical Layer, and
all timers have expired or been cancelled.
<i>cnet</i> has nothing further to do until
you click a debug button,
provide some keyboard input to one of the nodes, or
terminate <i>cnet</i>.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="efficiency">What is the meaning of the statistic "Efficiency (bytes AL) / (bytes PL)"?</h1>

<p>
Here, AL stands for Application Layer, and PL for Physical Layer.
This statistic divides the total number of bytes generated by all
Application Layers, by the total number of bytes traversing the Physical Layer.
Our protocols will require headers for their frames and packets,
re-transmit data frames,
and generate acknowledgments and other control packets,
and so this ratio is expected to be less than 100%
(the price we pay for reliable message delivery).
The statistic is not updated until the first message is successfully
written "up" to a node's Application Layer.
</p>

<p>
Under some circumstances this statistic appears to be inaccurate,
and may not correspond exactly with your own calculations.
This occurs when some bytes still "remain" in the Physical Layer
and have yet to be delivered.
Also, if your protocols perform compression of their payloads,
then it is possible for this statistic to exceed 100%.
</p>

<p>
Keep in mind that this ratio is not the only desirable measure of
protocol efficiency (but retains this name for historical reasons).
Protocols may also strive to minimize average delivery time,
or the total (monetary) cost of delivering frames.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="notready">What is the meaning of the error
	"ER_NOTREADY - Function called when service not available"?</h1>
<p>
This error arises in two common circumstances,
usually when using functions to communicate with the Application or
Physical layers:
</p>

<ol>
<li>
<p> When a node is rebooting
(its <code>EV_REBOOT</code> event handler is executing)
data frames may not be written to the Physical Layer -
it too needs to be rebooted before it can accept data.
To overcome this limitation, set a timer for a very short interval,
say just <code>1usec</code>,
and write to the Physical Layer in the timer's handler.
</p>
</li>

<li>
<p> <i>cnet</i> employs an event-driven paradigm to inform your protocol
code that the Application and Physical layers require your attention.
You may not <i>poll</i> either layer to see if new messages or data frames
are available.
</p>
</li>

<li>
<p>
Attempts to call <code>CNET_read_application</code> when <i>not</i> executing
an <code>EV_APPLICATIONREADY</code> handler, or
attempts to call <code>CNET_read_physical</code> when <i>not</i> executing
an <code>EV_PHYSICALREADY</code> handler,
will result in the functions failing and setting <code>cnet_errno</code> to
<code>ER_NOTREADY</code>.
</p>
</li>
</ol>

<!-- ===================================================================== -->

<hr>

<h1 id="toobusy">What is the meaning of the error
	"ER_TOOBUSY - Function is too busy/congested to handle request"?</h1>
<p>
The function <code>CNET_write_physical()</code> will 'trap' the situation
when a <i>large</i> number of frames have been written to the Physical Layer,
and when the receiving node has not read any of them off.
This trap is currently set at the large value of 1000,
which surely indicates an error in a protocol.
</p>

<p>
Your protocol may have some unbounded loop,
or a very short timeout-and-retransmission sequence,
resulting in many calls to <code>CNET_write_physical()</code> at the sender,
before any <code>EV_PHYSICALREADY</code> events are handled at the receiver.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="speedup">How can I speed up my simulations?</h1>

<p>
Firstly, it's important to keep some perspective.
<i>cnet</i> runs within a single process on a single processor.
If you dramatically increase the number of simulated nodes,
expect a corresponding decrease in simulation speed.
Even though the nodes appear to execute at the same time,
their execution shares the single processor.
However, all is not lost:
</p>

<p>
<ol>
<li> Don't print out volumes of debug information to each node's output
window. The printing of large amounts of text and the scrolling of these
windows obviously slows down <i>cnet</i>.
Just print out bad news, not lots of good news.
<p>
</li>

<li> Disable all printing, altogether -
invoke <i>cnet</i> with the
<a href="options.php#option-q"><code>-q</code></a> option
to keep the windows quiet.
<p>
</li>

<li> <i>cnet</i> simulates multiple, independent, nodes by swapping their
data segments (their variables) in and out of memory
before each node's event handler is called.
You can speed up your simulation (considerably) by reducing the space
(number of bytes) required for each node's variables.
Instead of declaring, say, a large buffer of 64KB as a global variable,
declare a global <i>pointer</i> to such a buffer (probably requiring only
4 bytes) and in your <code>reboot_node()</code> handler,
allocate the 64KB with a call to <code>malloc()</code>.
Now, each time the node is scheduled, only the 4 byte pointer variable
will be swapped in and out (and data allocated in the heap is not swapped).
<p>
</li>

<li>
<p> If your protocol works "for a few minutes" before crashing,
change a few attributes to speed up the <i>cnet</i> simulation.
For example:
</p>

<div class="code">
messagerate      = 3ms
propagationdelay = 100usec
</div>

<p>
should enable your protocol to work "for a few seconds" before it crashes.
Hmmmm, much better.
</p>
</li>

<li> If you'd rather not wait a full second for <i>cnet</i>
to complete one second of network activity, run with the
<a href="options.php#option-T"><code>-T</code></a> option
to force events to be scheduled
immediately (<code>nodeinfo.time_in_usec</code> is updated as you'd hope).
<p>
</li>

<li>
<p> You don't always need to work with <i>cnet</i>'s graphical display;
it'll run "within" an ASCII terminal window without its display if you
invoke cnet with its
<a href="options.php#option-W"><code>-W</code></a> option.
You can also use the
<a href="options.php#option-o"><code>-o</code></a> option
or explicitly send output to <code>stdout</code>,
<code>stderr</code> or to a file rather than
having it all appear in each node's <code>stdout</code> window.
</p>

<p>
After a while, the gimmick of the "network map" should wear off
and you should only be debugging bad news,
by examining <code>cnet_errno</code> and <code>CNET_perror()</code>.
</p>
</li>
</ol>

<!-- ===================================================================== -->

<hr>

<h1 id="plotting">How can I collate <i>cnet</i> statistics for plotting?</h1>

<p>
<i>cnet</i> centrally collates statistics on behalf of all
nodes, and displays these on the 'Statistics' popup window or at the
end of a simulation run if <i>cnet</i> is invoked with the
<a href="options.php#option-s"><code>-s</code></a> option
(or the
<a href="options.php#option-z"><code>-z</code></a> option
to also get zero-valued statistics).
</p>

<p>
We can also print statistics more frequently (periodically) with the correct
choice of
<a href="options.php">command line options</a>.
These are:
</p>

<table style="margin-left: 2em;">
<tr>
    <td style="width: 15%;">-W</td>
    <td style="width: 85%;">no need for the windowing interface</td>
</tr>
<tr>
    <td>-T</td>
    <td>run the simulation as fast as possible</td>
</tr>
<tr>
    <td>-e 5m</td>
    <td>execute for 5 minutes of simulation time</td>
</tr>
<tr>
    <td>-s</td>
    <td>yes, we want statistics</td>
</tr>
<tr>
    <td>-f 10s</td>
    <td>print statistics with a frequency (period) of 10 seconds</td>
</tr>
</table>

<p>
This will produce volumes of output to <i>cnet</i>'s
standard output stream,
so we need to both capture this and probably filter only what we need.
So, to capture the Efficiency measure (bytes AL/PL) every second
(in the hope that it improves), we issue:
</p>

<div class="code" style="width: 43em;">
#!/bin/sh
#
cnet -W -T -e 5m -s -f 1s TOPOLOGYFILE   | \
grep Efficiency                          | \
cut -d: -f 2                             | \
cat -n              &gt; effic.statistics
</div>

<p>
The last line takes its input (a column of 300 efficiencies) and places a
line number at the beginning of each line.
This is fine if we really want statistics every single second, but slowly
adapting protocols may take several minutes to reach their optimum.
We could develop a shellscript which accepts arguments
indicating the topology file and the frequency of collection:
</p>

<div class="code" style="width: 43em;">
#!/bin/sh
#
TOPFILE=$1
FREQ=$2 
#
cnet -W -T -e 5m -s -f $FREQ $TOPFILE     | \
grep Efficiency                           | \
cut -d: -f 2                              | \
awk '{ printf("%d %s\n", n+=freq, $0); }' freq=$FREQ  &gt;  effic.statistics
</div>

<p>
Of course,
other shellscript arguments could indicate the required
statistic, resultfile, etc.
</p>

<!-- ===================================================================== -->

<hr>

<h1 id="ownstats">How can each node collate its own statistics?</h1>

<p>
Each node can easily collate statistics about its own performance
in its own variables (in its C protocol source code).
Each node can then use a timer event to periodically report its statistics
(either accumulated values, or instantaneous values that are then cleared
by the timer event handling code).
If the statistics are printed in a consistent format,
to C's <code>stdout</code> stream,
then external shellscripts (as described above) may be written to  
further collate or plot information.
</p>

<p>
A node may set a handler for the <code>EV_SHUTDOWN</code> event,
and then print its statistics when the node is politely shutdown,
or when the whole simulation finishes.
</p>

<p>
Similarly, a node may set a handler for the <code>EV_PERIODIC</code> event,
and then print its statistics whenever its handfler is called.
The frequency with which the <code>EV_PERIODIC</code> event occurs
may be requested with, for example:
</p>

<pre>    <span class="shell">shell&gt;&nbsp;</span><code>cnet <a href="options.php#option-f">-f</a> 10secs TOPOLOGY</code></pre>

<!-- ===================================================================== -->

<hr>

<h1 id="sharedstats">How can I collate my own global statistics?</h1>

<p>
Normally <i>cnet</i> provides the appearance that all nodes have independent
memories (variables)
so that all inter-node communication must be made via the Physical Layer.
However, this feature can make the collation of global statistics difficult
and, on such occasions, having access to a shared block of memory,
say an array of integers indexed via each node's nodenumber,
would be beneficial.
</p>

<p>
Consider the need to determine the number of re-transmissions required by
each node executing a certain protocol - not a statistic that <i>cnet</i>
can manage because it doesn't understand <i>your</i> code,
and doesn't know what a <i>re</i>-transmission is.
Let's assume that we have at most 100 nodes.
</p>

<p>
In each node's <code>EV_REBOOT</code> handler, we call
<a href="api_shmem.php">CNET_shmem</a>
to request a shared memory region to store our re-transmission counts:
</p>

<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> *retransmissions;

<b>void</b> reboot_node(CnetEvent ev, CnetTimerID timer, CnetData data)
{
    .....
    retransmissions = (<b>int</b> *)CNET_shmem(100 * <b>sizeof</b>(<b>int</b>));
    .....
}
</div>

<p>
Then, when each node makes a re-transmission we can simply increment the
relevent count in this shared array of integers:
</p>

<div class="code">
<i>//  I have just re-transmitted a DATA frame</i>
++retransmissions[ nodeinfo.nodenumber ];
.....
</div>

<p>
All other nodes can instantly see the number of re-transmissions made by
all other nodes, and any particular node could, say, print out all values when
its <code>EV_SHUTDOWN</code> handler is called.
The provision of <code>CNET_shmem()</code> is <i>not</i> intended to provide a
covert communication channel between nodes.
</p>

<?php require_once("cnet-footer.php"); ?>
