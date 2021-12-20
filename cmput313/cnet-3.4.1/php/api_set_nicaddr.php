<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_set_nicaddr - set the NIC address of a LAN or WLAN link
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_set_nicaddr(<b>int</b> link, CnetNICaddr new_nicaddr);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_set_nicaddr</code> sets the hardware address recognized by
the Network Interface Card (NIC) of the indicated physical link.
</p>

<p>
The new address may not be the zero address, <code>00:00:00:00:00:00</code>,
or the broadcast address, <code>ff:ff:ff:ff:ff:ff</code>.
No check is made to ensure that the new address is unique within the
network
(thereby enabling some snooping/sniffing "protocols" to be developed).
</p>

<p>
NIC addresses may only be set for links of type <code>LT_LAN</code>
or <code>LT_WLAN</code>.
</p>

<p>
<dt>RETURN VALUE</dt>
<dd>
The value <code>0</code> is returned on success.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to one of the
following values to describe the error:
<p>

<dl>
<dt><code>ER_BADARG</code></dt>
    <dd>The value of <code>new_nicaddr</code> is either the zero or the
    broadcast address.
    </dd>

<dt><code>ER_BADLINK</code></dt>
    <dd>The value of <code>link</code> is less than zero or greater than the
    number of physical links.
    </dd>

<dt><code>ER_NOTSUPPORTED</code></dt>
    <dd>The current link is not of link type <code>LT_LAN</code> or
    <code>LT_WLAN</code>.
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_parse_nicaddr.php">CNET_parse_nicaddr</a> and
<a href="api_format_nicaddr.php">CNET_format_nicaddr</a>
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
