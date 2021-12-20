<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s support functions</h1>

<dl>

<dt>NAME</dt>
<dd>MD5 cryptographic checksum functions.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;
#include &lt;cnetsupport.h&gt;

#define MD5_BYTELEN     16
#define MD5_STRLEN      32

<b>extern  void</b>    *MD5_buffer(<b>const char</b> *input, size_t len, <b>void</b> *md5_result);
<b>extern  char</b>    *MD5_format(<b>const void</b> *md5_result);
<b>extern  char</b>    *MD5_str(<b>const char</b> *str);
<b>extern  char</b>    *MD5_file(<b>const char</b> *filenm);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
Text.
<p></dd>

<dt>EXAMPLE</dt>
<dd>A typical use of these functions is:
<p>

<code>
    code;
</code>
<p></dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
