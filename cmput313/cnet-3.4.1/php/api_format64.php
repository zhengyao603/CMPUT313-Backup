<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_format64 - format a 64-bit integer
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>char</b> *CNET_format64(<b>int64_t</b> value);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
Large 64-bit integers may always be formatted in ISO-C99
using the <code>printf</code> format specifier of <code>"%lld"</code>.

However, as integer values become larger,
such as instances of <code>CnetTime</code>,
their readability is reduced.
<code>CNET_format64</code> may be used to format the integer with
commas included every 3 digits to increase the readability.
</p>

<p>
The function <code>CNET_set_commas</code> may be used to enable or disable the
inclusion of commas.

<i>cnet</i> also uses this function, internally,
to format large integers with commas on the GUI.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
<code>CNET_format64</code> returns a pointer to static storage containing the
64-bit integer formatted as a NULL-byte terminated string.
No errors are possible.
<p></dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_set_commas.php">CNET_set_commas</a>, and
<a href="api_set_commas.php">CNET_get_commas</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
