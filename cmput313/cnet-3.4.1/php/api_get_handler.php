<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>CNET_get_handler - reports the function being called when a specific event occurs.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>int</b> CNET_get_handler(CnetEvent ev, <b>void</b> (**function)(), CnetData *data)
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
<code>CNET_get_handler()</code> reports the function (its address)
that is being called when the indicated <i>cnet</i> event occurs.
The second parameter to <code>CNET_get_handler()</code>  is "filled-in"
with the address of the function.
If the second parameter is <code>NULL</code>,
the function's address is not reported.
If the function's address is reported as <code>NULL</code>,
it indicates that the current node is not interested in the indicated event.
</p>

<p>
In addition,
the third parameter to <code>CNET_get_handler()</code>  is "filled-in"
with the data value being delivered to the indicated event handler.
If the third parameter is <code>NULL</code>,
this data value is not reported.
<p></dd>


<dt>RETURN VALUE</dt>
<dd>
The value <code>0</code> is returned on success.
On failure, the value <code>-1</code> is returned,
and the global variable <code>cnet_errno</code> is set to one of the
following values to describe the error:
<p>

<dl>
<dt><code>ER_BADEVENT</code></dt>
    <dd>The first parameter was not a valid <i>cnet</i> event.
    </dd>

<dt><code>ER_NOTSUPPORTED</code></dt>
    <dd>An attempt was made to request the handler for an event that
    cannot occur on the current node.
    Examples include requesting the handler for <code>EV_APPLICATIONREADY</code>
    from nodes without an Application Layer,
    or requesting the handler for <code>EV_KEYBOARDREADY</code>
    from nodes without a keyboard.
    </dd>

</dl>
</dd>

<dt>SEE ALSO</dt>
<dd>
<a href="api_set_handler.php">CNET_set_handler</a>.
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
