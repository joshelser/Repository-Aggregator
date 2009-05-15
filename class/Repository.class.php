<?php
require_once( 'framework/lib/library.php' );

class Repository {
  protected $_repoId;
  private $_url;
  private $_dateAdded;
  private $_dateUpdated;
  private $_description;

  protected $_commits;


  function __construct( $repoId ) {
    $link = connect();
    
    $sql = 'SELECT * FROM repositories WHERE repoId = ' . $repoId;

    $result = mysql_query( $sql, $link ) or
      die( 'Could not execute query' );

    $data = mysql_fetch_object( $result );

    $this->_repoId = $repoId;
    $this->_url = $data->url;
    $this->_dateAdded = $data->dateAdded;
    $this->_dateUpdated = $data->dateUpdated;
    $this->_description = $data->description;

    mysql_close( $link );
  }

  function getCommits() {
    require_once( 'class/Commit.class.php' );

    $link = connect();

    $sql = 'SELECT commitId FROM commits WHERE repoId = ' . $this->_repoId;

    $result = mysql_query( $sql, $link ) or
      die( 'Could not execute query' );
    
    $this->_commits = array();

    while( $row = mysql_fetch_array( $result ) ){
      $this->_commits[] = new Commit( $row['commitId'] );
    }

    mysql_close( $link );
  }

  function update() {
    $link = connect();

    // Update the repository

    $this->_dateUpdated = date( 'Y-m-d' ); /* Update date */

    /* Update repository */
    $sql = 'UPDATE repositories SET dateUpdated = \''. $this->_dateUpdated .'\' WHERE repoId = '. $this->_repoId;

    if( !mysql_query( $sql, $link ) ){
      die( 'Could not execute query' );
    }

    mysql_close( $link );
  }

  function delete() {
    $link = connect();

    $sql = 'DELETE FROM repositories WHERE repoId = '. $this->_repoId;

    if( !mysql_query( $sql, $link ) ){
      die( 'Could not execute query' );
    }

    mysql_close( $link );
  }

}

?>