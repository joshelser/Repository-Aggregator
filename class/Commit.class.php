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

require_once( 'lib/functions.lib.php' ); /* For the framework directory */

class Commit{
  private $_commitId;
  private $_repoId;
  private $_commitVal;
  private $_commitMessage;
  private $_commitDateTime;
	private $_commitAuthor;

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
			$this->_commitAuthor = $data->commitAuthor;
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
  function create( $repoId, $commitVal, $commitMessage, $commitDateTime, $commitAuthor ) {
    $framework = frameworkDir(); /* Get the directory of the framework */
    require_once( $framework.'/class/Database.class.php' );

    $link = new Database;
    $link->connect();

    $sql = 'INSERT INTO commits VALUES ( NULL, %1 , %2 , %3 , %4 , %5 )';

    $result = $link->query( $sql, $repoId, $commitVal, $commitMessage, $commitDateTime, $commitAuthor );
    if( !$result ){
      die( 'Could not execute query' );
    }

    $this->_commitId = mysql_insert_id( $link );
    $this->_repoId = $repoId;
    $this->_commitVal = $commitVal;
    $this->_commitMessage = $commitMessage;
    $this->_commitDateTime = $commitDateTime;
		$this->_commitAuthor = $commitAuthor;

    $link->disconnect();
  }

  /* Return the commit's data */
  function getData() {
    return array( 'commitVal' => $this->_commitVal,
			  					'commitMessage' => $this->_commitMessage,
									'commitDateTime' => $this->_commitDateTime,
									'commitAuthor' => $this->_commitAuthor );
  }
}

?>
