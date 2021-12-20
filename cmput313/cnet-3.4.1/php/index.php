<?php require_once("cnet-header.php"); ?>

<h1>The <i>cnet</i> network simulator (v<?php echo CNET_VERSION; ?>)</h1>

<i>cnet</i> enables development of and experimentation with a variety
of data-link layer,
network layer,
and transport layer networking protocols in networks consisting of
any combination of
wide-area-networking (WAN),
local-area-networking (LAN), or
wireless-local-area-networking (WLAN) links.

<p>
<i>cnet</i> runs on Linux (v2.4 onwards) and Apple's macOS (v10.4 onwards).<br>
<i>cnet</i> <i>does not run natively</i> on Windows,
but you will probably have success using Windows Subsystem for Linux (WSL) on WIndows-10.
</p>

<p>
The most up-to-date public version of this documentation remains at
    <a href="http://www.csse.uwa.edu.au/cnet/">www.csse.uwa.edu.au/cnet/</a>.
</p>

<div style="line-height: 1.4em;">

<table><tr>
<td style="vertical-align: top;">
<h1>Getting started:</h1>
<ul>
    <li> <a href="introduction.php">an introduction to <i>cnet</i></a> (with screenshots).</li>
    <li> <a href="themodel.php">the simulation model</a>.</li>
    <li> <a href="topology.php">topology files</a>.</li>
    <li> <a href="attributes.php">global, node, and link attributes</a>.</li>
    <li> <a href="eventdriven.php">the event driven programming style</a>.</li>
    <li> <a href="walkthrough.php">a protocol walkthrough</a>.<p></li>

    <li> <a href="faq.php" style="font-size: 1.4em;">Frequently Asked Questions</a>.<p></li>

    <li> <a href="install.php">Downloading and installing <i>cnet</i></a>.</li>
    <li> <a href="changelog.php">Changelog</a>.</li>
</ul>
</td>

<td style="vertical-align: top;">
<h1>Greater detail:</h1>
<ul>
    <li> <a href="api.php">the core Application Programming Interface</a></li>
    <li> <a href="supportapi.php">the support Application Programming Interface</a></li>
    <li> <a href="options.php">command line options</a>.</li>
    <li> <a href="datatypes.php">datatypes defined in &lt;cnet.h&gt;</a>.</li>
    <li> <a href="datastructures.php">data structures defined in &lt;cnet.h&gt;</a>.</li>
    <li> <a href="units.php"> attribute datatypes and their units</a>.</li>

    <li> <a href="lans.php">local area networks (LANs)</a>.</li>
    <li> <a href="wlans.php">wireless networks (WLANs) and mobile nodes</a>.</li>

    <li> <a href="compilation.php">compilation strings and extension modules</a>.</li>
    <li> <a href="environment.php">runtime environment variables</a>.</li>
    <li> <a href="tracing.php">tracing execution</a>.</li>
    <li> <a href="drawframes.php">drawing datalink frames</a>.</li>
</ul>
</td>
</tr></table>

</div>


<h1>Using <i>cnet</i> in education</h1>

<i>cnet</i> has been specifically developed for, and is used in,
undergraduate computer networking courses taken
by thousands of students worldwide since 1991.
At The University of Western Australia,
<i>cnet</i> is used primarily in the undergraduate unit
<a href="http://handbooks.uwa.edu.au/unitdetails?code=CITS3002">CITS3002 Computer Networks</a>.

<p>
If you decide to use <i>cnet</i> in the teaching of an undergraduate course,
or need some more info on how to, <i>please</i> let me know.
I'd like to keep a record of sites using <i>cnet</i> and the
types of examples and projects being attempted.
I'll also be able to keep you informed of updates.
</p>

<p>
Please appreciate that there are thousands of students worldwide
using <i>cnet</i>.
I am unable to respond to individual questions about <i>cnet</i>,
unless they are from students enrolled in a course that I'm presenting.
In particular, I will not answer homework or assignment questions.
Please ask <i>your</i> professor or instructor.
</p>

<h1>Acknowledgments</h1>

The following people have generously offered
suggestions,
bug fixes,
and pieces of code,
as <i>cnet</i> has developed over the years.
A big thanks to them all:

<p style="font-size: 0.9em; margin: 1em;">
David Adams (while at UWA),
Dr Greg Baur (University of Western Kentucky),
Prof. Bruce Elenbogen (University Michigan-Dearborn),
Mark Davies (University of Wellington, New Zealand),
Dr Rowan Davies (while at UWA),
Peter Elliott (Univ. of Alberta),
Amer Filipovic (while at UWA),
Dr Matthew Heinsen Egan (UWA),
Prof. John Hine (University of Wellington, New Zealand),
Prof. Chris Johnson (The Australian National University),
Jeremy Kerr (while at UWA),
Prof. David Kotz (Dartmouth College),
Prof. David Laverell (Calvin College, Michigan),
A/Prof. Phil MacKenzie (Boise State University, Idaho),
Ryan Oakley (while at UWA),
Prof. Jeff Ondich (Carleton College, Minnesota),
Dr Asad Pirzada (while at UWA),
Dr Chris Pudney (while at UWA),
Prof Simon Read (St. Mary's College of Maryland),
Dr Mike Robins (while at UWA),
Dr Michael Rogers (Tennessee Technological University),
Dean Scarff (while at UWA),
Prof. James Wilkinson (College of Charleston, South Carolina),
and my 3500+ undergraduate students at The University of Western Australia
and Dartmouth College who have always been able to find the <i>last bug</i>.
</p>

<table><tr>
<td style="padding: 6px;">
    <i>cnet</i> development has been supported by an ACM-SIGCSE
    <a href="http://sigcse.org/sigcse/programs/special">Special Project Grant</a>
<p>
    <img src="images/sigcse.png" alt="sigcse">
</td>

<td style="padding: 6px;">
and an Australian <a href="https://auc.edu.au">Apple University Consortium</a> Scholarship.
<p>
    <img src="images/auc.png" alt="auc">
</td>
</tr></table>

<?php require_once("cnet-footer.php"); ?>
