<?php

require_once( 'lib/functions.lib.php' ); /* Load functions */

$framework = frameworkDir();	/* Get framework directory */
require_once( $framework.'/lib/authentication.php' );

logout();			/* Logout */

header( 'Location: index.php' ); /* Bounce to homepage */

?>