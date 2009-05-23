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

/* HTML */
$content = <<<EOT
<div id="addRepository">
  <h3>Add a new repository</h3>
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
  <form method="POST" action="watchRepository.php">
    <select>
EOT;

for( $i = 0; $i < count( $existingRepos ); $i++ ) { /* List all the existing repositories */
  $content .= '<option id="'. $existingRepos[$i]->getRepoId() .'">'. $existingRepos[$i]->getUrl() ."</option>\n";
}

$content .= <<<EOT
    </select>
    <input type="submit" value="Watch" />
  </form>
</div>
EOT;

/*
**   P U T    V A R S
**    O N    P A G E
*/
	head($title,$style,$scripts);
	body($header,$subtitle,$content,$navigation);
	foot($footer,$dbc);


?>