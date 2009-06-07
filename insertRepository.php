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

if( !isset( $_POST['url'] ) ){	/* Need to have a URL */
  die( 'Please enter a repository URL' );
}

if( !isset( $_POST['type'] ) ){ /* Need to have a type */
	die( 'Please select a repository type' );
}

if( !isset( $_POST['name'] ) ){
	die( 'Please enter a project name' );
}

require_once( $framework.'/class/Database.class.php' );

$link = new Database;
$link->connect();

/* SQL */
$sql = 'INSERT INTO repositories VALUES ( NULL, %1 , %2 , %3 , %4 , %5 , %6 , %7 , %8 )';

$localDir = Config::get( 'repositoryDirectory' ) .'/'. $_POST['name'];
$extension = 0;

while( file_exists( $localDir.(string)$extension ) ){ /* Tack on an extra extension if necessary */
	$extension++;

	if( $extension > 100 ) {
		die( 'Common name chosen, select another project name' );
	}
}

if( $extension > 0 ){ /* Save the extension */
	$localDir .= (string)$extension;
}

$description = 'NULL';
$username = 'NULL';
$password = 'NULL';

if( isset( $_POST['description'] ) ){ /* Get optional fields if present */
  $description = $_POST['description'];
}

if( $_POST['username'] != '' ){
  $username = $_POST['username'];
}

if( $_POST['password'] != '' ){
  $password = md5( $_POST['password'] );
}

$result = $link->query( $sql, $_POST['url'], (int)$_POST['type'], $localDir, date( 'Y-m-d' ), date( 'Y-m-d' ),
			$description, $username, $password );

if( !$result ){
  die( 'Insert query failed' );
}

$repoId = mysql_insert_id();

$sql = 'INSERT INTO watches VALUES ( %1 , %2 )';

$result = $link->query( $sql, $_SESSION['userId'], $repoId );

if( !$result ) {
  die( 'Watch query failed' );
}

exec( 'createRepository.pl', array( $_POST['type'], $localDir ) );

header( 'location: viewRepositories.php?action=added' );

?>
