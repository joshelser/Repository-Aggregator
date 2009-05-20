<?php

function frameworkDir( ){
  require_once( 'config/Config.class.php' );

  return Config::get( 'frameworkDirectory' );
}
    






?>