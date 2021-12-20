<?php require_once("cnet-header.php"); ?>

<h1>Command-line options</h1>

<p>
<i>cnet</i>
supports a number of command-line options which should be presented
before the name of the topology file or a request for a random topology.
If the name of the topology file is "-",
then the topology will be read from standard input.
</p>

<p>
There are three ways to invoke <i>cnet</i>,
where items in [square-brackets] are optional:
</p>

<pre>   <span class="shell">shell&gt; </span><code>cnet [command-line-options] TOPOLOGYFILE [args-to-reboot-function]</code></pre>
<pre>   <span class="shell">shell&gt; </span><code>cnet [command-line-options] -            [args-to-reboot-function]</code></pre>
<pre>   <span class="shell">shell&gt; </span><code>cnet [command-line-options] -r NNODES    [args-to-reboot-function]</code></pre>

<p></p>

<table class="thin">
<tr>
    <th class="thin">option</th>
    <th class="thin">description</th>
</tr>

<tr>
    <td class="option0" id="option-A"><b>-A string</b></td>
    <td class="option0">
    Specify a <a href="compilation.php">compilation string</a> which declares
    a new application layer to be used.  If <code>-A</code> is not provided, a
    default (internal) application layer is used.  The eventual application
    layer is used as the source and sink of all messages.
    </td>
</tr>

<tr>
    <td class="option1" id="option-B"><b>-B</b></td>
    <td class="option1">
    By default, each link's NIC will buffer(queue) all frames/packets until
    they can be transmitted over the link.  Specifying <code>-B</code>
    <i>disables</i> this buffering,
    and any attempt to write to a link while it is currently
    transmitting will result in the attempt failing by returning <code>-1</code>
    and setting <code>cnet_errno</code> to <code>ER_TOOBUSY</code>.
    </td>
</tr>

<tr>
    <td class="option0" id="option-c"><b>-c</b></td>
    <td class="option0">
    Initially the value of <code>nodeinfo.time_of_day</code> in each node is
    different (and protocols may be developed to synchronize the clocks).
    If <code>-c</code> is specified, all clocks are initially synchronized.
    </td>
</tr>

<tr>
    <td class="option1" id="option-C"><b>-C string</b></td>
    <td class="option1">
    Specify a <a href="compilation.php">compilation string</a>
    which declares each node's "internal" layers to be used.
    Any value provided by <code>-C</code> becomes the default, unless
    over-ridden in the topology file.  If neither is provided,
    the string <i>"protocol.c"</i> is assumed.
    </td>
</tr>

<tr>
    <td class="option0" id="option-d"><b>-d</b></td>
    <td class="option0">
    Print diagnostic information while <i>cnet</i> is running
    (to <code>stderr</code>).
    </td>
</tr>

<tr>
    <td class="option1" id="option-D"><b>-Dcpptoken</b></td>
    <td class="option1">
    Define a C-preprocessor token that is passed to the preprocessor
    when the topology file is parsed, and passed to the C compiler
    whenever C protocol files are compiled.
    </td>
</tr>

<tr>
    <td class="option0" id="option-e"><b>-e period</b></td>
    <td class="option0">
    Request that the simulation only run for the indicated period.
    Representative periods are 100usec, 200ms 3s, 4min, 5hr, or 6000events.
    </td>
</tr>

<tr>
    <td class="option1" id="option-E"><b>-E</b></td>
    <td class="option1">
    Normally, corruption errors on links are not reported by the
    Physical Layer and must be detected by the receiver.
    If <code>-E</code> is specified,
    function <code>CNET_read_physical</code> will detect and report
    corruption errors by returning <code>-1</code> and setting
    <code>cnet_errno</code> to <code>ER_CORRUPTFRAME</code>.
    </td>
</tr>

<tr>
    <td class="option0" id="option-f"><b>-f period</b></td>
    <td class="option0">
    Set a global frequency (period) with which a few things occur.
    If <a href="#option-d">-d</a> is provided,
    some diagnostics are periodically written to stderr.
    If <a href="#option-i">-i</a> or <a href="#option-s">-s</a> is provided,
    statistical summaries are periodically written to stdout.
    If any node sets an event handler for <code>EV_PERIODIC</code>,
    the handler is invoked periodically.
    Representative periods are 100usec, 200ms 3s, 4min, 5hr, or 6000events.
    </td>
