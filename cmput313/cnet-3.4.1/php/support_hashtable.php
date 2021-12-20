<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s support functions</h1>

<dl>

<dt>NAME</dt>
<dd>Hashtable support functions.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;
#include &lt;cnetsupport.h&gt;

<b>typedef void</b> *    HASHTABLE;
<b>extern</b>  HASHTABLE *hashtable_new(<b>int</b> nbuckets);
<b>extern  void</b>      hashtable_free(HASHTABLE ht);
<b>extern  void</b>      hashtable_add(HASHTABLE ht, <b>char</b> *name, <b>void</b> *item, size_t len);
<b>extern  void</b>      *hashtable_remove(HASHTABLE ht, <b>char</b> *name, size_t *len);
<b>extern  void</b>      *hashtable_find(HASHTABLE ht, <b>char</b> *name, size_t *len);
<b>extern  int</b>       hashtable_nitems(HASHTABLE ht);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
It is a common requirement of network protocols to manage items,
such as the elements of a routing table, with a hashtable.
This set of functions supports the maintenance of hashtables of arbitrary data.
A <i>cnet</i> node may have an unlimited number of such hashtables.
</p>

<p>
A new hashtable is firstly allocated by calling <code>hashtable_new</code>,
and should eventually be deallocated with a call to <code>hashtable_free</code>.
The opaque value returned by <code>hashtable_new</code> should be passed to all
other functions, to identify which hashtable is being used.
The required number of buckets is passed to <code>hashtable_new</code> -
indicating 0 buckets requests the default.
</p>

<p>
Items, of any type, may be added to a hashtable with <code>hashtable_add</code>.
The functions do not know what they are managing,
and so you must also provide the length, in bytes, of each added item.
A <i>copy</i> is made of all items added to a hashtable.
The number of items in a hashtable may be determined at any time
by calling <code>hashtable_nitems</code>.
</p>

<p>
Finding an item in a hashtable leaves the item in the hashtable,
and returns a pointer to the found item, and informs you of its length.
<code>hashtable_remove</code> deallocates the space occopied by a requested item.
<code>hashtable_free</code> deallocates the space occopied by all items and the
hashtable itself.
<p></dd>

<dt>EXAMPLE</dt>
<dd>A typical use of these functions is:
</p>

<p>
<pre>
    HASHTABLE   myht   = hashtable_new(0);
    TYPE        mydata, *myptr;
    size_t      len;

    hashtable_add(myht, "apple",  &amp;mydata, <b>sizeof</b>(mydata));
    hashtable_add(myht, "banana", &amp;mydata, <b>sizeof</b>(mydata));
        ....
    myptr = hashtable_find(myht, "orange", &amp;len);
    <b>if</b>(myptr) {
        ....
    }
    hashtable_free(myht);
</pre>
<p></dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
