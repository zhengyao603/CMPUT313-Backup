<?php require_once("cnet-header.php"); ?>

<h1><i>cnet's</i> core Application Programming Interface</h1>

Descriptions of <i>cnet's</i> core functions are available from here.
In each section functions are presented as C prototypes,
often with an example of their use.

<p>
<i>cnet</i> re-implements the standard C99 library functions
<code>printf</code>,
<code>puts</code>,
<code>putchar</code>,
<code>srand</code>, and
<code>rand</code>
so that each node may call these independently of all other nodes.

<p>
Most core functions return the integer <code>0</code> on success
and the integer <code>-1</code> on failure.
The most recent error status is reflected in
the global variable <code>cnet_errno</code>.
All values of <code>cnet_errno</code> will be instances of the
enumerated type <a href="datatypes.php#cneterror"><code>CnetError</code></a>.
Functions do not set the value of <code>cnet_errno</code> to
<code>ER_OK</code> if their execution was successful.

<p>
Note that these functions' names are prefixed with <code>CNET_</code>.
Errors may be reported to <code>stderr</code> with
<code>CNET_perror()</code> and their error message string accessed from
<code>cnet_errstr[(<b>int</b>)cnet_errno]</code>.
</p>

<b>Application Layer functions</b>
    <ul>
    <li><a href="application.php">overview</a>
    <li><a href="api_read_application.php">CNET_read_application</a>,&nbsp;
	<a href="api_write_application.php">CNET_write_application</a>,&nbsp;
	<a href="api_enable_application.php">CNET_enable_application</a>,&nbsp; and
	<a href="api_disable_application.php">CNET_disable_application</a>
    </ul>

<b>Physical Layer functions</b>
    <ul>
    <li><a href="physical.php">overview</a>
    <li><a href="api_write_physical.php">CNET_write_physical</a>,&nbsp;
	<a href="api_write_physical.php">CNET_write_physical_reliable</a>,&nbsp;
	<a href="api_write_direct.php">CNET_write_direct</a>,&nbsp;
	<a href="api_read_physical.php">CNET_read_physical</a>,&nbsp;
    <li><a href="api_carrier_sense.php">CNET_carrier_sense</a>,&nbsp;
	<a href="api_set_nicaddr.php">CNET_set_nicaddr</a>,&nbsp;
	<a href="api_parse_nicaddr.php">CNET_parse_nicaddr</a>,&nbsp; and
	<a href="api_format_nicaddr.php">CNET_format_nicaddr</a>
    </ul>

<b>WLAN and mobile node functions</b>
    <ul>
    <li><a href="wlans.php">overview</a>
    <li><a href="api_get_wlaninfo.php">CNET_get_wlaninfo</a>,&nbsp;
	<a href="api_set_wlaninfo.php">CNET_set_wlaninfo</a>,&nbsp;
	<a href="api_set_wlan_model.php">CNET_set_wlan_model</a>,&nbsp;
	<a href="api_set_wlanstate.php">CNET_get_wlanstate</a>,&nbsp;
	<a href="api_set_wlanstate.php">CNET_set_wlanstate</a>,&nbsp;
	<a href="api_set_wlancolour.php">CNET_set_wlancolour</a>,&nbsp;
	<a href="api_wlan_arrival.php">CNET_wlan_arrival</a>,&nbsp;
	<a href="api_get_position.php">CNET_get_position</a>,&nbsp;
	<a href="api_set_position.php">CNET_set_position</a>,&nbsp; and
	<a href="api_get_mapscale.php">CNET_get_mapscale</a>
    </ul>

<b>Event handling functions</b>
    <ul>
    <li><a href="api_set_handler.php">CNET_set_handler</a>&nbsp;,
	<a href="api_get_handler.php">CNET_get_handler</a>
    </li>
    <li>
	<a href="api_unused_debug_event.php">CNET_unused_debug_event</a>,&nbsp;
	<a href="api_unused_timer_event.php">CNET_unused_timer_event</a>
    </li>
    </ul>

<b>Checksum and CRC functions</b>
    <ul>
    <li><a href="api_checksums.php">CNET_IP_checksum</a>,&nbsp;
	<a href="api_checksums.php">CNET_ccitt</a>,&nbsp;
	<a href="api_checksums.php">CNET_crc16</a>,&nbsp; and
	<a href="api_checksums.php">CNET_crc32</a>
    </ul>

