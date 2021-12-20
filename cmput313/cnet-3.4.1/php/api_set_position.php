<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_set_position - set the node's location on the simulation map
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_set_position(CnetPosition new);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
All simulations run within a rectangular region whose dimensions are
set in the toplology file by specifying the attributes of
<code>mapwidth</code> and <code>mapheight</code> as two non-negative integer values.
There is no maximum constraint on the Z-axis.
</p>

<p>
Nodes of type <code>NT_MOBILE</code> may move around the simulation map
by calling <code>CNET_set_position</code> to set the node's location.
Calls to <code>CNET_set_position</code> during simulations not using the
graphical interface are still meaningful.
</p>

<p>
The dimensions of the simulation area are measured in metres,
and may be specified by setting the <code>mapwidth</code> and <code>mapheight</code>
attributes in the toplogy file.
Distances, in metres,
are used in the default calculations of wireless signal strength and
propagation delay of <code>LT_WLAN</code> transmissions.
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
<dt><code>ER_BADPOSITION</code></dt>
    <dd>The value of <code>new.x</code>, <code>new.y</code>,
	or <code>new.z</code> is off the map.
    </dd>

<dt><code>ER_NOTSUPPORTED</code></dt>
    <dd>The current node is not of type <code>NT_MOBILE</code>.
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_get_position.php">CNET_get_position</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
