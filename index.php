<?php
// Library File
include 'lib/library.php';

$title = 'Home';
$subtitle = 'Welcome to '.$GLOBALS['SITE_NAME'].'!';
$content .= '
	<h1>This website is still under construction.</h1>
	
';

/*
**   P U T    V A R S
**    O N    P A G E
*/
	head($title,$style,$scripts);
	body($header,$subtitle,$content,$navigation);
	foot($footer,$dbc);
?>
