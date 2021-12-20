<?php require_once("cnet-header.php"); ?>

<h1 id="environment"><i>cnet</i>'s runtime environment</h1>

<p>
When initially configured and compiled,
<i>cnet</i> employs a number of string constants to define and
constrain its execution.
While it is anticipated that these "compiled-in" defaults will be reasonable,
there are occasions when you may wish to change one without having to
recompile all code.
</p>

<p>
At runtime,
<i>cnet</i> honours a number of Unix/Linux environment variables that
may override <i>cnet</i>'s default behaviour.
Running <i>cnet</i> with its
<a href="options.php#option-v"><code>-v</code></a>
option will report the environment values that are being used
(along with much other information).
</p>

<p>
Depending on which Unix/Linux shell you use
(type&nbsp;&nbsp;<span class="shell">shell&gt;&nbsp;</span><code>echo&nbsp;$SHELL</code>&nbsp;&nbsp;to find out),
environment variables may be set in one of two ways:
</p>

<ul>
<li> <b>for sh, bash, ksh, or zsh</b>:
<pre>   <span class="shell">shell&gt;&nbsp;</span><code>export CNETPATH="/usr/local/cnetlib"</code></pre>
	<p>
	</li>

<li> <b>for csh or tcsh</b>:
<pre>   <span class="shell">shell&gt;&nbsp;</span><code>setenv CNETPATH="/usr/local/cnetlib"</code></pre>
	<p>
	</li>
</ul>

<p>
<table class="thin" style="width: 100%;">
<tr>
    <th class="thin">variable name</th>
    <th class="thin">description</th>
</tr>

<tr>
    <td class="option0">CNETPATH</td>
    <td class="option0">
    The value of CNETPATH provides a colon-separated
    list of directory names where <i>cnet</i> will search for
    the &lt;cnet.h&gt; header file when compiling C protocol files.
    CNETPATH is also used to locate the Tcl/Tk source file (see CNETTCLTK,
    below), the GIF images displayed on the simulation map, and any
    extension modules specified with the
    <a href="options.php#option-x"><code>-x</code></a> option.
    </td>
</tr>
<tr>
    <td class="option1">CNETCPP</td>
    <td class="option1">
    The value of CNETCPP provides the full pathname of the C preprocessor
    used to preprocess <i>cnet</i> topology files (if necessary).
    If <i>gcc</i> is being used as the preprocessor, it will be invoked
    with its <code>-E</code> option to preprocess the topology files.
    </td>
</tr>

<tr>
    <td class="option0">CNETCC</td>
    <td class="option0">
    The value of CNETCC provides the full pathname of the C compiler used to
    compile the C99 protocol files.
    If <i>gcc</i> is being used as the compiler, it will be invoked
    with its <code>-std=c99</code> option to compile the source files.
    </td>
</tr>

<tr>
    <td class="option1">CNETLD</td>
    <td class="option1">
    The value of CNETLD provides the full pathname of the program used to
    link one or more object files to produce the final executable protocol. 
    </td>
</tr>

<tr>
    <td class="option0">CNETFILEEXT</td>
    <td class="option0">
    The value of CNETFILEEXT provides the filename extension of
    <i>cnet</i>'s (executable) shared object files.
    By default, this is "<code>.cnet</code>"
    </td>
</tr>

<tr>
    <td class="option1">CNETTCLTK</td>
    <td class="option1">
    The CNETTCLTK environment variable provides the filename of the Tcl/Tk
    source file that defines the look of <i>cnet</i>'s graphical interface.
    If the specified filename does not contain a slash (/) character,
    the file is sought via the value of CNETPATH (see above).
    Setting CNETTCLTK saves you from having to invoke <i>cnet</i> with
    its <a href="options.php#option-F"><code>-F</code></a> option.
    By default, this is "<code>cnet.tcl</code>"
    </td>
</tr>

<tr>
    <td class="option0">DISPLAY</td>
    <td class="option0">
    <i>cnet</i> uses Tcl/Tk under the X-window system on Unix/Linux
    to provide its graphical interface (not employed on macOS).
    Setting the DISPLAY environment variable permits <i>cnet</i>'s graphical
    interface to be redirected to another display/screen.
    </td>
</tr>

</table>

<?php require_once("cnet-footer.php"); ?>
