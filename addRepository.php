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

$framework = frameworkDir();

require_once( 'config/Config.class.php' );
require_once( $framework.'/lib/authentication.php' );

authorize();			/* Are you allowed here? */

// Library File
require_once( $framework.'/lib/library.php' );

$title = 'Add a Repository';
$subtitle = Config::get( 'siteName' );

$existingRepos = getAllRepositories(); /* Get all the repositories in the database */
$userRepos = getUserRepositoryIds( $_SESSION['userId'] ); /* Get all the repositories of the user */

/* HTML */
$content = <<<EOT
<div id="addRepository">
  <h3>Add a new repository to watch</h3>
  <form method="POST" action="insertRepository.php">
    <table>
      <tr>
        <td>
          <label for="url">Repository URL:</label>
        </td>
        <td>
          <input type="text" id="url" name="url"/>
        </td>
      </tr>

      <tr>
        <td>
          <label for="description">Description [optional]:</label>
        </td>
        <td>
          <input type="text" id="description" name="description" />
        </td>
      </tr>

      <tr>
        <td>
          <label for="username">Username [optional]:</label>
        </td>
        <td>
          <input type="text" id="username" name="username" />
        </td>
      </tr>

      <tr>
        <td>
          <label for="password">Password [optional]:</label>
        </td>
        <td>
          <input type="password" id="password" name="password" />
        </td>
      </tr>
  
      <tr>
        <td>
          <input type="submit" value="Add" />
        </td>
      </tr>
    </table>
  </form>
  <h3>Watch an existing repository</h3>
EOT;

$watchNew = false;

$i = 0;
/* Make sure we don't give the option to watch new repos if they don't have any to watch */
while( !$watchNew && $i < count( $existingRepos ) ){
  if( !in_array( $existingRepos[$i]->getRepoId(), $userRepos ) ) {
    $watchNew = true;
  }

  $i++;
}

if( $watchNew ){		/* We have at least one new repository to watch */
  $content .= <<<EOT
  <form method="POST" action="watchRepository.php">
    <select name="repoId">

EOT;

  for( $i = 0; $i < count( $existingRepos ); $i++ ) { /* List all the existing repositories */
    if( !in_array( $existingRepos[$i]->getRepoId(), $userRepos ) ) {
      $content .= '      ';				    /* Nice spacing in the HTML */
      $content .= '<option value="'. $existingRepos[$i]->getRepoId() .'">'. $existingRepos[$i]->getUrl() ."</option>\n"; 
    }
  }

  $content .= <<<EOT
    </select>
    <input type="submit" value="Watch" />
  </form>
EOT;
}
else{				/* All repositories are being watched */
  $content .= <<<EOT
    <span>Sorry, there are no existing repositories to watch</span>
EOT;
}

$content .= '</div>';

/* Generate Page */
head($title,$style,$scripts);
body($header,$subtitle,$content,$navigation);
foot( $footer );

?>