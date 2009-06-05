<?php

/*
**	M A I N    N A V I G A T I O N
*/

$login = '<li><a href="login.php">Login</a></li>';

if( isset( $_SESSION['username'] ) ){
  $login = <<<EOT
<li id="repositoryMenu">Repositories
  <ul>
    <li><a href="viewRepositories.php">View Repositories</a></li>
    <li><a href="addRepository.php">Add a Repository</a></li>
  </ul>
</li>
<li><a href="logout.php">Logout</a></li>
EOT;
}

	$navigation .= <<<EOT
    <ul>
      <li><a href="index.php">Home</a></li>
      {$login}
    </ul>
EOT;
	
?>
