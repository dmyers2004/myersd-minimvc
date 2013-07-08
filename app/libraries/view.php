<?php
/**
* DMyers Super Simple MVC
*
* @package    view for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*
* @Singleton
* @Inject path string
* @Inject config object
*
*/

class view {
	public static $data; /* view data */
	public static $path;

	public function __construct($path=null) {
		if ($path) {
			self::$path = $path;
			self::$data = array();
		}
	}

	public function load($file,$return=TRUE) {
		$capture = '';

		$file = self::$path.$file.'.php';

		if (is_file($file)) {
			$capture = $this->_capture($file,self::$data);
		}

		if ($return === false) {
			echo $capture;
		}
		
		if ($return === true) {
			return $capture;	
		}

		if (is_string($return)) {
			self::$data[$name] = $capture;
		}
		
		return $this;
	}

	public function set($name,$value=null,$where=null) {
		if (is_array($name)) {
			foreach ($name as $key => $value) {
				$this->set($key,$value);	
			}
			return $this;
		}
		
		if (is_string($value)) {
			$where = ($where) ? $where : '>';
		} else {
			$where = '#';
		}
		
		switch ($where) {
			case '>':
				self::$data[$name] = self::$data[$name].$value;
			break;
			case '<':
				self::$data[$name] = $value.self::$data[$name];
			break;
			default:
				self::$data[$name] = $value;
		}

		return $this;
	}
	
	public function get($name=null) {
		if ($name == null) {
			return self::$data;
		}
		
		return self::$data[$name];
	}

	private function _capture($_mvc_file,$_mvc_data) {
		extract((array) $_mvc_data);
		ob_start();
		include($_mvc_file);
		return ob_get_clean();
	}

}
