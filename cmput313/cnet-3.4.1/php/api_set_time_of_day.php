<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_set_time_of_day - set the node's "wall-clock" time.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_set_time_of_day(<b>long</b> newsec, <b>long</b> newusec);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
This function changes the node's "wall-clock" time of day.
As each node's <code>nodeinfo</code> structure is considered a read-only variable,
this is the only method to set its
<code>time_of_day.sec</code> and <code>time_of_day.usec</code> fields.
</p>

<p>
<code>nodeinfo.time_of_day.sec</code> is the number of seconds since Jan. 1, 1970,
and may be used in a call to the POSIX C function <code>ctime(3c))</code>.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
The value <code>0</code> is returned on success.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to one of the
following values to describe the error:
<p>

<dl>
<dt><code>ER_BADARG</code></dt>
    <dd>Either <code>newsec</code> or <code>newusec</code> is less than <code>0</code>,
     or <code>newusec</code> is greater than <code>999999</code>.
    </dd>

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
