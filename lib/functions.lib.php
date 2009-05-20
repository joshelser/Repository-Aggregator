<?php

function frameworkDir() {
  require_once( 'config/Config.class.php' );

  return Config::get( 'frameworkDirectory' );
}
    
function logout() {
  unset( $_SESSION['userId'] );
  unset( $_SESSION['username'] );
  session_destroy();
}



?>