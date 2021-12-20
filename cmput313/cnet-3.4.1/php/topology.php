<?php require_once("cnet-header.php"); ?>

<h1>Topology files</h1>

<p>
<i>cnet</i> accepts (many)
<a href="options.php">command line options</a>
to control its execution.
However, more important is <i>cnet</i>'s use of a <i>topology file</i>
to define the nodes, links, and attributes in each network simulation.
If the name of the topology file is "-",
then the topology will be read from standard input.
</p>

<p>
Consider the following simple topology file which defines a 2-node network.
An implementation of the <i>stopandwait</i> protocol is being developed
over a single bidirectional <i>WAN</i> link which experiences dataframe
corruption.
<i>cnet</i> keywords are case-sensitive and are presented here in bold font.
</p>

<div class="code" style="width: 24em;">
<i>// A simple 2-node WAN topology</i>

<b>compile</b>          = "stopandwait.c"

<b>mapimage</b>         = "australia.gif"
<b>messagerate</b>      = 500<b>ms</b>
<b>probframecorrupt</b> = 4

<b>host</b> Perth {
    <b>wan to</b> Melbourne
}

<b>host</b> Melbourne {
    <b>east of</b> Perth
}
</div>

<p>
If necessary,
the topology file is first preprocessed by the C-preprocessor,
enabling the use of <code>#include</code>, <code>#define</code> and
conditional "compilation" directives.
Simple <i>// C style comments </i> are also supported.
</p>

<p>
<a href="attributes.php#gattrs">Global attributes</a>
may be defined in each topology file
and affect the execution of the whole simulation.
They may not be redefined on a per-node or per-link basis.
In the above topology,
the <code>mapimage</code> global attribute is defined to request that
the indicated GIF image be drawn on the simulation map.
</p>

<p>
<a href="attributes.php#nodeattrs">Node attributes</a>
and
<a href="attributes.php#linkattrs">link attributes</a>
that are defined before any node definitions define the <i>default</i>
attributes for any following node and link definitions.
These will be the defaults unless redefined
locally within a node or link definition.
</p>

<p>
<i>Local attributes</i> are defined within a new "block",
by opening a curly bracket (as in C).
The following example topology file extends the previous one.
The (global) default <code>messagerate</code> attribute
(the rate at which the Application Layer generates new messages)
is defined to be 500ms.

However, node Perth generates its new messages more slowly,
and defines its own (local) <code>messagerate</code> as <code>1000ms</code>.
Similarly, the bidirectional WAN link between Perth and Melbourne
specifies frame corruption with a
<a href="units.php">probability value</a> of <code>4</code>.
</p>

<div class="code" style="width: 24em;">
<i>// A more complex 2-node WAN topology</i>

<b>compile</b>          = "stopandwait.c"

<b>mapimage</b>         = "australia.gif"
<b>messagerate</b>      = 500<b>ms</b>
<b>probframecorrupt</b> = 4

<b>host</b> Perth {
    <b>messagerate</b>      = 1000<b>ms</b>

    <b>wan to</b> Melbourne {
        <b>probframecorrupt</b> = 2
        <b>probframeloss</b>    = 2
    }
}

<b>host</b> Melbourne {
    <b>east of</b> Perth
}
</div>

<p>
However, the network interface at Perth is more unreliable,
and has a <code>probframecorrupt</code> attribute of <code>2</code>,
locally overriding the explicitly stated default value of <code>4</code>,
and also a <code>probframeloss</code> attribute of <code>2</code>,
locally overriding <i>cnet</i>'s default value (of <code>0</code>).
</p>

<h1>Defining different node types</h1>

<p>
Each node in <i>cnet</i> is either a host (such as a workstation),
a router,
a mobile node (such as a wireless PDA), or
a wireless accesspoint.
We indicate its type in the topology file with a keyword before the node's
name, as in the following incomplete example:
</p>

<div class="code" style="width: 24em;">
<b>host</b> Perth {
    ....
}

<b>router</b> gateway1 {
    ....
}

<b>mobile</b> laptop {
    ....
}

<b>accesspoint</b> endrun {
    ....
}
</div>

<p></p>

<h1>Defining WAN links</h1>

<p>
Nodes of all types, except mobile nodes,
may have one or more point-to-point WAN (wide-area network) links.
All WAN links are bidirectional and, by default, their attributes of
frame loss and corruption, etc, are the same in both directions.
Link attribute names specific to WAN links are prefixed with <code>wan-</code>.
</p>

