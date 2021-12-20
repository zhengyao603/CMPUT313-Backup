<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_parse_nicaddr - convert a well-formed string to a NIC address
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_parse_nicaddr(CnetNICaddr nicaddr, <b>char</b> *string);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_parse_nicaddr</code> accepts a character string of the form
<code>ab:cd:ef:gh:ij:kl</code>,
where each letter is a valid hexadecimal character,
and converts this string representation to <i>cnet</i>'s "internal" form
consisting of an array of 6 unsigned characters.
</p>

<p>
Any valid Network Interface Card (NIC) address is accepted.
<p></dd>

<dt>RETURN VALUE</dt>
<dd>
The value <code>0</code> is returned on success.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to the
following value to describe the error:
<p>

<dl>
<dt><code>ER_BADARG</code></dt>
    <dd><code>string</code> is a <code>NULL</code> pointer,
    or <code>string</code> points to an incorrectly formatted string.
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_set_nicaddr.php">CNET_set_nicaddr</a> and
<a href="api_format_nicaddr.php">CNET_format_nicaddr</a>
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