</tr>

<tr>
    <td class="option1" id="option-F"><b>-F filenm</b></td>
    <td class="option1">
    If <i>cnet</i> has been compiled for Tcl/Tk,
    the indicated file will be sourced by the Tcl interpreter.
    If the file cannot be found directly,
    <code>CNETPATH</code> will be searched to locate the file.
    </td>
</tr>

<tr>
    <td class="option0" id="option-g"><b>-g</b></td>
    <td class="option0">
    Go. Commence execution as soon as the main window appears
    (under Tcl/Tk); implied by <a href="#option-W">-W</a>.
    </td>
</tr>

<tr>
    <td class="option1" id="option-G"><b>-G</b></td>
    <td class="option1">
    Equivalent to -WTgqz.
    </td>
</tr>

<tr>
    <td class="option0" id="option-i"><b>-i</b></td>
    <td class="option0">
    Report instantaneous statistics to standard output.
    The frequency of reporting must also be set with the 
    <a href="#option-f">-f</a> option.
    </td>
</tr>

<tr>
    <td class="option1" id="option-I"><b>-Idirectory</b></td>
    <td class="option1">
    Provide a directory name that is passed to the C compiler
    whenever C protocol files are compiled.
    </td>
</tr>

<tr>
    <td class="option0" id="option-J"><b>-J Cfiles</b></td>
    <td class="option0">
    Just compile the indicated C files into object files, so that
    libraries (black-boxes) of <i>cnet</i> code may be distributed.
    The value of <code>files</code> may actually be any valid
     <a href="compilation.php">compilation string</a>.
    </td>
</tr>

<tr>
    <td class="option1" id="option-m"><b>-m minutes</b></td>
    <td class="option1">
    To prevent (very) badly written simulations from locking an X-window
    server, a 5 minute time limit is silently imposed on <i>cnet</i> execution.
    The <code>-m</code> option overrides this limit.
    </td>
</tr>

<tr>
    <td class="option0" id="option-n"><b>-n</b></td>
    <td class="option0">
    Simply parse the topology file, compile and link all necessary
    C source files, and then exit.
    </td>
</tr>

<tr>
    <td class="option1" id="option-N"><b>-N</b></td>
    <td class="option1">
    Provide the number of nodes in the network in the C variable
    <code>NNODES</code>.  Surprisingly, the default is that each node does not
    know how many nodes the network contains (<code>NNODES&nbsp;=&nbsp;0</code>).
    </td>
</tr>

<tr>
    <td class="option0" id="option-o"><b>-o filename</b></td>
    <td class="option0">
    Mirror, to the indicated file, the output of each node's calls to
    <code>printf(), puts()</code> and <code>putchar()</code>.
    <br>
    The following formatting substitutions may be requested:

    <p></p>

    <table style="width: 100%;">
    <tr><td style="width: 10%;">%a</td><td>node's address as an integer</td></tr>
    <tr><td>%d</td><td>node's number</td></tr>
    <tr><td>%I</td>
	<td>node's address in IPv4 dotted-decimal notation</td></tr>
    <tr><td>%n</td><td>node's name</td></tr>
    </table>
    </td>
</tr>

<tr>
    <td class="option1" id="option-O"><b>-O</b></td>
    <td class="option1">
    Open all node windows on startup (unless overridden by the
    <code>winopen</code> attribute).
    </td>
</tr>

<tr>
    <td class="option0" id="option-p"><b>-p</b></td>
    <td class="option0">
    After building and checking the network topology,
    simply print the topology to <code>stdout</code> and exit.
    </td>
</tr>

<tr>
    <td class="option1" id="option-q"><b>-q</b></td>
    <td class="option1">
    Execute quietly (and more quickly) - all output requested with
    <code>printf(), puts()</code> and <code>putchar()</code> will not appear in
    the output windows.  All output produced during an <code>EV_DEBUG?</code>
    event (a button press) will still appear, as will all output "mirrored"
    in logging files.
    </td>
</tr>

<tr>
    <td class="option0" id="option-Q"><b>-Q</b></td>
    <td class="option0">
    Ignore Application Layer message sequencing errors.
    </td>
</tr>

