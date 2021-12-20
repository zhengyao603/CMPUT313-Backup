<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_set_commas, CNET_get_commas - manage the use of commas
in formatting 64-bit integers
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>bool</b> CNET_set_commas(<b>bool</b> wanted);
<b>bool</b> CNET_get_commas(<b>void</b>);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_format64</code> may be used to format a 64-bit integer with
commas included every 3 digits to increase the readability.
The function <code>CNET_set_commas</code> may be used to enable or disable the
inclusion of commas,
and <code>CNET_get_commas</code> may be used to report if commas are currently
being included.
<p></dd>

<dt>RETURN VALUE</dt>
<dd>
<code>CNET_get_commas</code> returns indication if commas will be included in
subsequent formatting performed by <code>CNET_format64</code>.
<p>

<code>CNET_set_commas</code> returns a value indicating if
commas were previously included in the formatting performed
by <code>CNET_format64</code>.

<p></dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_format64.php">CNET_format64</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
