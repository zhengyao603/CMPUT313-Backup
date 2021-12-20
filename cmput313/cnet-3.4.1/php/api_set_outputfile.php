<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_set_outputfile - request that a node's output be saved into a file.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_set_outputfile(<b>const char</b> *filenm)
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
Requests that a copy of a node's output,
produced by <code>printf()</code> or <code>putchar()</code>,
is made into the named file.
</p>
</dd>


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
    <dd>The value of <code>filenm</code> is <code>NULL</code>
	or the named file cannot be opened for writing.
    </dd>
</dl>
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
