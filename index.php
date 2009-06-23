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

require_once( $framework.'/lib/authentication.php' );

require_once( 'config/Config.class.php' );

// Library File
include 'framework/lib/library.php';

// Sort in reverse order
function dateSort( $a, $b ) {
	if( $a{commitDateTime} == $b{commitDateTime} ) {
		return 0;
	}

	return ( $a{commitDateTime} > $b{commitDateTime} ) ? -1 : 1;
}

if( isLoggedIn() ) {  /* Show the user the most recent changes if they're logged in */
	$title = 'Welcome';
	$subtitle = Config::get( 'siteName' );
	$content = '<h2 class="indent">Recent Activity</h2>'."\n";
	$content .= '<div id="commits" class="indent"></div>'."\n";
	$content .= '<div id="pagination" class="indent pagination"></div><br/>';
	
	$userId = $_SESSION['userId'];	

	$repos = getUserRepositoryIds( $userId ); 	/* Get all the repos the user is watching */

	$commits = array();

	foreach( $repos as &$repo ) {		/* Get a list of all the commits from those repos */
		$commits = array_merge( $commits, getLimitedCommits( $repo ) );
	}

	usort( $commits, "dateSort" );	/* Sort by datetime descending */

	$js = 'var commits = new Array(';

	for( $i = 0; $i < count( $commits ); $i++ ) {
		$js .= ' { "commitMessage": "'. addslashes( $commits[$i]['commitMessage'] ).'",
							 "commitVal": "'. $commits[$i]['commitVal'] .'",
							 "commitDateTime": "'. $commits[$i]['commitDateTime'] .'",
						 	 "commitAuthor": "'. $commits[$i]['commitAuthor'] .'",
						 	 "commitId": "'. $commits[$i]['commitId'] .'",
						 	 "repoId": "'. $commits[$i]['repoId'] .'",
							 "repoName": "'.$commits[$i]['repoName'] .'",
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
}
else {
$title = 'Home';
$subtitle = Config::get( 'siteName' );
$content = <<<EOT
<div id="welcomeText" class="indent">
	Repository Aggregator brings a social aspect to coding. It allows you to follow your favorite 
  code projects, bringing updates on what is being done.

	<br />
	<br />

	Your repository isn't listed? Feel free to add any repository that you work on so that your fans can follow your work!
</div>
EOT;

}
/*
**   P U T    V A R S
**    O N    P A G E
*/
	head( $title, $style, $scripts, $js );
	body( $header, $subtitle, $content, $navigation );
	foot( $footer, $dbc );
?>
