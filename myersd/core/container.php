<?php
/**
* DMyers Super Simple MVC
*
* @package    Container file
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/
namespace myersd\core;

class container {
	protected $container = array();
	
	function __set($key, $val) {
		$this->container[$key] = $val;
	}
	
	function __get($key) {
		return $this->container[$key];
	}
	
	function set($path,$val) {
	   foreach(explode('\\', $path) as $step) {
	     $loc = &$this->container[$step];
	   }
	   
	   return $loc = $val;
	}
}
