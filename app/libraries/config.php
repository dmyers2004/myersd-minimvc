<?php
/**
* DMyers Super Simple MVC
*
* @package    Config for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class config {
	public static $data = array();
	public static $path;
	public static $folder;

	public function __construct($path=NULL,$folder=NULL) {
		if ($path) {
			self::$path = $path;
			self::$folder = ($folder) ? $folder.'/' : '' ;
		}
	}

	public function get($name,$key,$default=null) {
		$array = $this->read($name);
		
		if (isset($array[$key])) {
			return $array[$key];
		} else {
			return $default;
		}
	
	}

	public function read($name) {
		if (isset(self::$data[self::$folder.$name])) {
			return self::$data[self::$folder.$name];
		}

		/* manually load file so $config variable is local */
		$file_default = self::$path.$name.'.php';
		$file_folder = self::$path.self::$folder.$name.'.php';

		if (is_file($file_folder)) {
			include($file_folder);
			self::$data[self::$folder.$name] = $config;

		} elseif (is_file($file_default)) {
			include($file_default);
			self::$data[self::$folder.$name] = $config;

		}

		return (array)self::$data[self::$folder.$name];
	}

}
