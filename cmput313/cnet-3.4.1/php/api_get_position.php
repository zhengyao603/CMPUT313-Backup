<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_get_position - get the node's location on the simulation map
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_get_position(CnetPosition *now, CnetPosition *max);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
All simulations run within a rectangular region whose dimensions are
set in the toplology file by specifying the attributes of
<code>mapwidth</code> and <code>mapheight</code> as two non-negative integer values.
Nodes of all types may determine their current location,
and the maximum dimensions of the simulation map,
by calling <code>CNET_get_position</code>.
</p>

<p>
If the value <code>NULL</code> is passed for either of the two parameters,
the corresponding position is not provided.
</p>

<p>
Calls to <code>CNET_get_position</code> during simulations not using the
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
The value <code>0</code> is always returned.
<p></dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_set_position.php">CNET_set_position</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
