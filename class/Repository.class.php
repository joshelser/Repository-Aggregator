<?php

require_once( 'framework/lib/library.php' ); /* Necessary for connect() */

class Repository {
  protected $_repoId;
  private $_url;
  private $_dateAdded;
  private $_dateUpdated;
  private $_description;	/* Optional */
  private $_username;		/* Optional */
  private $_password;		/* Optional */

  protected $_commits;		/* Array of commits for the repository */


  /* Pulls the repository out of the database */
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
    $this->_username = $data->username;
    $this->_password = $data->password;

    mysql_close( $link );
  }

  /* Create a new repository in the database */
  function __construct( $url, $description = '', $username = '', $password = '' ) {
    $link = connect();
    
    $sql = 'INSERT INTO repositories VALUES ( NULL, "'. $url .'", "'. date( 'Y-m-d' ) .'", "'.  date( 'Y-m-d' ) .'", "'. $description .'", "'. $username .'", "'. $password .'")';

    if( !mysql_query( $sql, $link ) ){
      die( 'Could not execute query' );
    }

    $this->_repoId = mysql_insert_id( $link );
    $this->_url = $url;
    $this->_dateAdded = date( 'Y-m-d' );
    $this->_dateUpdated = date( 'Y-m-d' );
    $this->_description = $description;
    $this->_username = $username;
    $this->_password = $password;

    mysql_close( $link );
  }

  /* Populate the array of commits for the repository */
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

  /* Update the repository */
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

  /* Remove the repository from the database */
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