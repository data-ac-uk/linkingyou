<?php


$wants = "html";       
$views = array(
	        array( 'ext' => 'html', 'mimetypes' => array( 'text/html', 'application/xhtml+xml')),
        	array( 'ext' => 'ttl', 'mimetypes' => array( 'text/turtle', 'application/rdf+xml'))
);

if( isset( $_SERVER["HTTP_ACCEPT"] ) )
{
        $opts = preg_split( "/\s*,\s*/", $_SERVER["HTTP_ACCEPT"] );
        $o = array( "text/html"=>0.1 , "application/rdf+xml"=>0 );
        foreach( $opts as $opt)
        {
                $optparts = preg_split( "/;/", $opt );
                $mime = array_shift( $optparts );
                $o[$mime] = 1;
                foreach( $optparts as $optpart )
                {
                        list( $k,$v ) = preg_split( "/=/", $optpart );
                        if( $k == "q" ) { $o[$mime] = $v; }
                }      
        }      
        $score = 0.1;
        foreach( $views as $view )
        {
                foreach( $view['mimetypes'] as $mimetype )
                {
                        if( @$o[$mimetype] > $score )
                        {
                                $score=$o[$mimetype];
                                $wants = $view["ext"];
                        }      
                }     
        }
}

if( $wants == "ttl" )
{
	header( "Location: http://openorg.ecs.soton.ac.uk/linkingyou/linkingyou.ttl" );
	exit;
}

error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<!DOCTYPE html>
<html lang="en-uk">
    <head>
        <meta charset="utf-8">
        <title>Linking-You Vocabulary</title>
        <style>
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td { margin:0; padding:0; } table { border-collapse:collapse; border-spacing:0; } fieldset,img { border:0; } address,caption,cite,code,dfn,em,strong,th,var { font-style:normal; font-weight:normal; } ol,ul { list-style:none; } caption,th { text-align:left; } h1,h2,h3,h4,h5,h6 { font-size:100%; font-weight:normal; } q:before,q:after { content:''; } abbr,acronym { border:0; }
html {
	background-color: #333;
	padding: 40px;
}
body {
	background-color: #999;
	padding: 0 20px 20px 20px;
	border: solid 4px #000;
	font-family: sans-serif;
}
h1 { 
	font-size: 300%;
	position: relative;
	border: solid 4px #000;
	padding: 12px;
	background-color: #666666;
	color: #fff;
	display: inline-block;
	left: -40px;
	top: -20px;
        box-shadow: 4px 10px 10px #000;

	-webkit-transform: rotate(-2deg); 
	-moz-transform: rotate(-2deg); 
	-o-transform: rotate(-2deg);
	-ms-transform: rotate(-2deg); 
}	
h2 {
	background-color: #ff9933;
	margin-left: -50px;
	margin-top: 1em;
	margin-bottom: 0.5em;
	padding: 5px 10px 5px 10px;
	border-right: solid 2px #000;
	border-bottom: solid 2px #000;
	font-size: 150%;
	display: inline-block;
        box-shadow: 2px 5px 8px #000;

	-webkit-transform: rotate(-5deg); 
	-moz-transform: rotate(-5deg); 
	-o-transform: rotate(-5deg);
	-ms-transform: rotate(-5deg); 
}
dl, p {
	margin-top: 0.5em;
	margin-bottom: 0.5em
}
dt {
	border-right: solid 2px #000;
	border-bottom: solid 2px #000;
	display: inline-block;
	padding: 4px;
	background-color: #666666;
	color: #fff;
        box-shadow: 1px 3px 4px #333;

	-webkit-transform: rotate(-1deg); 
	-moz-transform: rotate(-1deg); 
	-o-transform: rotate(-1deg);
	-ms-transform: rotate(-1deg); 
}	
dd {
	background-color: #c9c9c9;
	border-right: solid 2px #000;
	padding: 22px 4px 4px 4px;
	border-bottom: solid 2px #000;
	margin-left: 20px;
	margin-top: -16px;
	margin-bottom: 10px;
        box-shadow: 1px 3px 4px #333;
}
.uri {
	margin-top: 0.5em;
	font-size: 80%;
}