<tr>
    <td class="option1" id="option-r"><b>-r nnodes</b></td>
    <td class="option1">
    Request that a random network be generated, consisting of <i>nnodes</i>.
    The topology is guaranteed to be connected.  The <code>-r</code> option
    may be used instead of providing a topology file, and must be
    the last option before the appearance of each <i>node's</i> optional
    <a href="eventdriven.php#argv">reboot arguments</a>.
    </td>
</tr>

<tr>
    <td class="option0" style="white-space: nowrap;" id="option-R"><b>-R function_name</b></td>
    <td class="option0">
    Use <code>function_name()</code> as the function to first invoke when
    rebooting each node.  By default, the function <code>reboot_node()</code>
    will be invoked.
    </td>
</tr>

<tr>
    <td class="option1" id="option-s"><b>-s</b></td>
    <td class="option1">
    Print cumulative statistics to standard output
    just before <i>cnet</i> exits.
    If the <a href="#option-f">-f</a> option is also provided, then the
    cumulative statistics will also be printed with the indicated frequency.
    See also the <a href="#option-z">-z</a> option.
    </td>
</tr>

<tr>
    <td class="option0" id="option-S"><b>-S seed</b></td>
    <td class="option0">
    Provide the seed for random number generation
    (for message generation and frame corruption and loss).
    Specifying <code>-s</code> enables a simulation to be replayed.
    </td>
</tr>

<tr>
    <td class="option1" id="option-t"><b>-t</b></td>
    <td class="option1">
    Trace all events delivered to each network node.  An annotation of all
    <i>cnet</i> function calls, arguments and return and <code>cnet_errno</code>
    values is reported via <i>cnet</i>'s tracing stream.
    Any output requested with
    <a href="api_trace.php"><code>CNET_trace</code></a> will also appear.
    </td>
</tr>

<tr>
    <td class="option0" id="option-T"><b>-T</b></td>
    <td class="option0">
    By default, <i>cnet</i> runs in "wall-clock" time, that is, the simulation
    performs one second of network-work in one second of "wall-clock" time.
    This works well for up to about 20 nodes beyond which <i>cnet</i> "gets
    behind".  Using <code>-T</code> forces <i>cnet</i> to ignore the "wall-clock"
    time and to execute as a true discrete-event simulator.
    </td>
</tr>

<tr>
    <td class="option1" id="option-u"><b>-u period</b></td>
    <td class="option1">
    Specify the period (frequency) of updates to the statistics
    window under the Tcl/Tk GUI.
    Representative periods are 100usec, 200ms 3s, 4min, 5hr, or 6000events.
    </td>
</tr>

<tr>
    <td class="option0" id="option-U"><b>-Ucpptoken</b></td>
    <td class="option0">
    "Undefine" a C-preprocessor token that is passed to the preprocessor
    when the topology file is parsed, and passed to the C compiler
    whenever C protocol files are compiled.
    </td>
</tr>

<tr>
    <td class="option1" id="option-v"><b>-v</b></td>
    <td class="option1">
    Be very verbose about <i>cnet</i>'s actions (to <code>stderr</code>).
    </td>
</tr>

<tr>
    <td class="option0" id="option-W"><b>-W</b></td>
    <td class="option0">
    Disable GUI windowing support with Tcl/Tk
    (the default when executing on ASCII terminals!).
    </td>
</tr>

<tr>
    <td class="option1" id="option-x"><b>-x module</b></td>
    <td class="option1">
    Provide the name of an
    <a href="compilation.php#extension"><i>extension module</i></a>
    whose code and data will be shared amongst all nodes.
    The module is first sought by name using
    <a href="environment.php">environment variables</a>
    <code>CNETPATH</code>  and <code>CNETFILEEXT</code>.
    If not found, the string is assumed to be
    a <a href="compilation.php">compilation string</a>
    providing the code for the extension module.
    Option <code>-x</code> may be provided multiple times.
    </td>
</tr>

<tr>
    <td class="option0" id="option-z"><b>-z</b></td>
    <td class="option0">
    Display statistics and event summaries even if they are zero.
    See also the <a href="#option-i">-i</a>
    and <a href="#option-s">-s</a> options.
    </td>
</tr>
</table>

<?php require_once("cnet-footer.php"); ?>