<b>Timer functions</b>
    <ul>
    <li><a href="timers.php">overview</a>
    <li><a href="api_start_timer.php">CNET_start_timer</a>,&nbsp;
	<a href="api_stop_timer.php">CNET_stop_timer</a>,&nbsp; and
	<a href="api_timer_data.php">CNET_timer_data</a>
    </ul>

<b>Tracing functions</b>
    <ul>
    <li><a href="tracing.php">overview</a>
    <li><a href="api_trace.php">CNET_trace</a>,&nbsp;
	<a href="api_trace_name.php">CNET_trace_name</a>,&nbsp;
	<a href="api_set_trace.php">CNET_set_trace</a>,&nbsp; and
	<a href="api_get_trace.php">CNET_get_trace</a>
    </ul>

<b>Node and per-link statistics</b>
    <ul>
    <li><a href="api_get_nodestats.php">CNET_get_nodestats</a> and
	<a href="api_get_linkstats.php">CNET_get_linkstats</a>
    </ul>

<b>Formatting 64-bit integers</b>
    <ul>
    <li><a href="api_format64.php">CNET_format64</a>,&nbsp;
	<a href="api_set_commas.php">CNET_set_commas</a>,&nbsp; and
	<a href="api_set_commas.php">CNET_get_commas</a>
    </ul>

<b>Miscellaneous functions</b>
    <ul>
<!--
    <li><a href="api_vflag.php">CNET_vflag</a>,&nbsp;and
	<a href="api_Wflag.php">CNET_Wflag</a>
    </li>
-->

    <li><a href="api_check_version.php">CNET_check_version</a>,&nbsp;
        <a href="api_getvar.php">CNET_getvar</a>,&nbsp;
	<a href="api_read_keyboard.php">CNET_read_keyboard</a>,&nbsp;
    </li>

    <li><a href="api_set_debug_string.php">CNET_set_debug_string</a>,&nbsp;
	<a href="api_set_LED.php">CNET_set_LED</a>,&nbsp;
	<a href="api_set_outputfile.php">CNET_set_outputfile</a>,&nbsp;
	<a href="api_set_time_of_day.php">CNET_set_time_of_day</a>&nbsp;
    </li>

    <li><a href="api_shmem.php">CNET_shmem</a>,&nbsp;and
	<a href="api_shmem.php">CNET_shmem2</a>&nbsp;
    </li>

    <li><a href="api_tcltk.php">TCLTK</a>,&nbsp;and
	<a href="api_tcltk.php">TCLTK_interp</a>
    </li>
    </ul>

<hr>

<h1>API restrictions</h1>

<ul>
<li> Calls to the functions:
<p>

<code>CNET_write_application</code><br>
<code>CNET_read_application</code><br>
<code>CNET_enable_application</code><br>
<code>CNET_disable_application</code><br>
<code>CNET_set_handler(EV_APPLICATIONLAYER,...)</code> and<br>
<code>CNET_set_handler(EV_KEYBOARDREADY,...)</code>
</p>

<p>
are only valid if called from a node of type
<a href="datatypes.php"><code>NT_HOST</code></a> or
<a href="datatypes.php"><code>NT_MOBILE</code></a>.
</p>
</li>

<li>
<p>
Function calls to either the Application or Physical Layers are invalid
when <i>cnet</i> is not running.
This can occur when the node is rebooting,
when the simulation is running under a windowing system,
is paused,
and a node's debug button is selected.
</p>
</li>

<li> Calls to the function:
<p>
<code>CNET_set_position</code>
</p>

<p>
are only valid if called from a node of node type
<a href="datatypes.php"><code>NT_MOBILE</code></a>.
</p>
</li>

<li> Calls to the functions:
<p>
<code>CNET_get_wlaninfo</code><br>
<code>CNET_set_wlaninfo</code><br>
<code>CNET_wlan_arrival</code><br>
</p>

<p>
are only valid for links of type <a href="datatypes.php"><code>LT_WLAN</code></a>.
</p>
</li>

<li>
<p>
Calls to the functions:
</p>

<p>
<code>CNET_set_nicaddr</code>
</p>

<p>
are only valid for links of type
<a href="datatypes.php"><code>LT_LAN</code></a> or
<a href="datatypes.php"><code>LT_WLAN</code></a>.
</p>

<p>
Furthermore, you
cannot set the attributes of link <code>0</code>, the <code>LOOPBACK</code> link,
nor set a NIC address to either the zero address, <code>00:00:00:00:00:00</code>,
or the broadcast address, <code>ff:ff:ff:ff:ff:ff</code>.
</p>
</li>
</ul>

<?php require_once("cnet-footer.php"); ?>