em {
	font-style: italic;
}
.code {
	white-space: pre;
	font-family: monospace;
}
strong {
	font-weight: bold;
}
li { 
	list-style: square;
	margin-left: 3em;
	margin-bottom: 0.5em;
}
a {
	color: #8B0000;
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
        </style>
    </head>
    <body>
        <h1>Linking-You RDF Vocabulary</h1>

<p>Terms which link an organisation to common webpages, such as a contact page or "about" page.</p>      

<p>A few changes have been made to terms to make them useful outside academia. It is generally expected that the targets will be HTML documents, but in some cases it may be other formats, such as a PDF prospectus.</p>

<p>Namespace: <strong>http://purl.org/linkingyou/</strong></p>

<p>This vocublary is based on the 
<a href="http://lncn.eu/toolkit">Linking-You project</a> performed by those clever chaps at 
Lincoln University. This mapping <a href='http://linkingyou.blogs.lincoln.ac.uk/2012/11/20/linking-you-rdf-vocabulary/'>has been endorsed by the Lincoln team</a>. The RDF version of the linking-you toolkit was created by <a href="http://users.ecs.soton.ac.uk/cjg/">Christopher Gutteridge</a>.</p>

<p>View: <a href='http://openorg.ecs.soton.ac.uk/linkingyou/linkingyou.ttl'>Linking-You Vocabulary</a> (RDF Turtle).</p>
<p>Skip to:</p>
<ul>
<li><a href="#core">Core page types</a></li>
<li><a href="#extended">Additional page types</a></li>
<li><a href="#academia">Academic page types (not related to education)</a></li>
<li><a href="#education">Page types related to education</a></li>

<h2>Example of Use</h2>
<div class='code'>
&lt;http://id.southampton.ac.uk/&gt; 
   foaf:homepage &lt;http://www.soton.ac.uk/&gt; ;
   lyou:events &lt;http://www.events.soton.ac.uk/&gt; ;
   lyou:research &lt;https://www.soton.ac.uk/research/index.shtml&gt; .
</div>

<h2>Changelog</h2>
<h3>2013-01-29</h3>
<ul>
<li>Added comments to clarify several fields</li>
<li>Added legal-ethics</li>
<li>Split postgraduate terms into postgraduate-research and postgraduate-taught</li>
</ul>


<?php
render_vocab();
?>
    </body>
</html>
<?php

exit;

function render_vocab()
{
	require_once( "arc2/ARC2.php" );
	require_once( "Graphite/Graphite.php" );
	$graph = new Graphite();
	$graph->load( "http://purl.org/linkingyou/" );
	$graph->ns( "lyou", "http://purl.org/linkingyou/" );
	
	print "<a name='core'></a><h2>Core Page Types</h2>";
	render_subject( $graph->resource("http://purl.org/linkingyou/core" ));
	print "<a name='extended'></a><h2>Additional Page Types</h2>";
	render_subject( $graph->resource("http://purl.org/linkingyou/extended" ));
	print "<a name='academia'></a><h2>Academic Page Types</h2>";
	print "<p>These page types are not strictly limited to universities. Non-academic organisations may do research or have converences.</p>";
	render_subject( $graph->resource("http://purl.org/linkingyou/academia" ));
	print "<a name='education'></a><h2>Education Page Types</h2>";
	render_subject( $graph->resource("http://purl.org/linkingyou/education" ));
}

function render_subject( $subject )
{
	$list = $subject->all( "-dcterms:subject" );
	print "<dl>";
	foreach( $list as $property )
	{
		render_property( $property );
	}
	print "</dl>";
}


function render_property( $property )
{
	print "<dt>Property: ".$property->g->shrinkURI( $property )."</dt>";
	print "<dd>";
	print "<em>".$property->label()."</em>";
	if( $property->has( "rdfs:comment" ) )
	{
		print " - ".$property->getString( "rdfs:comment" );
	}
	print "<div class='uri'>URI: ".$property->toString()."</div>";
	print "</dd>";
}
