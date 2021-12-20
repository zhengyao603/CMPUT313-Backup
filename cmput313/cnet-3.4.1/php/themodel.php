<?php require_once("cnet-header.php"); ?>

<h1>The <i>cnet</i> simulation model</h1>

<p>
<i>cnet</i> supports a model of networking in which <i>nodes</i>
are either <i>hosts</i>, <i>routers</i>, <i>mobiles</i>,
or <i>accessspoints</i>.
The different types of nodes have different properties.
For example,
host and mobile nodes have an Application Layer that generates
messages for delivery to the Application Layers of other hosts or mobiles.
While hosts and mobiles never generate messages for themselves,
routers and accesspoints cannot generate messages at all.
</p>

<p>
The nodes are connected by a variety of network <i>links</i>,
using <i>wide-area-networking</i> (WAN),
<i>local-area-networking</i> (LAN), or
<i>wireless-local-area-networking</i> (WLAN) links.
Introductory protocols will typically employ only hosts and WAN links.
</p>

<p>
The <i>cnet</i> simulation model appears in the following diagram:
</p>

<p style="text-align: center;">
<img SRC="images/layers.png" alt="layers">
</p>

<p>
<i>cnet</i> itself provides all nodes with
a <a href="physical.php">Physical Layer</a>
and each <i>host</i> and <i>mobile</i>
with an <a href="application.php">Application Layer</a>.
In addition, a <i>hidden</i> Error Layer lurks above each Physical Layer,
and randomly introduces frame loss or corruption according
to specified probabilities.
Note that the standard OSI/ISO model does not provide an Error Layer!
</p>

<p>
Perhaps surprisingly,
the nodes initially have very little knowledge of the rest of the network.
Nodes do not know how many other nodes there are,
what the other nodes are called,
nor the attributes of any nodes or links other than their own.
All inter-node communication necessary to learn this information
must traverse the Physical Layer.
</p>

<p>
Nodes occupy positions on a large simulation 'map';
hosts, routers, and accesspoints are stationary,
but mobile nodes may move around the map under their own programmatic control.
A few obvious restrictions apply to the possible combination of nodes and
their links -
while hosts, routers, and accesspoints may have any number and type
of network links (including wireless WLAN links),
mobile nodes may only have a single WLAN link.
</p>

<p>
Links are numbered within each node
from <code>0</code> to the number of physical links that the node has.
Link number <code>0</code> is always the node's <code>LOOPBACK</code> link,
which simply delivers anything transmitted to it straight back to the same node.
The first "real" link is number <code>1</code> and every node will have
a link number <code>1</code>.
Each node's link attributes may be accessed, at runtime,
via elements of the C structure variables
<code>linkinfo[0]</code>,
<code>linkinfo[1]</code>,
<code>linkinfo[2]</code>, and so on.
Other than for the <code>LOOPBACK</code> link,
there is no restriction on which link types may occupy which physical positions.
</p>

<h1 id="layers">Protocol layers</h1>

<p>
<i>cnet</i> protocols are written from the point of view of each node.
We imagine that we are writing our protocols <i>inside</i>
the operating system's kernel of each node.
We have the ability to write all of the <i>interior protocols</i>
between the Application and Physical Layers.
The protocols may be as simple or as complex as desired,
and should follow a layered approach to isolate distinct responsibilities.
For example:
</p>

<ul>
<li> a network of only 2 nodes will only need a single layer
between the Application and Physical Layers
(usually termed a Data-Link Layer protocol).
This protocol will simply have the responsibility of reliably
moving frames across the single error-prone bidirectional link between
the two nodes.

<li> a network consisting of more than two nodes,
will (ideally) require an additional layer between the Application and
Data-Link Layers (usually termed a Network Layer protocol)
to manage packet routing, possibly congestion- and flow-control,
and message fragmentation (and possibly some other responsibilities).

<li> a network in which the nodes may crash or the links may be severed
will (ideally) require an additional layer between the Network and
Application Layers (usually termed a Session Layer protocol)
to ensure that old packets that have been "floating" around the network
between crashes are not considered as part of the <i>current</i>
communication session, and

