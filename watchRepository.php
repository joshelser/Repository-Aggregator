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

if( !isset( $_POST['repoId'] ) ){	/* Need to have a URL */
  die( 'Please select a repository' );
}

require_once( $framework.'/class/Database.class.php' );

/* Database */
$link = new Database;
$link->connect();

$sql = 'SELECT repoId FROM watch WHERE userId = %1 ';

$result = $link->query( $sql, $_SESSION['userId'] );

$repos = array();

while( $row = mysql_fetch_array( $result ) ){
  $repos[] = $row['repoId'];
}


if( in_array( (int)$_POST['repoId'], $repos ) ) { /* Don't re-add a repository */
  die( 'Already watching this repository' );
}


/* SQL to watch the repository*/
$sql = 'INSERT INTO watch VALUES ( %1 , %2 )';

$result = $link->query( $sql, $_SESSION['userId'], (int)$_POST['repoId'] );

if( !$result ) {
  die( 'Watch query failed' );
}

header( 'location: viewRepositories.php?action=watched' );

?>