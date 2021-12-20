<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_format_nicaddr - convert a NIC address to a well-formed string
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_format_nicaddr(<b>char</b> *string, CnetNICaddr nicaddr);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_format_nicaddr</code> accepts a Network Interface Card (NIC) address
and formats its "internal" form to a string of characters of the form
<code>ab:cd:ef:gh:ij:kl</code>,
where each letter will be a hexadecimal character.
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
    <dd><code>string</code> is a <code>NULL</code> pointer.
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_set_nicaddr.php">CNET_set_nicaddr</a> and
<a href="api_parse_nicaddr.php">CNET_parse_nicaddr</a>
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
