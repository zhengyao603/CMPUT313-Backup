<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s support functions</h1>

<dl>

<dt>NAME</dt>
<dd>Vector support functions.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;
#include &lt;cnetsupport.h&gt;

<b>typedef void</b> *  VECTOR;
<b>extern</b>  VECTOR  vector_new(<b>void</b>);
<b>extern  void</b>    vector_free(VECTOR q);
<b>extern  void</b>    vector_append(VECTOR v, <b>void</b> *item, size_t len);
<b>extern  void</b>    vector_replace(VECTOR v, <b>int</b> position, <b>void</b> *item, size_t len);
<b>extern  void</b>    *vector_remove(VECTOR v, <b>int</b> position, size_t *len);
<b>extern  void</b>    *vector_peek(VECTOR v, <b>int</b> position, size_t *len);
<b>extern  int</b>     vector_nitems(VECTOR v);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
It is a very common requirement of network protocols to manage a vector
of heterogenous-sized items.
These functions support the maintenance of vectors of arbitrary data.
Each data item may be of a different datatype and a different size and, thus,
these functions should not be used in preference to a standard array in C.
A <i>cnet</i> node may have an unlimited number of such vectors.
</p>

<p>
A new vector is firstly allocated by calling <code>vector_new</code>,
and should eventually be deallocated with a call to <code>vector_free</code>.
The opaque value returned by <code>vector_new</code> should be passed to all
other functions, to identify which vector is being used.
</p>

<p>
Items, of any datatype and length,
may be appended to a vector with <code>vector_append</code>.
The functions do not know what they are storing,
and so you must also provide the length, in bytes, of each appended item.
A <i>copy</i> is made of all items appended to a vector.
The number of items in a vector may be determined at any time
by calling <code>vector_nitems</code>.
The first item in a vector is in position <code>0</code>.
</p>

<p>
An existing item in a vector may be replaced by a new item
by calling <code>vector_replace</code> and providing the new length.
Removing an item from a vector returns a pointer to the
previously allocated copy, which you should use and, eventually, free.
All remaining items in the vector "slide-down" by one position to fill the
hole created by the removal.
Peeking at any item of a vector does not remove the item.
<p></dd>

<dt>EXAMPLE</dt>
<dd>A typical use of these functions is:
<p>

<p>
<pre>
    VECTOR    myv;
    MYTYPE1   mydata1, *myptr1;
    MYTYPE2   mydata2, *myptr2;
    size_t    len;
    <b>int</b>       n;

    myv     = vector_new();
    vector_append(myv, &amp;mydata1, <b>sizeof</b>(mydata1));
    .....
    vector_append(myv, &amp;mydata2, <b>sizeof</b>(mydata2));
    .....

    n = vector_nitems(myv);
    <b>while</b>(n &gt; 0) {
        (<b>void</b>)vector_peek(myv, 0, &amp;len);
        <b>if</b>(len == <b>sizeof</b>(mydata1)) {
            myptr1   = vector_remove(myv, 0, &amp;len);
            .....
            free(myptr1);
        }
        <b>else</b> {
            myptr2   = vector_remove(myv, 0, &amp;len);
            .....
            free(myptr2);
        }
        --n;
    }
    .....
    vector_free(myv);
</pre>
<p></dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
