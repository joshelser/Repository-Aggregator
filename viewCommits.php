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
$content = '<div id="pagination" class="pagination"></div>'."\n<br /><br />";
$content .= '<div id="commits"></div>'."\n";
$content .= '<div id="paginationbottom" class="pagination"></div>'."\n";

$commits = getCommits( $_GET['id'] ); /* Get commits */

$js = 'var commits = new Array(';

for( $i = 0; $i < count( $commits ); $i++ ) {
	$js .= ' { "commitMessage": "'. addslashes( $commits[$i]['commitMessage'] ).'",
						 "commitVal": "'. $commits[$i]['commitVal'] .'",
						 "commitDateTime": "'. $commits[$i]['commitDateTime'] .'",
						 "filechanges": new Array( ';
	
	for( $j = 0; $j < count( $commits[$i]['fileChanges'] ); $j++ ) {
		$js .= '{ "file": "'. $commits[$i]['fileChanges'][$j]['file'] .'",
							"insertions": "'. $commits[$i]['fileChanges'][$j]['insertions'] .'",
							"deletions": "'. $commits[$i]['fileChanges'][$j]['deletions'] .'" }';

		if( $j != count( $commits[$i]['fileChanges'] ) - 1 ){
			$js .= ",\n";
		}
	}

	$js .= ') }';

	if( $i != count( $commits ) - 1 ){
		$js .= ",\n";
	}
}

$js .= ");";

/*
**   P U T    V A R S
**    O N    P A G E
*/
	head($title,$style,$scripts,$js);
	body($header,$subtitle,$content,$navigation);
	foot($footer,$dbc);


?>
