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

require_once( 'config/Config.class.php' );

// Library File
include 'framework/lib/library.php';


$title = 'Home';
$subtitle = Config::get( 'siteName' );
$content = <<<EOT
<div id="welcomeText" class="indent">
	Repository Aggregator brings a social aspect to coding. It allows you to follow your favorite 
  code projects, bringing updates on what is being done.

	<br />
	<br />

	Your repository isn't listed? Feel free to add any repository that you work on so that your fans can follow your work!
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
