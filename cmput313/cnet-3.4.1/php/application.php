<?php require_once("cnet-header.php"); ?>

<h1 id="application"><i>cnet's</i> Application Layer</h1>

<p>
The Application Layer
(either the internal default version or one provided with the
<a href="options.php#option-A">-A</a> option)
has the responsibility of generating messages to be delivered to other
Application Layers.
An Application Layer will not generate a message for its own node.
The required destination node is identified by
its <i>network address</i> and not <i>node number</i>.
Each node's address and node number will in fact be the same,
unless the <code>address</code> attribute is specified in the topology file.
</p>

<p>
When <i>cnet</i> informs your protocols that the Application Layer
has a message for delivery,
your protocols will read the message into a buffer supplied by you.
You must first indicate the maximum message size that you are willing
to receive.
A successful read will then "fill-in" the <i>address</i> of the message's
destination node and the actual length of the message.
Your protocols are simply presented with "a lump of bytes",
at least 32 bytes long,
which they must deliver to other Application Layers.
The message is to be considered as <i>opaque data</i>,
its contents are immaterial,
though suffice to say that there is sufficient information in the
message for <i>cnet</i> to diagnose most protocol errors for you.
A typical sequence is:
</p>

<div class="code" style="width: 36em;">
<b>char</b>         msgbuffer[ MAX_MESSAGE_SIZE ];
CnetAddr     destaddr;
size_t       length;

length = <b>sizeof</b>(msgbuffer);
result = CNET_read_application(&amp;destaddr, msgbuffer, &amp;length);
<i>// prepare message for transmission ...</i>
</div>

<p>
When the message reaches the correct destination node,
it may be written to the Application Layer:
</p>

<div class="code" style="width: 36em;">
<i>// ... receive message from another node</i>
result = CNET_write_application(msgbuffer, &amp;length);
</div>

<p></p>

<hr>

<h1>Enabling and disabling the Application Layer</h1>

<p>
Protocols will typically need to restrict,
or <i>throttle</i>,
the generation of messages for certain destination nodes.
This may be achieved using the functions
<code>CNET_enable_application</code> and
<code>CNET_disable_application</code> which each accept a single parameter
indicating which destination address to throttle.
For example,
if the node whose address is <code>busynode</code> becomes busy or swamped,
we can stop our Application Layer from generating messages for this node with:
</p>

<pre>    <code>result = CNET_disable_application(busynode);</code></pre>

<p>
Similarly, we can permit messages to be generated for all nodes (other
than ourselves, of course) with:
</p>

<pre>    <code>result = CNET_enable_application(ALLNODES);</code></pre>

<p>
This statement would typically be called in each node's
<code>reboot_node()</code> function.
</p>

<?php require_once("cnet-footer.php"); ?>
