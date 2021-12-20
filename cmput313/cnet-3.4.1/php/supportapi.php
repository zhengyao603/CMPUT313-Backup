<?php require_once("cnet-header.php"); ?>

<h1><i>cnet's</i> support Application Programming Interface</h1>

<p>
In addition to
<i>cnet's</i> <a href="api.php">core API</a>,
a number of functions are provided that are not strictly part of <i>cnet</i>,
but have been shown to be frequently required when writing network protocols.
This enables you to focus on the task of protocol writing and evaluation
without having to worry about, for example, the implementation of a
function not provided by the ISO-C99 standard or your operating system.
A protocol accessing any of these functions should have both:
</p>

<div class="code">
#include &lt;cnet.h&gt;
<br>
#include &lt;cnetsupport.h&gt;
</div>

<p>
Note that these functions' names are <i>not</i> prefixed with
<code>CNET_</code>.&nbsp;&nbsp;&nbsp;
As these function are not part of the core API,
they <i>do not</i> set <code>cnet_errno</code> on error,
and are not traced under execution.
</p>

<p>
In each section these functions are presented as C prototypes,
often with an example of their use.
</p>

<b>Basic lexical functions</b>
    <ul>
    <li><a href="support_lexical.php">tokenize</a>,&nbsp;
	<a href="support_lexical.php">free_tokens</a>,&nbsp;
	<a href="support_lexical.php">remove_comment</a>,&nbsp;
	<a href="support_lexical.php">remove_nl</a>
    </ul>

<b>Vector management</b>
    <ul>
    <li><a href="support_vector.php">vector_new</a>,&nbsp;
	<a href="support_vector.php">vector_free</a>,&nbsp;
	<a href="support_vector.php">vector_append</a>,&nbsp;
	<a href="support_vector.php">vector_replace</a>,&nbsp;
	<a href="support_vector.php">vector_peek</a>,&nbsp;
	<a href="support_vector.php">vector_remove</a>,&nbsp;
	<a href="support_vector.php">vector_nitems</a>
    </ul>

<b>Queue management</b>
    <ul>
    <li><a href="support_queue.php">queue_new</a>,&nbsp;
	<a href="support_queue.php">queue_free</a>,&nbsp;
	<a href="support_queue.php">queue_add</a>,&nbsp;
	<a href="support_queue.php">queue_remove</a>,&nbsp;
	<a href="support_queue.php">queue_peek</a>,&nbsp;
	<a href="support_queue.php">queue_nitems</a>
    </ul>

<b>Hashtable management</b>
    <ul>
    <li><a href="support_hashtable.php">hashtable_new</a>
	<a href="support_hashtable.php">hashtable_free</a>,&nbsp;
	<a href="support_hashtable.php">hashtable_add</a>,&nbsp;
	<a href="support_hashtable.php">hashtable_remove</a>,&nbsp;
	<a href="support_hashtable.php">hashtable_find</a>,&nbsp;
	<a href="support_hashtable.php">hashtable_nitems</a>
    </ul>

<b>Cryptographic checksum functions</b>
    <ul>
    <li><a href="support_MD5.php">MD5_buffer</a>,
	<a href="support_MD5.php">MD5_format</a>,
	<a href="support_MD5.php">MD5_str</a>,&nbsp;
	<a href="support_MD5.php">MD5_file</a>.
    </ul>

<b>Distance calculation</b>
    <ul>
    <li><a href="support_haversine.php">haversine</a>,
    </ul>

<p>
Suggestions for other functions to be added to this support API are welcome.
</p>

<?php require_once("cnet-footer.php"); ?>
