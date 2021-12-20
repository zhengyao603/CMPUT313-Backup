<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s support functions</h1>

<dl>

<dt>NAME</dt>
<dd>Queueing support functions.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;
#include &lt;cnetsupport.h&gt;

<b>typedef void</b> *  QUEUE;
<b>extern</b>  QUEUE   queue_new(<b>void</b>);
<b>extern  void</b>    queue_free(QUEUE q);
<b>extern  void</b>    queue_add(QUEUE q, <b>void</b> *item, size_t len);
<b>extern  void</b>    *queue_remove(QUEUE q, size_t *len);
<b>extern  void</b>    *queue_peek(QUEUE q, size_t *len);
<b>extern  int</b>     queue_nitems(QUEUE q);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
It is a very common requirement of network protocols to manage items,
such as packets, in a first-in-first-out manner.
This set of functions supports the maintenance of queues of arbitrary data.
A <i>cnet</i> node may have an unlimited number of such queues.
</p>

<p>
A new queue is firstly allocated by calling <code>queue_new</code>,
and should eventually be deallocated with a call to <code>queue_free</code>.
The opaque value returned by <code>queue_new</code> should be passed to all
other functions, to identify which queue is being used.
</p>

<p>
Items, of any type, may be added to a queue with <code>queue_add</code>.
The functions do not know what they are queueing,
and so you must also provide the length, in bytes, of each added item.
A <i>copy</i> is made of all items added to a queue.
The number of items in a queue may be determined at any time
by calling <code>queue_nitems</code>.
</p>

<p>
Removing the oldest (head) item from a queue returns a pointer to the
previously allocated copy, which you should use and, eventually, free.
Peeking at the head of a queue does not remove the item.
<p></dd>

<dt>EXAMPLE</dt>
<dd>A typical use of these functions is:
</p>

<p>
<pre>
    QUEUE     myq;
    MYTYPE    mydata, *myptr;
    size_t    len;

    myq     = queue_new();
    queue_add(myq, &amp;mydata, <b>sizeof</b>(mydata));
    .....
    queue_add(myq, &amp;mydata, <b>sizeof</b>(mydata));
    .....
    <b>if</b>(queue_nitems(myq) &gt; 0) {
        myptr   = queue_remove(myq, &amp;len);
        .....
        free(myptr);
    }
    .....
    queue_free(myq);
</pre>
<p></dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
