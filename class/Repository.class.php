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
  function __construct( $repoId = NULL ) {
    $framework = frameworkDir(); /* Get the directory of the framework */
    require_once( $framework.'/class/Database.class.php' );

    $link = new Database;
    $link->connect();
    
    if( !is_null( $repoId  ) ){
      $sql = 'SELECT * FROM repositories WHERE repoId = %1 ';
      
      $result = $link->query( $sql, $repoId );
            
      $data = mysql_fetch_object( $result );

      $this->_repoId = $repoId;
      $this->_url = $data->url;
      $this->_dateAdded = $data->dateAdded;
      $this->_dateUpdated = $data->dateUpdated;
      $this->_description = $data->description;
      $this->_username = $data->username;
      $this->_password = $data->password;
    }
    else{
      $this->_repoId = -1;
      $this->_url = '';
      $this->_dateAdded = '';
      $this->_dateUpdated = '';
      $this->_description = '';
      $this->_username = '';
      $this->_password = '';
    }
    
    $link->disconnect();
  }

  /* Create a new repository in the database */
  function create( $url, $description = '', $username = '', $password = '' ) {
    $framework = frameworkDir(); /* Get the directory of the framework */
    require_once( $framework.'/class/Database.class.php' );

    $link = new Database;
    $link->connect();
    
    $sql = 'INSERT INTO repositories VALUES ( NULL , %1 , %2 , %3 , %4 , %5 , %6 )';

    $result = $link->query( $sql, $url, date( 'Y-m-d' ), date( 'Y-m-d' ), $description, $username, $password );
    if( !result ){
      die( 'Could not execute query' );
    }

    $this->_repoId = mysql_insert_id( $link );
    $this->_url = $url;
    $this->_dateAdded = date( 'Y-m-d' );
    $this->_dateUpdated = date( 'Y-m-d' );
    $this->_description = $description;
    $this->_username = $username;
    $this->_password = $password;

    $link->disconnect();
  }

  /* Populate the array of commits for the repository */
  function getCommits() {
    require_once( 'class/Commit.class.php' );
    $framework = frameworkDir(); /* Get the directory of the framework */
    require_once( $framework.'/class/Database.class.php' );

    $link = new Database;
    $link->connect();

    $sql = 'SELECT commitId FROM commits WHERE repoId = %1 ';

    $result = $link->query( $sql, $this->_repoId );
    
    $this->_commits = array();

    while( $row = mysql_fetch_array( $result ) ){
      $this->_commits[] = new Commit( $row['commitId'] );
    }

    // No disconnect necessary as is handled by the commit constructor
  }

  /* Update the repository */
  function update() {
    $framework = frameworkDir(); /* Get the directory of the framework */
    require_once( $framework.'/class/Database.class.php' );

    $link = new Database;
    $link->connect();

    // Update the repository

    $this->_dateUpdated = date( 'Y-m-d' ); /* Update date */

    /* Update repository */
    $sql = 'UPDATE repositories SET dateUpdated = %1 WHERE repoId = %2 ';

    $result = $link->query( $sql, $this->_dateUpdated, $this->_repoId );
    if( !$result ){
      die( 'Could not execute query' );
    }

    $link->disconnect();
  }

  /* Remove the repository from the database */
  function delete() {
    $framework = frameworkDir(); /* Get the directory of the framework */
    require_once( $framework.'/class/Database.class.php' );

    $link = new Database;
    $link->connect();

    $sql = 'DELETE FROM repositories WHERE repoId = %1 ';

    $result = $link->query( $sql, $this->_repoId );
    if( !$result ){
      die( 'Could not execute query' );
    }

    $link->disconnect();
  }

  function getData() {
    return array( 'url' =>$this->_url,
		  'dateUpdate' => $this->_dateUpdated,
		  'dateAdded' => $this->_dateAdded,
		  'description' => $this->_description );
  }

}

?>