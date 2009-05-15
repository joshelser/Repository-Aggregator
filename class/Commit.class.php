<?php

class Commit{
  private $_commitId;
  private $_repoId;
  private $_commitVal;
  private $_commitMessage;
  private $_commitDateTime;

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

  //function 
}

?>