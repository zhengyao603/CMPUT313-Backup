<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CRC and checksum functions
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

int32_t  CNET_IP_checksum(<b>unsigned short</b> *addr, size_t nbytes);
uint16_t CNET_ccitt(<b>unsigned char</b> *addr, size_t nbytes);
uint16_t CNET_crc16(<b>unsigned char</b> *addr, size_t nbytes);
uint32_t CNET_crc32(<b>unsigned char</b> *addr, size_t nbytes);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
These four functions each take a memory address and perform the
requested checksum (iff <code>CNET_IP_checksum()</code>) or
CRC (the other three)
calculation on the indicated number of bytes starting from that address.
</p>

<p>
<code>CNET_IP_checksum()</code> calculates the standard Internet checksum,
as defined in
<a href="http://www.faqs.org/rfcs/rfc1071.html">RFC-1071</a>.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
The value returned will be the requested CRC or checksum of the indicated
block of memory.
No error detection is performed on the arguments.
</p>

</dl>
</dd>

<!--
<dt>SEE ALSO</dt>
<dd>
aaa,
bbb,
ccc
</dd>
-->

</dl>

<?php require_once("cnet-footer.php"); ?>
