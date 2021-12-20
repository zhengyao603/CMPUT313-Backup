<?php require_once("cnet-header.php"); ?>

<h1 id="physical"><i>cnet's</i> Physical Layer</h1>

<p>
The Physical Layer attempts to deliver data frames between nodes.
Frames are delivered along any combination of
<i>wide-area-networking</i> (WAN),
<i>local-area-networking</i> (LAN), or
<i>wireless-local-area-networking</i> (WLAN) links.
</p>

<p>
Each physical link is numbered within each node from 1 to its total
number of links.
As a special case, link 0 represents a <i>loopback</i> link,
and is provided to simply copy a frame immediately from a node's output
to input.
In general, the Physical Layer will randomly corrupt and drop data frames
on all WAN, LAN, or WLAN links,
but not on the loopback link or Ethernet segments.
</p>

<p>
When your protocols wish to transmit a data frame along a link,
they write that frame to the Physical Layer.
On calling the <code>CNET_write_physical</code> function,
you indicate the length of the frame to be written and on return
<code>CNET_write_physical</code> indicates how many bytes were accepted.
A typical sequence for a network of just 2 nodes,
connected by a single WAN link is:
</p>

<div class="code">
<b>char</b>         myframe[ MAX_MESSAGE_SIZE + MY_OVERHEAD ];
size_t       length;

 ...   <i>// prepare frame contents for transmission</i>
length = ... ;
result = CNET_write_physical(1, myframe, &amp;length);
</div>

<p>
When <i>cnet</i> informs the destination node that a frame has arrived,
the handler for <code>EV_PHYSICALREADY</code> should read that frame.
On return from a successful call to <code>CNET_read_physical</code>,
your protocol is informed on which link the frame arrived and how long it was.
</p>

<p>
Of course,
in a simple network with just one WAN connection or one Ethernet segment,
all frames will be transmitted and will arrive on link number <code>1</code>.
WAN links impose no particular format on the frames written to it;
unless corrupted or lost, whatever is written to a WAN link will
arrive unmodified, and without interpretation, at the other end of the link.
</p>

<p>
As an aid to debugging protocols,
the function <code>CNET_write_physical()</code> will 'trap' the situation
when a <i>large</i> number of frames have been written to the Physical Layer,
and when the receiving node has not read any of them off.
This trap is currently set at the large value of 1000,
which surely indicates an error in a protocol.
An errant protocol may have some unbounded loop,
or a very short timeout-and-retransmission sequence,
resulting in many calls to <code>CNET_write_physical()</code> at the sender,
before any <code>EV_PHYSICALREADY</code> events are handled at the receiver.
If the frame limit is exceeded,
<code>CNET_write_physical()</code> will return <code>-1</code>
and set <code>cnet_errno</code> to <code>ER_TOOBUSY</code>.
</p>

<div class="code">
<b>char</b>         myframe[ MAX_MESSAGE_SIZE + MY_OVERHEAD ];
size_t       length;
<b>int</b>          link;

length = <b>sizeof</b>(myframe);
result = CNET_read_physical(&amp;link, myframe, &amp;length);
 ...   <i>// process frame contents</i>
</div>

<p>
To provide some sense of realism,
frames (or packets) written to Ethernet links are expected to carry the
address of their destination Network Interface Card (NIC) at the very
beginning of the frame.
<i>cnet</i> provides the data type <code>CnetNICaddr</code> to represent the
addresses of its NICs,
as an array of <code>LEN_NICADDR</code> (=6) unsigned characters.
</p>

<p>
<i>cnet</i> interprets the leading <code>LEN_NICADDR</code> bytes of each frame
on an Ethernet segment to be an address.
The special address, whose string representation is <code>ff:ff:ff:ff:ff:ff</code>,
is interpreted as the Ethernet <i>broadcast address</i>.
Any frame carrying the broadcast address as its destination address will be
delivered to all NICs on the Ethernet segment, except the sender.
<i>cnet</i> does not support multicast or group addressing.
</p>

<p>
Consider the following example function,
used to write data to an Ethernet segment:
</p>

<div class="code">
<b>typedef struct</b> {
    CnetNICaddr    dest;
    CnetNICaddr    src;
    <b>char</b>           type[2];
    <b>char</b>           data[ETH_MAXDATA];
} ETHERPACKET;

#define LEN_ETHERHEADER (sizeof(ETHERPACKET) - ETH_MAXDATA)

<b>static void</b> write_to_ethernet(CnetNICaddr dest, <b>int</b> link, <b>char</b> *buf, size_t len)
{
    ETHERPACKET packet;
    <b>short int</b>   twobytes;

    memcpy(packet.dest, dest,                   <b>sizeof</b>(CnetNICaddr));
    memcpy(packet.src,  linkinfo[link].nicaddr, <b>sizeof</b>(CnetNICaddr));

    twobytes = len;              <i>// type carries the data's true length</i>
    memcpy(packet.type, &amp;twobytes, 2);
    memcpy(packet.data, buf, len);

    len  += LEN_ETHERHEADER;
    <b>if</b>(len &lt; ETH_MINPACKET)      <i>// pad short packets to minimum length</i>
        len = ETH_MINPACKET;
    CHECK(CNET_write_physical(link, (<b>char</b> *)&amp;packet, &amp;len));
    ......
}
</div>

<p>
This function assumes that the data's length is not too long for Ethernet
(<code>&lt;=&nbsp;ETH_MAXDATA</code> (=1500) bytes).
The required destination's NIC address is first copied to the destination
address field,
and then the address of the local NIC used copied to the source address field.
Notice that because the <code>CnetNICaddr</code> type is actually an array of
characters, we do not use the &amp; operator in the calls to <code>memcpy</code>.
</p>

<p>
The data's true length is copied into the packet's two-byte <code>type</code>
field, the provided data copied to the packet's data.
After ensuring that the packet to be written is at least
<code>ETH_MINPACKET</code> (=64) bytes long,
the packet is written to the link.
</p>

<p>
Again, <i>cnet</i> does not enforce (nor understand) the use of
<i>our</i> <code>ETHERPACKET</code> data type,
but <i>does</i> assume that the first
<code>LEN_NICADDR</code> bytes of each packet provides the destination NIC address.
</p>

<p>
Two additional Physical Layer functions are provided to assist in the
debugging of multi-layered protocols.
<code>CNET_write_physical_reliable</code> is identical to
<code>CNET_write_physical</code> except that frames sent using it will not be
subject to frame corruption or loss.
It can be considered as a "perfect" Data Link Layer if you just want
to implement higher-layered protocols.
The function <code>CNET_write_direct</code> also bypasses all Physical Layer errors
and instructs a message to be sent directly to the node whose address is
specified as a parameter.
It thus provides perfect a Data Link Layer and Network Layer.
</p>

<?php require_once("cnet-footer.php"); ?>
