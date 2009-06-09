<?php

/*
    Copyright 2009, All Rights Reserved.

    This file is part of Repository-Aggregator.

    Repository-Aggregator is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Repository-Aggregator is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Repository-Aggregator.  If not, see <http://www.gnu.org/licenses/>.

*/

require_once( 'lib/functions.lib.php' );

$framework = frameworkDir();

require_once( 'config/Config.class.php' );
require_once( $framework.'/lib/authentication.php' );

authorize();			/* Are you allowed here? */

// Library File
require_once( $framework.'/lib/library.php' );


$title = 'View Repositories';
$subtitle = Config::get( 'siteName' );
$content = '';
if( isset( $_GET['action'] ) ){
  switch( $_GET['action'] ){
  case 'added':
    $content .= '<h3>Repository Added Successfully</h3>';
    break;
    
  case 'watched':
    $content .= '<h3>Now Watching the New Repository</h3>';
    break;
  }  
}

$content .= '<div id="repositories">'."\n";

$repos = getUserRepositories( $_SESSION['userId'] ); /* Get all the user's repositories */

for( $i = 0; $i< count( $repos ); $i++ ) {
  $data = $repos[$i]->getData(); /* Get the data for the repository */

  $content .= <<<EOT
<div id="repo{$i}" class="repository">
  <h3 class="indent"><a href="viewCommits.php?id={$data[repoId]}">{$data[name]}</a></h3>
  <p><span class="descriptor indent">URL:</span> {$data[url]}</p>
  <p><span class="descriptor indent">Description:</span> {$data[description]}</p>
  <p><span class="descriptor indent">Date Added:</span> {$data[dateAdded]}</p>
</div>
EOT;

  if( $i != count( $repos ) -1 ){
    $content .= "\n<br/>\n<br/>\n";
  }
	else {
		$content .= "\n</div>\n";
	}
}
  

/*
**   P U T    V A R S
**    O N    P A G E
*/
	head($title,$style,$scripts);
	body($header,$subtitle,$content,$navigation);
	foot($footer,$dbc);


?>
