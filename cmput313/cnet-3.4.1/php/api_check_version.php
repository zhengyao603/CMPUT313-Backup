<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_check_version - ensure compatability between <i>cnet</i> and user
protocols.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>void</b> CNET_check_version(<b>char</b> *current_version);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
This function compares the current version of the <i>cnet</i> simulator
with the version of the <code>&lt;cnet.h&gt;</code> header file that was used to
compile the currently running user protocol.
A typical invocation is:
</p>

<p>
<pre>     <code>CNET_check_version(CNET_VERSION);</code></pre>
</p>

<p>
where the string constant <code>CNET_VERSION</code>
is defined in the <code>&lt;cnet.h&gt;</code> header file included by the user's
protocol.
A version mismatch indicates that there may be some incompatability
between <i>cnet</i> and the protocol.
The user's code should be recompiled.
<p></dd>

<dt>RETURN VALUE</dt>
<dd>
On success, the function simply returns.
On failure, an error message is printed to C's <code>stderr</code> stream
and <i>cnet</i> terminates.
<p></dd>

</dl>
</dd>

<!--
<dt>SEE ALSO</dt>
<dd>
aaa,
bbb,
ccc
</dd>
-->

</dl>

<?php require_once("cnet-footer.php"); ?>
