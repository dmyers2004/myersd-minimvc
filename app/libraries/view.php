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
* @Inject config array()
*
*/

class view {
	public static $layout; /* default template */
	public static $body; /* default body variable */
	public static $data; /* view data */
	public static $path;
	public static $config;

	public function __construct($path=null,$config=null) {
		if ($path) {
			self::$path = $path;
			self::$config = $config;
			self::$data = new stdClass;
		}
	}

	public function __set($name,$value) {
		$name = strtolower($name);
		self::$data->$name = $value;
		return $this;
	}

	public function __get($name) {
		$name = strtolower($name);
		return self::$data->$name;
	}

	/* load view into variable and output */
	/*
		render(); load default page into body and output default template
		render('template'); load this template and output
		render('viewfile','template'); load this view file into body data variable and output using template
	*/
	public function render($template=NULL) {
		$template = ($template) ? $template : $this->configGet('layout','layout');

		$this->load($template,NULL,FALSE);

		return $this;
	}

	public function partial($file,$name=NULL,$data=NULL) {
		$name = ($name) ? $name : $this->configGet('body','body');

		self::$data->$name = $this->load($file,$data,TRUE);

		return $this;
	}

	public function load($file,$data=NULL,$return=TRUE) {
		$capture = '';

		$data = ($data) ? $data : self::$data;
		$file = self::$path.$file.'.php';

		if (is_file($file)) {
			$capture = $this->_capture($file,$data);
		}

		if (!$return) {
			echo $capture;
		}

		return $capture;
	}

	public function set($name,$value) {
		$this->$name = $value;

		return $this;
	}

	public function data($ary) {
		self::$data = (object) array_merge_recursive((array) self::$data,(array) $ary);

		return $this;
	}

	public function append($name, $value) {
		self::$data[$name] .= $value;

		return $this;
	}

	public function filter($name=null) {
		$completename = 'filter'.ucfirst(strtolower($name));
		self::$data->$completename = new $completename();

		return $this;
	}

	private function _capture($_mvc_file,$_mvc_data) {
		extract((array) $_mvc_data);
		ob_start();
		include($_mvc_file);
		return ob_get_clean();
	}

	public function configGet($name,$default=null) {
		return (self::$config[$name]) ? self::$config[$name] : $default;
	}

}
