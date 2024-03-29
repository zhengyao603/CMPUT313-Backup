<?php require_once("cnet-header.php"); ?>

<h1 id="install">Downloading and installing <i>cnet</i></h1>

<p>
Download the most recent public release of <i>cnet</i>
<span style="font-size: 1.3em;">&nbsp;<a href="https://secure.csse.uwa.edu.au/run/cnet-download">from here</a>&nbsp;</span>
(11th March 2020).
</p>

<p>
The full distribution (about 2.6MB)
includes all source code, Makefiles, documentation,
and a few representative protocol examples.
</p>

<p>
<i>cnet</i>'s version number changes when a change to its source
code affects <i>cnet</i>'s execution semantics.
The version number does not change if cosmetic changes are made to the
source code, or if the documentation changes.
</p>

<p>
<b>NOTE:</b> on a multi-user Linux or macOS system
<i>cnet</i> only needs to be installed once.
Students on such systems do not need to install their own copies unless
they wish to modify and experiment with the <i>cnet</i> implementation
itself.
</p>

<p>
<i>cnet</i> is supported <i>only</i> on the following platforms:
</p>

<p style="text-align: center;">
Linux (kernel 2.4 onwards, ELF only), and
Apple's macOS (10.4 onwards).
</p>

<p>
In particular,
<b><i>cnet</i> does not run on Windows</b>.
Please do not ask for this to happen.
</p>

<p>
If you find these instructions confusing,
but eventually get <i>cnet</i> installed,
please email
<a href="mailto:Chris.McDonald@uwa.edu.au"><i>Chris.McDonald@uwa.edu.au</i></a>
with any suggestions on how the instructions could be clearer.
</p>

<hr>

<p>
The cnet network simulator (v<?php echo CNET_VERSION; ?>)
<br>
&copy; Copyright (C) 1992-onwards, Chris.McDonald@uwa.edu.au
<br>
Released under the GNU General Public License (GPL) version 2.
</p>

<hr>

<h1>
    <img src="images/install-linux.png" alt="Linux">
    &nbsp;Linux installation requirements
</h1>

<p>
To install <i>cnet</i> on a Linux system (with kernel v2.4 and beyond)
	you should be prepared and able to:
</p>

<p>
<ul>
<li> Be able to create a publicly-accessible directory (for a shared
installation) or a private directory (for a private installation).
The recommended publicly-accessible directory is
<code>/usr/local/lib/cnet</code> .
<p>
</li>

<li> Know the full pathname of your system's C compiler and standard linker.
<br>
If your system has the preferred <i>gcc</i>,
use <i>gcc</i> for both compiling and linking.
<p>
</li>

<li> Have <b>Tcl/Tk</b> (&ge;&nbsp;v8.5)
correctly installed and know where its header files and libraries are installed.
<p>

You'll need both
the Tcl/Tk <i>runtime</i> facilities (i.e. their shared libraries), and
the Tcl/Tk <i>development</i> facilities (i.e. their C header files).
Most "out-of-the-box" Linux distributions have the runtime facilities
installed, but not the development facilities.

<p>
If installing on a Linux distribution with uses pre-built packages,
(such as .rpm or .deb, etc),
you'll require both the <i>runtime</i> and the <i>development</i> packages
for both Tcl and Tk.
</p>

<p>
<img src="images/ubuntu.png" alt="ubuntu" title="ubuntu">
For example,
if installing on a Ubuntu Linux system, you can download and install
required packages with:

<pre>    <span class="shell">shell&gt;&nbsp;</span><code>sudo apt-get install tcl tcl-dev tk tk-dev libelf-dev</code></pre>
</li>
</ul>

<hr>

<h1>
    <img src="images/install-macos.png" alt="macOS">
    &nbsp;macOS installation requirements
</h1>

<p>
To install <i>cnet</i> on a macOS system (v10.4 onwards),
you should be prepared and able to:
</p>

<p>
<ul>

<li> Install <a href="https://developer.apple.com/xcode/">Apple's XCode</a>,
which provides the necessary C compiler and linker.
Ensure that you also download or enable XCode's command-line tools
(required for XCode v5.0 onwards).
<p>

<li> Install <a href="https://brew.sh">Homebrew</a>,
a very useful package manager for macOS.
Then use <code>brew</code> to download and install
<b>Tcl/Tk</b> (&ge;&nbsp;v8.6.10, as at Nov&nbsp;2019):
	<p>
<pre>   <span class="shell">shell&gt;&nbsp;</span><code>brew install tcl-tk</code></pre>
	<p>
    </li>
