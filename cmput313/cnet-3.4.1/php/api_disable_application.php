<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_disable_application - suppress the generation of new messages for
delivery to other nodes
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_disable_application(CnetAddr destaddr);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_disable_application</code>
suppresses the Application Layer from generating new messages to the
destination node with the indicated network address.
</p>

<p>
If the value of <code>destaddr</code> is the symbolic constant <code>ALLNODES</code>,
then message generation will be disabled for all other nodes.
This function should be called when a harried node runs out of
buffer space or, perhaps, while routing information is being gathered.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
The value <code>0</code> is returned on success.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to one of the
following values to describe the error:
<p>

<dl>
<dt><code>ER_BADARG</code></dt>
    <dd>The value of <code>destaddr</code> indicates the current node.
</dd>

<dt><code>ER_NOTSUPPORTED</code></dt>
    <dd>The current node does not have an Application layer.
</dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_enable_application.php">CNET_enable_application</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
