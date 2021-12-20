<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_get_mapscale - get the scale of the simulation map
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>double</b> CNET_get_mapscale(<b>void</b>);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
Simulations run within a rectangular region, the <i>map</i>,
whose dimensions are set in the toplology file with the attributes
<code>mapwidth</code> and <code>mapheight</code>.
In addition, items such as nodes and links that are drawn on the
map are scaled by the global attribute <code>mapscale</code>, which
indicates how many real-world metres are represented by one pixel
on the simulation's map.
</p>

<p>
If your protocol code needs to draw any items on the map,
using the <code>TCLTK</code> function,
then the <code>x</code> and <code>y</code> coordinates should first be
<i>divided</i>
by the value of <code>mapscale</code>.
</p>

<p>
The map's scale will not change during a simulation,
and so <code>CNET_get_mapscale</code> only needs to be called once.
</p>
</dd>


<dt>RETURN VALUE</dt>
<dd>
The scale of the simulation map is returned.
The function cannot fail.
<p></dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_get_position.php">CNET_get_position</a> and
<a href="api_set_position.php">CNET_set_position</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
