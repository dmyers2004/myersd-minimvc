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
	public static $layout; /* default template */
	public static $body; /* default body variable */
	public static $data; /* view data */
	public static $path;
	public static $config;
	public static $throwError;

	public function __construct($path=null,$config=null) {
		if ($path) {
			self::$path = $path;
			self::$throwError = $config->get(get_class($this),'throw errors',false);
			self::$layout = $config->get(get_class($this),'layout','layout');
			self::$body = $config->get(get_class($this),'body','body');
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
		$template = ($template) ? $template : self::$layout;

		return $this->load($template);
	}

	public function partial($file,$name=NULL,$data=NULL) {
		$name = ($name) ? $name : self::$body;

		self::$data->$name = $this->load($file,$data);

		return $this;
	}

	public function load($file,$data=NULL) {
		$capture = '';

		$data = ($data) ? $data : self::$data;
		$file = self::$path.$file.'.php';

		if (is_file($file)) {
			$capture = $this->_capture($file,$data);
		} elseif(self::$throwError) {
			throw new Exception('View file "'.$file.'" not found',4006);
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

	public function filter($name) {
		$classname = 'filter'.ucfirst(strtolower($name));
		
		$load = self::$path.$path.'filters/'.strtolower($name).'.php';

		if (file_exists($load)) {
			require_once($load);
			self::$data->$classname = new $classname();
		} elseif(self::$throwError) {
			throw new Exception('View Filter "'.$name.'" at "'.$load.'" not found',4007);		
		}

		return $this;
	}

	private function _capture($_mvc_file,$_mvc_data) {
		extract((array) $_mvc_data);
		ob_start();
		include($_mvc_file);
		return ob_get_clean();
	}

}
