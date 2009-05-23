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

/* Return the directory of the framework */
function frameworkDir() {
  require_once( 'config/Config.class.php' );

  return Config::get( 'frameworkDirectory' );
}

/* Returns an array of repositories in the system */
function getAllRepositories() {
  require_once( 'class/Repository.class.php' );

  $framework = frameworkDir();

  /* Database */
  require_once( $framework.'/class/Database.class.php' );

  $link = new Database;
  $link->connect();

  /* Query */
  $sql = 'SELECT repoId FROM repositories';

  $result = $link->query( $sql, $userId );

  $repoIds = array();

  /* Get Ids */
  while( $row = mysql_fetch_array( $result ) ){
    $repoIds[] = $row['repoId'];
  }

  return getRepositoriesFromIds( $repoIds ); /* Return the actual repositories */
}

/* Returns an array of repositories that the give userId is watching */
function getUserRepositories( $userId ) {
  require_once( 'class/Repository.class.php' );
  $framework = frameworkDir();

  /* Database */
  require_once( $framework.'/class/Database.class.php' );

  $link = new Database;
  $link->connect();

  /* Query */
  $sql = 'SELECT * FROM watch WHERE userId = %1';

  $result = $link->query( $sql, $userId );

  $repoIds = array();

  /* Get Ids */
  while( $row = mysql_fetch_array( $result ) ){
    $repoIds[] = $row['repoId'];
  }

  return getRepositoriesFromIds( $repoIds ); /* Return the actual repositories */
}

/* Given a list of ids, will return an array of Repository Objects */
function getRepositoriesFromIds( &$repoIds ){
  if( count( $repoIds ) == 0 ) {
    return array();
  }
						
  $repos = array();

  /* Get the entire repo data for all ids */
  for( $i = 0; $i < count( $repoIds ); $i++ ) { 
    $repo = new Repository( $repoIds[$i] );
    
    $repos[] = $repo;
  }

  return $repos;
}

?>