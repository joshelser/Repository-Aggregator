<?php
require_once( 'config/config.class.php' );

// Library File
include 'framework/lib/library.php';


$title = 'Home';
$subtitle = $GLOBALS['SITE_NAME'];
$content .= '';

/*
**   P U T    V A R S
**    O N    P A G E
*/
	head($title,$style,$scripts);
	body($header,$subtitle,$content,$navigation);
	foot($footer,$dbc);
?>