</ul>

<hr>

<h1>Installation on either Linux or macOS</h1>

<p>
<ol>
    <li> Unpack the distribution file:
	<p>
<pre>   <span class="shell">shell&gt;&nbsp;</span><code>tar zxvpf cnet-<?php echo CNET_VERSION; ?>.tgz</code></pre>
	<p>
    </li>

    <li> Change to the newly created directory:
	<p>
<pre>   <span class="shell">shell&gt;&nbsp;</span><code>cd cnet-<?php echo CNET_VERSION; ?></code></pre>
	<p>
    </li>

    <li> Edit the text-file named <code>Makefile</code>
	and possibly change the following constants for your system
	(though the provided defaults should be correct):
	<p>
<pre>   <code>PREFIX, BINDIR, LIBDIR, DOCDIR, and TCLTKVERSION</code></pre>
    <p>
    </li>

    <li> Edit the text-file named <code>src/preferences.h</code>
	and possibly change the full pathname of the C compiler and linker
	on your system (though the provided defaults should be correct).
	<p>
    </li>

    <li> Compile and link <i>cnet</i> for your system
	(there should be no errors or warnings):
	<p>
<pre>   <span class="shell">shell&gt;&nbsp;</span><code>make</code></pre>
	<p>
    </li>

    <li> (Perhaps as root) copy the <i>cnet</i> binary and supporting files
	to their required locations:
	<p>
<pre>   <span class="shell">shell&gt;&nbsp;</span><code>make install</code></pre>
	<p>
    </li>

    <li> To re-build it all, type:
	<p>
<pre>   <span class="shell">shell&gt;&nbsp;</span><code>make clean &amp;&amp; make &amp;&amp; make install</code></pre>
	<p>
    </li>

    <li> To install the PHP-based documentation on your system, type
	<p>
<pre>   <span class="shell">shell&gt;&nbsp;</span><code>make doc</code></pre>
	<p>
    </li>

</ol>

<hr>

<h1>Removing <i>cnet</i></h1>

<p>
From the directory where you built <i>cnet</i>, type:
<p>
<pre>    <span class="shell">shell&gt;&nbsp;</span><code>make uninstall</code></pre>
<p>

<hr>

<h1>Testing</h1>

<p>
There are some introductory examples
(such as may be used as student introductions to <i>cnet</i>)
in the <code>examples</code> directory.
A few of these examples are described in detail by making a
<a href="walkthrough.php">walkthrough</a> of the code.
</p>

<p>
These are the sort of things an academic staff member may set as
introductory exercises,
or to assist students to "get up to speed" quickly.
You should now be able to execute these examples from the command-line
with the commands:
</p>

<pre>
    <span class="shell">shell&gt;&nbsp;</span><code>cnet TICKTOCK   </code>
    <span class="shell">shell&gt;&nbsp;</span><code>cnet CLICK      </code>
    <span class="shell">shell&gt;&nbsp;</span><code>cnet STOPANDWAIT</code>
    <span class="shell">shell&gt;&nbsp;</span><code>cnet FLOODING1  </code>
</pre>

<p>
Each example has its own topology file defining the network to be simulated,
for example <code>CLICK</code> and <code>FLOODING1</code>.
</p>

<p>
When <i>cnet</i> appears to work,
the example files such as
<i>{TICKTOCK + ticktock.c},</i>
<i>{CLICK + click.c},</i>
<i>{KEYBOARD + keyboard.c},</i>
<i>{LINKSTATE + linkstate.c},</i> and
<i>{STOPANDWAIT + stopandwait.c}</i>
in the <code>examples</code> directory should all be placed in a system-wide
directory for everyone to copy and run.
</p>

<hr>

<h1>
    <img src="images/install-bsd.png" alt="BSD">
    <img src="images/install-netbsd.png" alt="NetBSD">
    <img src="images/install-sun.png" alt="Solaris">
    &nbsp;On older systems
</h1>

<p>
Previous versions of <i>cnet</i> compiled and ran successfully on:
</p>

<div style="margin-left: 2em;">
Solaris 2.x,
FreeBSD,
NetBSD (1.5 onwards),
DEC-OSF/1 (v4.0),
SunOS 4.1.x (welcome to the 21st century),
and
SGI IRIX (Rel. 5 or 6).
</div>

<p>
However, I no longer have access to these older systems,
All system-specific source code remains in the distribution,
so you may still have some success compiling and running
this version of <i>cnet</i>.
Please let me know.
</p>

<?php require_once("cnet-footer.php"); ?>
