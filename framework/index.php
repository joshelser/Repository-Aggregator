<?php
// Library File
include 'lib/library.php';

$title = 'Home';
$subtitle = 'Welcome to '.$GLOBALS['SITE_NAME'].'!';
$content .= '
	<p>So you want to a framework to abstract away some stuff?</p>
	<p>This right here can do that easily for you. This is a framework for a coder. You\'re not dumb. You know how PHP\'s mysql_query function works. Why abstract that away?</p>
	<P>Acero-Framework is a lightweight PHP framework that makes site management easier. Remember when you found out the power of includes? This is essentially just that. To create a page, all you need is to include \'lib/library.php\' and throw in 3 functions at the bottom of the page.</P>
	<P>Acero-Framework simplifies page creation and management for you so you can focus on the coding that matters. You\'re site won\'t break if you change domain names and you can easily change all your pages if you switch the physical location of your webfolder. If you need something to add to all pages, Acero-Framework gives you the means to do it easily.</P>
	
	
';

/*
**   P U T    V A R S
**    O N    P A G E
*/
	head($title,$style,$scripts);
	body($header,$subtitle,$content,$navigation);
	foot($footer,$dbc);
?>
