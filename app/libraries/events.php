<?php
/**
* DMyers Super Simple MVC
*
* @package    events for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
* 
* These may or may not be there
* ie. email, logging, user logged in, user logged out
* Thou they can (if there) return an array of "output" or null
* 
*/

class events {

	public static $events = array();
	
	public function __construct() {}
	
	public function register($name,$class,$method) {
		/* call back in array('class','method') */
		self::$events[$name][$class.$method] = array($class,$method);
	}
	
	public function trigger($name) {
		$args = func_get_args();
		array_shift($args); /* shift off $name */
		
		$rtn = array();
		
		if (self::has($name)) {
			foreach (self::$events[$name] as $callback) {
				if (is_callable($callback)) {
					$rtn[] = call_user_func_array($callback, $args);
				}
			}
		}
		
		return (!count($rtn)) ? $rtn : null;
	}

	public function has($name) {
		return isset(self::$events[$name]);
	}
	
}