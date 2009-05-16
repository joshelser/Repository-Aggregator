<?php

class Commit{
  private $_commitId;
  private $_repoId;
  private $_commitVal;
  private $_commitMessage;
  private $_commitDateTime;

  /* Load a commit from the database */
  function __construct( $commitId ) {
    $link = connect();		/* Connect */

    /* Get data */
    $sql = 'SELECT * FROM commits WHERE commitId = ' . $commitId;

    $result = mysql_query( $sql, $link ) or
      die( 'Could not execute query' );

    $data = mysql_fetch_object( $result );

    /* Set variables */
    $this->_commitId = $commitId;
    $this->_repoId = $data->repoId;
    $this->_commitVal = $data->commitVal;
    $this->_commitMessage = $data->commitMessage;
    $this->_commitDateTime = $data->commitDateTime;

    /* Close link */
    mysql_close( $link );
  }

  /* Create a new commit and add it to the database */
  function __construct( $repoId, $commitVal, $commitMessage, $commitDateTime ) {
    $link = connect();

    $sql = 'INSERT INTO commits VALUES ( NULL, '. $repoId .', "'. $commitVal .'", "'. $commitMessage .'", '. $commitDateTime .' )';

    if( !mysql_query( $sql, $link ) ){
      die( 'Could not execute query' );
    }

    $this->_commitId = mysql_insert_id( $link );
    $this->_repoId = $repoId;
    $this->_commitVal = $commitVal;
    $this->_commitMessage = $commitMessage;
    $this->_commitDateTime = $commitDateTime;

    mysql_close( $link );
  }

  /* Return the commit's data */
  function getData() {
    return array( $this->_commitVal,
		  $this->_commitMessage,
		  $this->_commitDateTime );
  }
}

?>