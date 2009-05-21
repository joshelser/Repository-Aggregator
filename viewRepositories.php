<?php

require_once( 'lib/functions.lib.php' );

$framework = frameworkDir();

require_once( 'config/Config.class.php' );
require_once( $framework.'/lib/authentication.php' );

authorize();			/* Are you allowed here? */

// Library File
require_once( $framework.'/lib/library.php' );


$title = 'Home';
$subtitle = Config::get( 'siteName' );
$content = '<div id="repositories">'."\n";

$repos = getRepositories();

for( $i = 0; $i< count( $repos ); $i++ ) {
  $data = $repos[$i]->getData(); /* Get the data for the repository */

  $content .= <<<EOT
<div id="{$i}">
  <h3>{$data[url]}</h3>
  <p>Description: {$data[description]}</p>
  <p>Date Added: {$data[dateAdded]}</p>
</div>
EOT;
}
  

/*
**   P U T    V A R S
**    O N    P A G E
*/
	head($title,$style,$scripts);
	body($header,$subtitle,$content,$navigation);
	foot($footer,$dbc);


?>