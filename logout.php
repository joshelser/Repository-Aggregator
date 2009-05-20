<?php

session_start();

require_once( 'lib/functions.lib.php' );

logout();

header( 'Location: index.php' );

?>