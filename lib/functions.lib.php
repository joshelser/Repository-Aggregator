<?php

/* Return the directory of the framework */
function frameworkDir() {
  require_once( 'config/Config.class.php' );

  return Config::get( 'frameworkDirectory' );
}

/* Returns an array of repositories that the current user is watching */
function getRepositories() {
  require_once( 'class/Repository.class.php' );

  $repoIds = getUserRepositories( $_SESSION['userId'] ); /* Get the ids */

  $repos = array();

  if( count( $repoIds ) == 0 ) {
    return $repos;
  }
  
  /* Get the entire repo data for all ids */
  for( $i = 0; $i < count( $repoIds ); $i++ ) { 
    $repo = new Repository( $repoIds[$i] );

    $repos[] = $repo;
  }

  return $repos;
}

/* Returns an array of repository ids that the give userId is watching */
function getUserRepositories( $userId ) {
  $framework = frameworkDir();

  require_once( $framework.'/class/Database.class.php' );

  $link = new Database;
  $link->connect();

  $sql = 'SELECT * FROM watch WHERE userId = %1';

  $result = $link->query( $sql, $userId );

  $repoIds = array();

  while( $row = mysql_fetch_array( $result ) ){
    $repoIds[] = $row['repoId'];
  }

  return $repoIds;
}  

?>