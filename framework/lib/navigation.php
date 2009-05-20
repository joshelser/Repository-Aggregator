<?php

/*
**	M A I N    N A V I G A T I O N
*/

$login = '<li><a href="login.php">Login</a></li>';

if( isset( $_SESSION['username'] ) ){
  $login = '<li><span>Welcome, '. $_SESSION['username'] .'</span></li>'."\n";
  $login .= '<li><a href="logout.php">Logout</a></li>';
}

	$navigation .= <<<EOT
    <ul>
      <li><a href="index.php">Home</a></li>
      {$login}
    </ul>
EOT;
	
?>