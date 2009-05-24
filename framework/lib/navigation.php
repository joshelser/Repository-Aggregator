<?php

/*
**	M A I N    N A V I G A T I O N
*/

$login = '<li><a href="login.php">Login</a></li>';

if( isset( $_SESSION['username'] ) ){
  $login = <<<EOT
<li><span>Welcome, {$_SESSION['username']}</span></li>
<li id="repositoryMenu" onclick="showMenu( 'repository' )">Repositories</li>
<div id="repositorySubMenu" class="headerSubMenu">
<a href="viewRepositories.php">View Repositories</a>
<br />
<a href="addRepository.php">Add a Repository</a>
</div>
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