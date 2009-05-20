<?php

require_once( 'lib/functions.lib.php' );

// Library File
$framework = frameworkDir();
require_once( $framework.'/lib/library.php' );

/* Bounce already logged in users to index.php */
if( isset( $_SESSION['userId'] ) ){
  header( 'Location: index.php' );

  exit();
}

/* If the login data is present, try to log them in */
if( isset( $_POST['username'] ) && isset( $_POST['password'] ) ){
  require_once( $framework.'/class/Database.class.php' );
  
  $link = new Database;
  $link->connect();

  $sql = 'SELECT * FROM users WHERE username = %1 AND password = %2 ';
  
  $result = $link->query( $sql, $_POST['username'], md5( $_POST['password'] ) );

  if( mysql_num_rows( $result ) == 0 ){ /* On fail */
    logout();			/* Destroys session data */

    header( "Location: login.php?action=failed" );
    exit();
  }

  $data = mysql_fetch_object( $result );

  $_SESSION['userId'] = $data->userId; /* Set user data in session variable */
  $_SESSION['username'] = $data->username;

  $link->disconnect();

  header( "Location: index.php" ); /* Bounce to index.php */
  exit();
}


$title = 'Login';
$subtitle = $GLOBALS['SITE_NAME'];

$error = '';

if( isset( $_GET['action'] ) && $_GET['action'] == 'failed' ){ /* Catch a failed login */
  $error = <<<EOT
<tr>
  <td colspan="2">
    <span id="errorMessage">
      Incorrect username and password combination
    </span>
  </td>
</tr>
EOT;
}


$content = <<<EOT
<form method="post" action="login.php">
  <table id="loginTable">
    {$error}
    <tr>
      <td>
        <label for="username">Username:</label>
      </td>
      <td>
        <input type="text" name="username" id="username" />
      </td>
    </tr>

    <tr>
      <td>
        <label for="password">Password:</label>
      </td>

      <td>
        <input type="password" name="password" id="password" />
      </td>
    </tr>

    <tr>
      <td>
        <input type="submit" value="Login" />
      </td>
    </tr>
  </table>
</form>
EOT;

/* Display page */
head($title,$style,$scripts);
body($header,$subtitle,$content,$navigation);
foot($footer );

?>