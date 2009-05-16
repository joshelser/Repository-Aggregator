<?php

session_start();

function authenticate( $username, $password ){
  require_once( 'framework/lib/library.php' );
  
  $link = connect();

  $sql = 'SELECT * FROM users WHERE username = "'. $username .'" AND password = "'. md5( $password ) .'"';

  $result = mysql_query( $sql, $link ) or
    die( 'Could not execute query' );

  if( mysql_num_rows( $result ) == 1 ){
    $data = mysql_fetch_object( $result );
    $_SESSION['userid'] = $data->userId;
    
    return true;
  }
  else{
    return false;
  }
}

function logout(){
  unset( $_SESSION['userId'] );
  session_destroy();
}





?>