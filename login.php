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

// Library File
$framework = frameworkDir();
require_once( $framework.'/lib/library.php' );

/* Bounce already logged in users to index.php */
if( isset( $_SESSION['userId'] ) && isset( $_SESSION['username'] ) ){
  header( 'Location: index.php' );

  exit();
}

/* If the login data is present, try to log them in */
if( isset( $_POST['username'] ) && isset( $_POST['password'] ) ){
  require_once( $framework.'/class/Database.class.php' );
  
  $data = authenticate( $_POST['username'], $_POST['password'] ); /* Authenticates the user */

  if( $data == false ){	/* On fail */
    logout();			/* Destroys session data */

    header( "Location: login.php?action=failed" );
    exit();
  }

  $_SESSION['userId'] = $data->userId; /* Set user data in session variable */
  $_SESSION['username'] = $data->username;

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