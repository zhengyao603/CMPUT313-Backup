<?php require_once("cnet-header.php"); ?>

<h1>Attribute datatypes and their units</h1>

<p>
The specification of most attributes in the topology file
must be followed by an additional unit to
clarify or scale the units being used.
</p>

<ul>
<li> All <b>times</b> are stored internally
using the data type <code>CnetTime</code>,
and are measured in microseconds.
In the topology file, times are specified using integer values
followed by one of the suffixes -
<code>usec</code>, <code>msec</code> or <code>s</code>.
<p>

<li> All <b>data sizes</b> are stored internally as an integer number of bytes.
In the topology file, data sizes are specified by an integer value
followed by one of the suffixes -
<code>bytes</code>, <code>Kbytes</code>, <code>KB</code>, or <code>MB</code>.
The multiplier of <code>KB</code> means 1024 bytes. 
The multiplier of <code>MB</code> means (1024*1024) bytes. 
<p>

<li> Link <b>bandwidths</b> are stored internally as an integer number of
bits-per-second.
In the topology file, bandwidths are specified by an integer value
followed by one of the suffixes -
<code>bps</code>, <code>Kbps</code>, or <code>Mbps</code>.
The multiplier of <code>Kbps</code> means 1000 bits-per-second.
The multiplier of <code>Mbps</code> means (1000*1000) bits-per-second. 
<p>

<li> Link <b>frequencies</b> for <code>LT_WLAN</code> links are
stored internally as a floating-point number of gigahertz.
In the topology file, frequencies are specified with a floating-point value
followed by one of the suffixes -
<code>MHz</code> or <code>GHz</code>.
The multiplier of <code>MHz</code> means (1000*1000) Hertz.
The multiplier of <code>GHz</code> means (1000*1000*1000) Hertz.
<p>

<li> All <b>wireless power</b> attributes are
stored internally as a floating-point number of decibel-milliwatts.
In the topology file, power attributes are specified with a floating-point value
followed by one of the suffixes -
<code>dBm</code> or <code>mW</code>,
where <code>mW</code> stands for milliWatts which are related to
decibel-milliwatts by the relationship:
<code>dBm&nbsp;=&nbsp;10*log10(Watts / 0.001)</code>
<p>

<li> <b>Boolean</b> attributes may take on the values
<code>true</code>, <code>false</code>,
and <code>toggle</code> (to change any value from <i>cnet's</i> default).
<p>

<li> <b>Strings</b> are enclosed within double quotation characters.
A double quotation character may be included in a string by preceding it
with a backslash character.
<p>

<li> <b>Probabilities</b> specify a uniform distribution,
with their value being the <code>log-base-2</code>
of the chance of failure (yes, this is ugly).
In the topology file,
a probability attribute may specify
that an event occurs with a likelihood of (2 to the power P),
where P is a small integer.
For example, a probably of 3 specifies a probability of
1 in 8 (2 to the power 3).
A probability of <code>0</code> (the default) means that the event will not occur.
</ul>

<?php require_once("cnet-footer.php"); ?>
