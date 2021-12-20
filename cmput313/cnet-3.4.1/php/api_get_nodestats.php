<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_get_nodestats - obtain runtime statistics about the current node
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>typedef struct</b> {
    <b>int64_t</b>     nevents;
    <b>int64_t</b>     nerrors;

    <b>int64_t</b>     msgs_generated;
    <b>int64_t</b>     bytes_generated;

    <b>int64_t</b>     msgs_received;
    <b>int64_t</b>     bytes_received;
} CnetNodeStats;

<b>int</b> CNET_get_nodestats(CnetNodeStats *stats);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_get_nodestats()</code> provides the current node with statistics
about its own execution.
</p>

<p>
A node's statistics are cleared when the node reboots.
The "sum" of each node's statistics form the global node statistics which
are reported on the GUI and may be requested with the <code>-s</code>
command-line option.
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
    <dd><code>stats</code> was a NULL pointer.
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_get_linkstats.php">CNET_get_linkstats</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
