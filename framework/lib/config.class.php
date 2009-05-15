<?php

class Config {
  private static $configs = array();
  private static $loaded = 0;

  // constructor - do nothing
  public function __construct() {
    //intentionally blank
  }

  // load - parse ini file and set configs
  public static function load() {
    self::$configs = parse_ini_file('framework/config/config.ini.php');
  }

  // get - return the value of config option with given name
  public static function get($name) {
    if (!self::$loaded) {
      self::load();
      self::$loaded = 1;
    }

    return self::$configs[$name];
  }
}

?>