<li> a network in which we are conscious of limited bandwidth and security
may require an additional layer between the Session and
Application Layers (usually termed a Presentation Layer protocol)
to provide compression and/or encryption of our data before it is transmitted.
</ul>

<p>
Of course,
these ideas and the responsibilities of each layer are not
peculiar to the <i>cnet</i> simulator,
and are very well motivated and described in many undergraduate textbooks
on data communications and computer networking.
However, <i>cnet</i> supports these ideas by <i>not getting in the way</i>,
and by <i>not</i> imposing particular methodologies or data structures
on your protocols.
</p>

<p>
Protocols are written using an
<a href="eventdriven.php"> event-driven programming style</a>,
as if we were writing the protocols as part of an operating system's kernel.
As well as handling network-related events,
a traditional operating system must handle other events for its file-system,
devices, and to let user-level processes execute.
For this reason, our protocols must execute as quickly as possible,
and then relinquish control to <i>cnet</i> (as if an operating system)
for it to schedule other activities.
<i>cnet</i> is unaware of your using one or ten interior layers -
<i>cnet</i> only provides the highest and lowest layers,
and an <a href="api.php">application programming interface (API)</a>
to interact with these layers.
</p>

<h1>The lifetime of a message</h1>

<p>
It is instructive to consider the <i>lifetime of a message</i> in <i>cnet</i>.
A message is first generated in the Application Layer of, say, <code>node0</code>
for delivery to the Application Layer of <code>node1</code>.
The Application Layer informs our interior protocol layer(s), via an event,
that a message requires delivery.
Our interior protocols do not know, nor care, about the contents of this
message, and simply treat it as a block of bytes.
Because the nodes are simulating distinct computers,
we must use the provided Physical Layer,
accessible via each node's link number 1, to deliver the message.
From the point of view of the <i>message</i>,
and assuming that all goes well,
this is what happens:

<ol>
<li> node0's Application Layer generates the new message and announces
	it with the <code>EV_APPLICATIONREADY</code> event,
	</li>
<li> node0's interior protocol calls <code>CNET_read_application</code> to read
	(and thereafter <i>own</i>) the message,
	and to learn its length and intended destination (node1),
	</li>
<li> node0's interior protocol does whatever it wants with the message,
	typically including it in the payload of a frame or packet
	structure for transmission,
	</li>
<li> node0 calls <code>CNET_write_physical</code> to transmit a block of bytes
	(presumably including the message) via its link 1,
<p>
	................
<p>
	</li>

<li> after a short transmission delay,
	dependent on the number of bytes being transmitted,
	the bandwidth and propagation delay of the communication medium,
	the bytes arrive at node1's Physical Layer via its link 1,
	</li>
<li> node1's Physical Layer announces the arrival,
	via the <code>EV_PHYSICALREADY</code> event,
	</li>
<li> node1's interior protocol calls <code>CNET_read_physical</code> to read
	(and now <i>own</i>) the bytes,
	</li>
<li> node1's interior protocol does whatever it wants with the message,
	typically copying it from the payload of any structure used to
	transmit the message,
	</li>
<li> node1's interior protocol finally calls
	<code>CNET_write_application</code> to deliver the message to its
	Application Layer.
	</li>
</ol>

<p>
As stated, the above sequence assumes that nothing goes wrong - and if
nothing went wrong, writing network protocols would be no fun!
We must obviously call the functions in
<a href="api.php"><i>cnet</i>'s API</a> correctly but,
more importantly,
our interior protocols must detect and manage errors in the network itself,
because <i>cnet</i>'s Error Layer randomly corrupts and loses frames.
If we wish to only develop higher-layer protocols,
we can bypass <i>cnet</i>'s Error Layer entirely by calling
<code>CNET_write_physical_reliable</code>,
or get a frame to the correct destination node in a single action
by calling <code>CNET_write_direct</code>.

<?php require_once("cnet-footer.php"); ?>
