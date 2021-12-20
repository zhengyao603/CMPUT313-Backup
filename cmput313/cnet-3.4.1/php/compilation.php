<?php require_once("cnet-header.php"); ?>

<h1 id="compilation">Compilation strings</h1>

<p>
Because <i>cnet</i> must dynamically link compiled versions of protocols
at run-time,
<i>cnet</i> performs all necessary compilation and linking.
You neither compile nor link protocols yourself,
nor use <i>make(3)</i> to do it for you.
Invoking <i>cnet</i> with a valid
<a href="topology.php">topology file</a>
will perform all necessary compilation and linking before commencing
the simulation.
<i>cnet</i>
performs the rudimentary actions of
<i>make(3)</i>,
compiling and linking files if the required target does not exist or is
out-of-date with respect to sourcefiles.
</p>

<p>
Strings are used to declare the location (filenames) of the source and
shared object codes for the Application and "Central" layers
used in each simulation.
These strings may be provided on the command line,
via the
<a href="options.php#option-A">-A</a>,
<a href="options.php#option-C">-C</a>, and
<a href="options.php#option-J">-J</a> command-line options.
The compilation string to compile the "Central" layers may also be specified
with the <code>compile</code> node attribute in the topology file.
</p>

<p>
In their simplest form, compilation strings may present just a single
C sourcefile name, such as <code>"protocol.c"</code>.
If necessary,
<i>cnet</i>,
will compile the file <code>protocol.c</code> into the object file
<code>protocol.o</code> and then link this file to form the final shared object
<code>protocol.cnet</code>.
This final shared object file will then be used to provide the
code for each node's relevant layer(s).
</p>

<p>
In its more complex form,
a compilation string may also include compilation switches,
a number of sourcefile names, and linker switches.
For example, the compilation string
</p>

<pre>    <code>"-DCOLLECTSTATS ftp.c tables.c -lm"</code></pre>

<p>
includes an embedded (actually C preprocessor) switch which is passed onto
the compilation process,
two sourcefile names and a linker switch
(in this case to link with the mathematics library).
Each source file is compiled (if necessary) to create its object file,
and all object files are then linked together to form a single shared object.
The shared object's name is derived from the first sourcefile found,
in this case it will be <i>ftp.cnet</i>.
</p>

<p>
The embedded switches <code>-l</code> and <code>-L</code>,
and any filenames ending in <code>.o</code> or <code>.a</code>,
are recognized as (assumed to be) arguments for the linker.
All other switches are assumed to be C-preprocessor and C-compiler switches.
</p>

<hr>

<p></p>
<h1 id="extension">Extension modules</h1>

<p>
By default, <i>cnet</i> goes to great efforts to ensure that each node's
execution appears to be occurring in isolation - that each node appears as
an independent computer, running its own operating system, and accessing its
own memory.
Each node's data segments (variables in protocols' code) are swapped in and
out of their true locations as each node's events are scheduled for execution.
This has the desirable effect that nodes can only communicate through
their Physical Layer communications, and cannot communicate by leaving
information in their variables.
This is fairly novel, and makes protocol writing and execution more realistic.
</p>

<p>
However, the swapping of each node's data segments tens of thousands
of times every second is expensive, and protocols requiring large segments
(typically many, or large, global or static variables) execute more slowly.
In addition, there are some occasions when nodes sharing <i>some</i>
memory can be beneficial -
such as the collation of a simulation's global statistics,
user-specified <a href="wlans.php#setmodel">WLAN propagation models</a>,
or the sharing of topological information such as the locations of
buildings on a simulation map.
</p>

<p>
<i>Extension modules</i> enable simulations to add code and variables to
<i>cnet</i>'s "core", without requiring that <i>cnet</i> itself be
recompiled.
The code and data are accessible to all nodes and, in particular,
modules' data is not swapped in and out between events.
</p>

<p>
Extension modules are specified by providing one or more instances
of the <a href="options.php#option-x">-x</a> command-line option.
Each instance expects a module name (without any filename extension),
or a <a href="compilation.php">compilation string</a> providing the code
of the module.
If specified just by name,
the <code>CNETPATH</code>  and <code>CNETFILEEXT</code>
<a href="environment.php">environment variables</a> are used to locate
standard modules from a standard location.
Otherwise the compilation string is used to compile and link the module.
</p>

<p>
The following code shows a (poorly written, with no error checking) module
enabling nodes to share a single memory segment:
</p>

<div class="code" style="width: 34em;">
#include &lt;cnet.h&gt;
#include &lt;stdlib.h&gt;

<b>void</b> *my_shmem(size_t length)
{
    <b>static void</b> *shared  = NULL;

    <b>if</b>(shared == NULL)
        shared = calloc((<b>unsigned</b>)1, (size_t)length);
    <b>return</b> shared;
}
</div>

<p>
This source code may now be employed as an extension module with the command:
</p>

<pre>   <span class="shell">shell&gt;&nbsp;</span><code>cnet -x my_shmem.c -N TOPOLOGY</code></pre>

<p>
and each node's protocol code may typically execute:
</p>

<div class="code" style="width: 34em;">
#include &lt;cnet.h&gt;

<b>extern void</b> *my_shmem(size_t length);

<b>int</b> *world_statistics = NULL;
<b>int</b>  my_statistic     = 0;

    ...
    world_statistics = my_shmem(NNODES * <b>sizeof</b>(<b>int</b>));
    ...
    ...
    world_statistics[nodeinfo.nodenumber] += my_statistic;
</div>

<p>
The memory allocated by <code>my_shmem</code> will always be accessible by
each node, and each node may view all other nodes' statistics by accessing
<code>world_statistics</code>.
If the role of the <code>my_shmem</code> extension module
is considered important enough,
it may be made a "permanent" addition by moving the file
<code>my_shmem.cnet</code> to a directory searched via <code>CNETPATH</code>.

<?php require_once("cnet-footer.php"); ?>
