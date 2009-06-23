<?php

session_start();

/* Authenticates the user.

   Returns the user's data if exists.
   Returns false if the user doesn't exist
 */
function authenticate( $username, $password ){
  require_once( 'lib/functions.lib.php' );

  $framework = frameworkDir();
  require_once( $framework.'/class/Database.class.php' );
  
  $link = new Database;
  $link->connect();
  
  $sql = 'SELECT * FROM users WHERE username = %1 AND password = %2 ';
    
  $result = $link->query( $sql, $_POST['username'], md5( $_POST['password'] ) );

  if( mysql_num_rows( $result ) == 1 ){
    $data = mysql_fetch_object( $result );
    $link->disconnect();

    return $data;
  }
  else{
    $link->disconnect();

    return false;
  }
}

function authorize() {
  if( !isset( $_SESSION['userId'] ) || !isset( $_SESSION['username'] ) ){
    die( 'Access Denied. Please log in.' );
  }
}


function isLoggedIn() {
	if( isset( $_SESSION['userId'] ) && isset( $_SESSION['username'] ) ) {
		return true;
	}
	else {
		return false;
	}
}


/* Logout the user */
function logout(){
  unset( $_SESSION['userId'] );
  unset( $_SESSION['username'] );
  session_destroy();
}





?>
