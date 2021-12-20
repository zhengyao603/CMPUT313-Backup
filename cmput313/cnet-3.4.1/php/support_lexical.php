<?php require_once("cnet-header.php"); ?>

<h1><i>cnet</i>'s support functions</h1>

<dl>

<dt>NAME</dt>
<dd>Lexical support functions.
<p></dd>


<dt>SYNOPSIS</dt>
<dd>
<div class="code">
#include &lt;cnet.h&gt;
#include &lt;cnetsupport.h&gt;

#define  CHAR_COMMENT    '#'
#define  CHAR_DQUOTE     '"'

<b>extern  char</b>  **tokenize(<b>char</b> *line, <b>int</b> *ntokens, <b>const char</b> *separators);
<b>extern  void</b>  free_tokens(<b>char</b> **tokens);
<b>extern  void</b>  remove_comment(<b>char</b> *line);
<b>extern  void</b>  remove_nl(<b>char</b> *line);
</div>
<p>
</dd>


<dt>DESCRIPTION</dt>
<dd>
While attributes to define <i>cnet</i>'s simulations are provided in topology
files, we often need to define the required execution of our own protocols
as well.  Command-line parameters may be passed to each node's
<code>EV_REBOOT</code> event handler,
but providing many parameters this way can be cumbersome.
Instead, we often prefer to specify the parameters of a large protocol
in an external configuration file that is initially read by each node.
These lexical support functions assist with the basic parsing of such files.
</p>

<p>
<code>tokenize</code> accepts a line of characters and breaks that
string into a number of tokens that were separated by any of a set
of indicated characters.
Any initial separators, at the beginning of the line, are first skipped.
A token appearing within <code>CHAR_DQUOTE</code> characters
may contain any of the separators.
</p>

<p>
<code>tokenize</code> returns a <code>NULL</code>-terminated vector of strings
(tokens), with the number of tokens reported in <code>ntokens</code>.
The result returned by <code>tokenize</code> should eventually
be passed to <code>free_tokens</code> to deallocate memory.
</p>

<p>
The functions <code>remove_comment</code> and <code>remove_nl</code>
simply replace the first instance of <code>CHAR_COMMENT</code>,
or <code>\n</code> or <code>\r</code>,
with the <code>NUL</code> byte.
<p></dd>

<dt>EXAMPLE</dt>
<dd>A typical use of these functions is:
<p>
<div class="code">
FILE  *fp = fopen(filename, "r");

<b>if</b>(fp) {
    <b>char</b>  line[BUFSIZE], **tokens;
    <b>int</b>   ntokens;

    <b>while</b>(fgets(line, <b>sizeof</b>(line), fp) != NULL) {
	remove_comment(line);
	tokens  = tokenize(line, &amp;ntokens, " \t");
	<b>for</b>(<b>int</b> n=0 ; n&lt;ntokens ; ++n) {
	    <i>// access or copy tokens[n] ...</i>
	}
	free_tokens(tokens);
    }
    fclose(fp);
}
</div>
<p>
</dd>

</dl>

<?php require_once("cnet-footer.php"); ?>