<p>
Because each WAN link has exactly two endpoints,
only one node (end) needs to explicitly declare the link.
The other node may also explicitly declare the link for clarity,
but usually only does so if it wishes to define link attributes
that are specific for that end.
Consider the following example with 3 nodes and 2 WAN links:
</p>

<div class="code" style="width: 24em;">
<b>compile</b>       = "protocol.c"

<b>wan-bandwidth</b> = 128<b>Kbps</b>
<b>wan-mtbf</b>      = 3600<b>sec</b>
<b>wan-mttr</b>      = 60<b>sec</b>

<b>host</b> Perth {
    <b>wan</b> <b>to</b> Melbourne
}

<b>host</b> Melbourne {
    <b>wan-mtbf</b>   = 10000<b>sec</b>

    <b>wan</b> <b>to</b> Perth {
        <b>wan-mttr</b>   = 30<b>sec</b>
    }
    <b>wan</b> <b>to</b> Sydney {
        <b>wan-mttr</b>   = 10<b>sec</b>
    }
}

<b>host</b> Sydney {
   <i>//  I have a WAN link to Melbourne</i>
}
</div>

<p></p>

<h1>Defining LAN segments and LAN interfaces</h1>

<p>
Nodes of all types, except mobile nodes,
may have one or more LAN (local-area network) links.
Each LAN link connects to exactly one named <i>lan segment</i>,
and all LAN links share their segment's bandwidth to transmit data frames
to other nodes on the same segment.
Link attribute names specific to LAN segments and links are prefixed
with <code>lan-</code>.
</p>

<p>
Each LAN link's Network Interface card (NIC) requires a
<a href="datatypes.php#nicaddr">NIC address</a>,
and this is usually defined as a local LAN attribute
of each LAN link when it is defined inside a node's definition.
Consider the following topology file connecting 3 nodes with
a single 10Mbps LAN segment:
</p>

<div class="code" style="width: 24em;">
<b>compile</b>           = "ethertest.c"

<b>lansegment</b> LAB1 {
    <b>lan-bandwidth</b>  = 10<b>Mbps</b>
    <b>lan-mtbf</b>       = 3600<b>sec</b>
    <b>lan-mttr</b>       = 60<b>sec</b>

    <b>x</b>=100, <b>y</b>=200
}

<b>host</b> budgie {
    <b>lan</b> <b>to</b> LAB1 {
        <b>nicaddr</b>   = 00:90:27:62:58:84
    }
}

<b>host</b> koala {
    <b>lan</b> <b>to</b> LAB1 {
        <b>nicaddr</b>   = 00:90:27:41:B0:BE
    }
}

<b>host</b> wombat {
    <b>lan</b> <b>to</b> LAB1 {
        <b>nicaddr</b>   = 00:A0:C9:AF:9E:81
    }
}
</div>

<p></p>

<h1>Defining WLAN interfaces</h1>

<p>
Nodes of all types may have one or more WLAN (wireless local-area network)
links.
Mobile nodes may <i>only</i> have WLAN links,
and accesspoints must have at least one WLAN link.
Link attribute names specific to WLAN links are prefixed with <code>wlan-</code>.
</p>

<p>
WLAN links are each owned by a node and are not "connected" to any
named endpoint.
Each WLAN link's Network Interface card (NIC) requires a
<a href="datatypes.php#nicaddr">NIC address</a>,
and this must be defined as a local attribute inside the WLAN's definition.
Consider the following topology file permitting two mobile computers to
communicate via an accesspoint (if all are within range):
</p>

<div class="code" style="width: 24em;">
<b>compile</b>        = "cafe.c"
<b>mapwidth</b>       = 700
<b>mapheight</b>      = 600

<b>accesspoint</b> toISP {
    <b>wlan</b> {
        <b>wlan-txpower</b> = 500<b>mW</b>
        <b>nicaddr</b>      = 00:0A:27:7D:41:C6
    }
}

<b>mobile</b> laptop1 {
    <b>wlan</b> {
        <b>nicaddr</b>      = 00:90:27:62:83:F5
    }
}

<b>mobile</b> laptop2 {
    <b>wlan</b> {
        <b>nicaddr</b>      = 00:90:27:34:B6:D8
    }
}
</div>

<?php require_once("cnet-footer.php"); ?>
