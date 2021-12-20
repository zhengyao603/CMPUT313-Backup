<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_get_linkstats - obtain runtime statistics about one of current
node's links
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>typedef struct</b> {
    <b>int64_t</b>     tx_frames;
    <b>int64_t</b>     tx_bytes;
    <b>int64_t</b>     tx_cost;

    <b>int64_t</b>     rx_frames;
    <b>int64_t</b>     rx_bytes;
    <b>int64_t</b>     rx_frames_corrupted;
    <b>int64_t</b>     rx_frames_collisions;
} CnetLinkStats;

<b>int</b> CNET_get_linkstats(<b>int</b> link, CnetLinkStats *stats);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_get_linkstats()</code> provides the current node with statistics
about each of its own communication links.
</p>

<p>
A node's link statistics are cleared when the node reboots.
The "sum" of all link statistics form the global link statistics which
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
<dt><code>ER_BADLINK</code></dt>
    <dd>The value of <code>link</code> is less than zero, or greater than the
    number of physical links of the current node.
    </dd>

<dt><code>ER_BADARG</code></dt>
    <dd><code>stats</code> was a NULL pointer.
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_get_nodestats.php">CNET_get_nodestats</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
