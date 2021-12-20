<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_getvar - obtain the value of a per-node environment variable
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>char</b> *CNET_getvar(<b>const char</b> *name);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_getvar</code> obtains the value of the per-node environment
variable corresponding to the value of <code>name</code>.
Environment variables may be defined in a <i>cnet</i> toplogy file,
and may either be global (defined outside of any node's definition)
or defined within a node's definition.
Each node inherits all global environment variables at the time of
the node's definition (in the toplogy file),
and each node may redefine any variable's value to provide a local definition.
</p>
</dd>

<dt>RETURN VALUE</dt>
<dd>
On success,
the value corresponding to <code>name</code> is returned.
<br>
On failure (if no value corresponds to <code>name</code>)
the empty string <code>""</code> is returned
(note that this is not the <code>NULL</code> string).
</p>

<p>
Depending on the role of the variable,
its string representation may need conversion with
<code>atoi()</code> or <code>atof()</code>.
</p>

<dt>NOTE</dt>
<dd>
The values of environment variables cannot be modified or deleted at run-time.
</dd>

<!--
<dt>SEE ALSO</dt>
<dd>
<a href="api_start_timer.php">CNET_start_timer</a>, and
<a href="api_timer_data.php">CNET_timer_data</a>.
</dd>
-->

</dl>

<?php require_once("cnet-footer.php"); ?>
