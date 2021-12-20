<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_trace_name - request that a descriptive name be reported for
a traced address.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_trace_name(<b>void</b> *address, <b>const char</b> *name);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
Many of <code>cnet</code>'s standard functions accept parameters that
are memory addresses, typically to receive results "passed back from"
or "filled in by" the functions.
By default,
when <code>cnet</code> traces a node's execution these addresses are printed
as large, often meaningless, hexadecimal constants.
</p>

<p>
Each call to
<code>CNET_trace_name()</code> associates a character string, or <code>name</code>,
with an <code>address</code>.

If <code>cnet</code> needs to report that address when execution is being traced,
the associated string will be reported instead of the hexademical
value.
</p>

<p>
This is most helpful when the actual name of a C variable or function
is associated with its address.
This enables <code>cnet</code> to report the much more helpful name whenever
the address is being traced.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
The value <code>0</code> is returned on success.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to the
following value to describe the error:
</p>

<p>
<dl>
<dt><code>ER_BADARG</code></dt>
    <dd>Either the provided address is <code>NULL</code>,
	or the associated name is the <code>NULL</code> or empty string.
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
