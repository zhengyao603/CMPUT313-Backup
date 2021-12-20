<?php require_once("cnet-header.php"); ?>

<h1>Drawing datalink frames in <i>cnet</i></h1>

<p>
<i>cnet</i> can present a limited visualisation of datalink
frames traversing the Physical Layer of any <code>LT_WAN</code> link.
Using just colours and lengths, it is possible to display both data and
acknowledgment frames, and the contents of some of their fields.
In combination, these features may be used to debug
implementations of Data Link Layer protocols.
</p>

<p>
You may view a <code>LT_WAN</code> link's frames by clicking the
right mouse button (control-click on Macintoshes) on the link.
Frames simply move from left-to-right or right-to-left until
they reach their destination.
If the frame becomes lost,
because the link's <code>probframeloss</code> attribute is non-zero,
only the frame's silhouette (an all white frame) will reach the destination.
If the frame becomes corrupted,
because the link's <code>probframecorrupt</code> attribute is non-zero,
a lightning bolt appears and
only a singed (all grey) frame will reach the destination.
Of course, both data and acknowledgment frames may be lost and corrupted.
<p>
Below, we see a selective-repeat protocol experiencing
frame loss (the upper ghostly white data frame number 5) and
frame corruption (the singed grey data frame number 3),
while other data and acknowledgment frames are also being exchanged.
</p>

<img src="images/drawframes.png" alt="drawframes">

<p>
As with most activities in <i>cnet</i>, frames are drawn using an
event-driven approach.
If of interest, the <i>cnet</i> event <code>EV_DRAWFRAME</code> is delivered
to the running protocol when <i>cnet</i> needs to know how to draw a frame.
<i>cnet</i> has no knowledge of the format of the data frames it is delivering,
and so the protocol writer must indicate which colours, field lengths,
and strings are to be used to draw each frame.
<i>cnet</i> defines the <code>CnetDrawFrame</code> datatype which provide
C string constants to request colours,
such as <code>"red", "blue", ...</code>.
The colours and lengths (in pixels) of up to 16 fields of each frame
may be supplied.
</p>

<p>
You may also request that a short text string,
up to <code>DRAWFRAME_TEXTLEN</code> (=16) bytes in length,
be drawn (centred) on each animated frame.
<i>cnet</i> will only deliver the <code>EV_DRAWFRAME</code> event to the
protocol once per frame, and the protocol is not, itself,
responsible for drawing or moving each frame.
This enables you to concentrate on writing the protocol,
not any visualisation.
</p>

<hr>

<p>
To request that data frames are drawn according to your own (limited) design,
register an event handler to receive the <code>EV_DRAWFRAME</code> event
(typically in your <code>EV_REBOOT</code> handler):
</p>

<div class="code">
<b>void</b> reboot_node(CnetEvent ev, CnetTimerID timer, CnetData data)&nbsp;
{
    .....
    CHECK(CNET_set_handler( EV_DRAWFRAME, draw_frame, 0));
    .....
}
</div>

<p>
Finally, define an event handler to receive the <code>EV_DRAWFRAME</code> event.
<i>cnet</i> passes to the handler, in the <code>CnetData</code> parameter,
a pointer to an instance of the <code>CnetDrawFrame</code> datatype.
This pointer provides access to colour, pixel (length), and text arrays,
as well as a pointer to the data frame to be drawn.
Again, <i>cnet</i> does not know the format of the protocol's data frame.
In the following example code,
the <code>FRAME</code> datatype, and its <code>kind</code> and <code>seq</code>
structure fields are known to the protocol, but not to <i>cnet</i>.
(If you're unsure of what's happening here,
just copy the first few lines this code, verbatim):
</p>

<div class="code">
<b>void</b> draw_frame(CnetEvent ev, CnetTimerID timer, CnetData data)
{
    CnetDrawFrame *df  = (CnetDrawFrame *)data;
    FRAME         *f   = (FRAME *)df-&gt;frame;

    <b>switch</b> (f-&gt;kind) {
    <b>case</b> DL_ACK:
        df-&gt;nfields    = 1;
        df-&gt;colours[0] = (f-&gt;seq == 0) ? "red" : "purple";
        df-&gt;pixels[0]  = 10;
        sprintf(df-&gt;text, "ack=%d", f-&gt;seq);
        <b>break</b>

    <b>case</b> DL_DATA:
        df-&gt;nfields    = 2;
        df-&gt;colours[0] = (f-&gt;seq == 0) ? "red" : "purple";
        df-&gt;pixels[0]  = 10;
        df-&gt;colours[1] = "green";
        df-&gt;pixels[1]  = 30;
        sprintf(df-&gt;text, "data=%d", f-&gt;seq);
        <b>break</b>
    }
}
</div>

<p>
This example code will draw each acknowledgment frame with 1 field,
10 pixels long,
and each data frame with 2 fields, totalling 40 pixels long.

Frames with a sequence number of <code>0</code> will
will be drawn in red;
other frames will be drawn in purple.
Data frames will have a second field, representing their payload,
drawn in green.
Both types of frames also request that a short text string,
displaying their sequence number,
be drawn (centred) on their animated frames
<p>

<dl>
<dt><b>RESTRICTIONS:</b></dt>
    <dd>
    <p>
    For best results, simulations drawing drames should run slowly.
    Because the protocol writer has control over the length (size) of the
    frames drawn,
    it is possible for frames moving in the same direction to be drawn on
    top of one another (although they will not overtake one another!).
    Clearly this doesn't represent reality too well.
    The following conditions provide a reasonable representation:
    </p>

    <p>
<div class="code">
<b>messagerate</b>          = 1000<b>ms</b>
<b>wan-propagationdelay</b> = 1500<b>ms</b>
</div>
</dd></dl>

<?php require_once("cnet-footer.php"); ?>
