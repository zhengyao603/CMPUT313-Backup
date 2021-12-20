<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s Application Programming Interface</h1>

<dl>

<dt>NAME</dt>
<dd>TCLTK - access <i>cnet</i>'s Tck/Tk windowing interface
</dd>
<p>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;

<b>void</b> TCLTK(<b>const char</b> *fmt, ...);
<b>void</b> *TCLTK_interp(<b>void</b>);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
When running as a GUI-based application,
<i>cnet</i> performs all drawing and management of its GUI
using the Tcl/Tk toolkit.
This enables you to focus on writing and evaluating protocols without
having to worry about the GUI.
However, there are many occasions when you may wish to interact with, or
extend, <i>cnet</i>'s GUI.
The <code>TCLTK</code> function allows you to do this in a simplified manner.
</p>

<p>
The arguments to <code>TCLTK</code> are similar to those of C's <code>printf</code>,
and the standard format specifiers may be provided in the formatting string.
The Tcl/Tk variable <code>$map</code> is available for you to draw things on
the main simulation map.
For example, the call:
</p>

<p>
<div class="code">
TCLTK("$map create rectangle %d %d %d %d -fill yellow",
                x, x+WIDTH, y, y+HEIGHT);
</div>
</p>

<p>
will draw a yellow rectangle on the simulation map.
</p>

<p>
If you <i>really</i> know what you are doing,
you may wish to call 'raw' Tcl or Tk library functions from within protocol
code (perhaps to provide detailed mapping).
The single Tcl/Tk interpreter may be accessed by calling
<code>TCLTK_interp()</code>,
passing its returned value to Tcl or Tk library functions.
</p>
</dd>

<dt>NOTE</dt>
<dd>
<i>cnet's</i> physical coordinates are measured in metres,
but coordinates in Tcl/Tk are measured in pixels.
You may use
<code>CNET_get_mapscale()</code> and <code>CNET_get_mapmargin()</code>
to convert between the two:
</p>

<p>
<pre>    <code>#define M2PX(metres)  ((int)(CNET_get_mapmargin() + (metres) / CNET_get_mapscale())</code></pre>
</p>
</dd>

<dt>SEE ALSO</dt>
<dd>
The extensive features of Tcl/Tk are not documented with <i>cnet</i>,
and so you may like to read Tcl/Tk's
<a href="http://www.tcl.tk/doc/">online documentation</a>.
<p></dd>

</dl>
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
