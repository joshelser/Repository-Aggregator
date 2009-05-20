<?php

class Database{
  private $_dbUrl;
  private $_dbName;
  private $_dbUsername;
  private $_dbPassword;

  private $_link;
  
  /* Constructor */
  function __construct(){
    $this->_dbUrl = Config::get( 'dbHostname' );
    $this->_dbName = Config::get( 'dbName' );
    $this->_dbUsername = Config::get( 'dbUsername' );
    $this->_dbPassword = Config::get( 'dbPassword' ); 
  }

  /* Connect to the database */
  function connect() {
    if( $this->_link = @mysql_connect( $this->_dbUrl, $this->_dbUsername, $this->_dbPassword ) ){
      if( !@mysql_select_db ( $this->_dbName ) ){
	return die('<p>Could not select the database because: <b>' . mysql_error() . '</b></p>');
      }else{
	return;
      }
    }else{
      return die('<p>Could not connect to the MYSQL because: <b>' . mysql_error() . '</b></p>');
    }
  }

  /* Disconnect Function */
  function disconnect() {
    mysql_close( $this->_link );
  }

  /* Takes a variable number of arguments, sanitizes, and queries 
     First argument must be SQL - Variables are denoted by %1, %2... %13, etc
     Subsequent arguments are variables to be substituted into the query 

     NOTE: There must be a space trailing the %x variable*/
  function query(){
    $numArgs = func_num_args();

    if( $numArgs < 1 ){		/* Must have at least one */
      die( 'Must pass at least one argument to query()' );
    }

    $sql = func_get_arg( 0 );	/* Get the sql */

    if( $sql[-1] != ' ' ){	/* Tacks on the necessary trailing whitespace if not present */
      $sql .= ' ';
    }

    for( $i = 1; $i < $numArgs; $i++ ){ /* Replaces all %x vars with their actual values */
      $arg = mysql_real_escape_string( func_get_arg( $i ), $this->_link );

      if( !is_numeric( $arg ) ){ /* Add double quotes if necessary for SQL */
	$arg = '"'. $arg .'"';
      }

      $sql = preg_replace( '/\s?%'.$i.'\s/', ' '.$arg.' ', $sql ); /* Replacement */
    }
    echo "'".$sql."'".'<br/>';

    $result = mysql_query( $sql, $this->_link ) or /* Execute the query */
      die( 'Could not execute query: '. mysql_error() );

    return $result;
  }

}






?>