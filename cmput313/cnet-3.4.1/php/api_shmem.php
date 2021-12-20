<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_shmem, CNET_shmem2- create, or attach to, a memory segment shared by all nodes.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>void</b> *CNET_shmem(size_t length);
<b>void</b> *CNET_shmem2(<b>const char</b> *name, size_t length);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_shmem()</code> returns a pointer to a block of memory of at least the
requested number of bytes.
If multiple nodes each make the same request,
they will each receive a pointer to the same shared memory.
When first allocated,
the memory is cleared using <code>memset(addr,0,length)</code>.
</p>

<p>
<code>CNET_shmem2()</code> also accepts a string, <code>name</code>,
to identify one of many named shared memory segments.
</p>

<p>
The shared memory can be used to conveniently maintain some global
statistics, accessible by all nodes.
The provision of <code>CNET_shmem()</code> and <code>CNET_shmem2()</code>
is <i>not</i> intended to provide a covert communication channel between nodes.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
On success, a valid pointer is returned.
On failure, the <code>NULL</code> pointer is returned,
and the global variable <code>cnet_errno</code> is set to one of the
following values to describe the error:
</p>

<p>
<dl>
<dt><code>ER_BADARG</code></dt>
    <dd><code>length</code> is equal to zero.
    </dd>

<dt><code>ER_BADSIZE</code></dt>
    <dd>The node has requested a shared memory segment whose length is
    greater than the currently available shared segment.
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
