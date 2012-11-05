<?php


$wants = "html";       
$views = array(
	        array( 'ext' => 'html', 'mimetypes' => array( 'text/html', 'application/xhtml+xml')),
        	array( 'ext' => 'ttl', 'mimetypes' => array( 'text/turtle'))
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
}
print "Human description";
