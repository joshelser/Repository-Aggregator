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

if( !isset( $_GET['commitId'] ) ) {
	die( 'Must specify a commit to view' );
}

if( !isset( $_GET['file'] ) ) {
	die( 'Must specify a filename' );
}

require_once( 'config/Config.class.php' );
require_once( 'class/Commit.class.php' );

// Library File
include 'framework/lib/library.php';


$title = 'View File Change';
$subtitle = Config::get( 'siteName' );

$commitId = $_GET['commitId'];
$file = $_GET['file'];
$repoId = $_GET['repoId'];

$commit = new Commit( $commitId );
$data = $commit->getData();
$data['commitAuthor'] = htmlspecialchars( $data['commitAuthor'] );

$diff = shell_exec( "./getFileChange.pl $repoId '$commitId' '$file'" );
$diff = nl2br( htmlspecialchars( $diff ) );

$content = <<<EOT
<div class="indent">
	<h3 class="indent">{$data['commitMessage']}</h3>
	<p><span class="indent">Commit:&nbsp;{$data['commitVal']}</span></p>
	<p><span class="indent">Author:&nbsp;{$data['commitAuthor']}</span></p>
	<p><span class="indent">Time:&nbsp;{$data['commitDateTime']}</span></p>
	<p><span class="indent">File:&nbsp;{$file}</span></p>
	<div id="code">
		<code>
			{$diff}
		</code>
	</div>
</div>
EOT;

/*
**   P U T    V A R S
**    O N    P A G E
*/
	head($title,$style,$scripts);
	body($header,$subtitle,$content,$navigation);
	foot($footer,$dbc);
?>
