<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_set_debug_string - place a short string on <i>cnet</i>'s GUI.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_set_debug_string(CnetEvent ev, <b>char</b> *string);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
This function enables a short label to be placed on
one of the debug buttons of <i>cnet</i>'s GUI.
If <code>string</code> is NULL or the empty string,
the label on the indicated button is removed.
If <i>cnet</i> is being executed without its GUI,
this function is always successful, but has no effect.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
The value <code>0</code> is returned on success.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to one of the
following values to describe the error:
<p>

<dl>
<dt><code>ER_BADEVENT</code></dt>
    <dd>The value of <code>ev</code> is not one of the events
    <code>EV_DEBUG0..EV_DEBUG4</code>.
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
