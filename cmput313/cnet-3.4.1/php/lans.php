<?php require_once("cnet-header.php"); ?>

<h1><i>cnet's</i> local area network (LAN) segments</h1>

<p>
As of version 2.0, <i>cnet</i> supports
local-area network (LAN) segments,
that can closely follow the specifications of IEEE&nbsp;802.3 Ethernet segments.
Each segment consists of two or more Network Interface Cards (NICs) that
connect host nodes, routers, or accesspoints to the segment.
Large networks may be constructed by joining multiple LAN segments via
gateway nodes and WAN links.
</p>

<p>
<i>cnet</i> provides access to each NIC's address as a field of the
standard <code>linkinfo</code> structure.
The <a href="datatypes.php#nicaddr"><code>CnetNICaddr</code></a>
datatype stores each NIC address as an array of 
<code>LEN_NICADDR</code> (=6) unsigned characters.
<i>cnet</i> also provides the functions
<a href="physical.php"><code>CNET_parse_nicaddr</code></a> and
<a href="physical.php"><code>CNET_format_nicaddr</code></a>
to convert between character strings and the <code>CnetNICaddr</code> datatype.
</p>

<p>
<i>cnet</i> checks and warns if two NIC addresses in a topology files 
are the same, but does not demand their uniqueness.
This permits the development of malicious snooping/sniffing "protocols"
that use
<a href="physical.php"><code>CNET_set_nicaddr</code></a>
to masquerade as other nodes.
</p>

<p></p>

<h1>Reading and writing data via LAN segments</h1>

<p>
It is anticiapted that frames written to <code>LT_LAN</code> links will
carry the address of their destination Network Interface Card (NIC)
near the beginning of the frame.
Consider the following example function to write data to a LAN segment:
</p>

<div class="code">
<b>typedef struct</b> {
    CnetNICaddr    dest;
    CnetNICaddr    src;
    <b>char</b>           type[2];
    <b>char</b>           data[LAN_MAXDATA];
} ETHERPACKET;

#define LEN_ETHERHEADER (2*sizeof(CnetNICaddr) + 2*sizeof(char))

<b>void</b> write_to_lan(CnetNICaddr dest, <b>int</b> link, <b>char</b> *buf, size_t length)
{
    ETHERPACKET    packet;
    <b>short int</b>      twobytes;

    memcpy(packet.dest, dest,                   <b>sizeof</b>(CnetNICaddr));
    memcpy(packet.src,  linkinfo[link].nicaddr, <b>sizeof</b>(CnetNICaddr));

    twobytes = length;           <i>// type carries the data's true length</i>
    memcpy(packet.type, &amp;twobytes, 2);
    memcpy(packet.data, buf, length);

    length  += LEN_ETHERHEADER;
    <b>if</b>(length &lt; ETH_MINPACKET)   <i>// pad short packets to minimum length</i>
        length = ETH_MINPACKET;
    CHECK( CNET_write_physical(link, (<b>char</b> *)&amp;packet, &amp;length) );
}
</div>

<p>
This simplified function assumes that the data's length is not too long
for the LAN (<code>&lt;=&nbsp;LAN_MAXDATA</code> (=1500) bytes).
The destination's NIC address is first copied to the destination
address field,
and the address of the local NIC used is copied to the source address field.
Notice that because the <code>CnetNICaddr</code> type is actually an array of
characters, we do not use the &amp; operator in the calls to <code>memcpy</code>.
</p>

<p>
The data's true length is copied into the packet's two-byte <code>type</code>
field, and the provided data copied to the packet's data.
After ensuring that the packet to be written is at least
<code>ETH_MINPACKET</code> (=64) bytes long,
the packet is written to the link.
</p>

<p>
Again, <i>cnet</i> does not enforce (nor understand) the use of
<i>our</i> <code>ETHERPACKET</code> data type.
</p>

<p></p>

<h1>Limitations</h1>

<p>
<i>cnet</i>'s simulation of IEEE&nbsp;802.3 Ethernets is reasonable,
but not perfect.
<i>cnet</i> supports a fixed transmission rate of 10Mbps,
a slot-time of 52usecs, broadcast addressing,
collision detection, jamming, and binary exponential backoff.
It does not support sub-microsecond timing, jitter control,
nor multicast addressing.
Each segment is considered to be a full 2.5km long,
and all nodes on a segment are considered to be equally spaced
along the segment.
</p>

<?php require_once("cnet-footer.php"); ?>
