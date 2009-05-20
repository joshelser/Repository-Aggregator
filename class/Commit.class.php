<?php

require_once( 'lib/functions.lib.php' ); /* For the framework directory */

class Commit{
  private $_commitId;
  private $_repoId;
  private $_commitVal;
  private $_commitMessage;
  private $_commitDateTime;

  /* Load a commit from the database */
  function __construct( $commitId = NULL ) {
    $framework = frameworkDir(); /* Get the directory of the framework */
    require_once( $framework.'/class/Database.class.php' );

    $link = new Database;
    $link->connect();		/* Connect */

    if( !is_null( $commitId ) ){
      /* Get data */
      $sql = 'SELECT * FROM commits WHERE commitId = %1 ';
      
      $result = $link->query( $sql, $commitId );

      $data = mysql_fetch_object( $result );
      
      /* Set variables */
      $this->_commitId = $commitId;
      $this->_repoId = $data->repoId;
      $this->_commitVal = $data->commitVal;
      $this->_commitMessage = $data->commitMessage;
      $this->_commitDateTime = $data->commitDateTime;
    }
    else{
      $this->_commitId = -1;
      $this->_repoId = -1;
      $this->_commitVal = '';
      $this->_commitMessage = '';
      $this->_commitDateTime = '';
    }

    /* Close link */
    $link->disconnect();
  }

  /* Create a new commit and add it to the database */
  function create( $repoId, $commitVal, $commitMessage, $commitDateTime ) {
    $framework = frameworkDir(); /* Get the directory of the framework */
    require_once( $framework.'/class/Database.class.php' );

    $link = new Database;
    $link->connect();

    $sql = 'INSERT INTO commits VALUES ( NULL, %1 , %2 , %3 , %4 )';

    $result = $link->query( $sql, $repoId, $commitVal, $commitMessage, $commitDateTime );
    if( !$result ){
      die( 'Could not execute query' );
    }

    $this->_commitId = mysql_insert_id( $link );
    $this->_repoId = $repoId;
    $this->_commitVal = $commitVal;
    $this->_commitMessage = $commitMessage;
    $this->_commitDateTime = $commitDateTime;

    $link->disconnect();
  }

  /* Return the commit's data */
  function getData() {
    return array( $this->_commitVal,
		  $this->_commitMessage,
		  $this->_commitDateTime );
  }
}

?>