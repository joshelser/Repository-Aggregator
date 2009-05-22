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

class Config {
  private static $configs = array();
  private static $loaded = 0;

  // constructor - do nothing
  public function __construct() {
    //intentionally blank
  }

  // load - parse ini file and set configs
  public static function load() {
    self::$configs = parse_ini_file('config/config.ini.php');
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