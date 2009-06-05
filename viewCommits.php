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


$title = 'View Commits';
$subtitle = Config::get( 'siteName' );
$content = '';

$commits = getCommits( $_GET['id'] ); /* Get commits */

for( $i = 0; $i < count( $commits ); $i++ ) {
  $content .= <<<EOT
<div id="{$i}" class="commit">
  <h3>{$commits[$i][commitMessage]}</h3>
  <p>Commit: {$commits[$i][commitVal]}</p>
  <p>Date: {$commits[$i][commitDateTime]}</p>
	<div id="files{$i}">
		<p>Files changed:</p>
		
		<table class="filechange">
			<tr>
				<th>Filename:</th><th>Insertions:</th><th>Deletions:</th>
			</tr>
EOT;

	for( $j = 0; $j < count( $commits[$i][fileChanges] ); $j++ ){
		$content .= <<<EOT
				<tr>
					<td>{$commits[$i][fileChanges][$j][file]}</td>
					<td>{$commits[$i][fileChanges][$j][insertions]}</td>
					<td>{$commits[$i][fileChanges][$j][deletions]}</td>
				</tr>
EOT;
		}
	
	$content .= <<<EOT
		</table>
	</div>
</div>
<br />
EOT;

  if( $i != count( $commits ) -1 ){
    $content .= "\n<br/>\n";
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
