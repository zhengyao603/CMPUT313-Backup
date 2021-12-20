<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_enable_application - permit the generation of new messages for
delivery to other nodes
<p>
</dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_enable_application(CnetAddr destaddr);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_enable_application</code>
permits the Application Layer to generate new messages for the destination
node with the indicated network address.
</p>

<p>
If the value of <code>destaddr</code> is the symbolic constant <code>ALLNODES</code>,
then message generation will be enabled for all other nodes.
Messages are never generated for delivery to oneself.
Initially,
message generation to all destination nodes is <i>disabled</i>
and must be enabled to begin the generation of messages.
</p>
</dd>


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
<a href="api_disable_application.php">CNET_disable_application</a>,
and
<a href="api_read_application.php">CNET_read_application</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
