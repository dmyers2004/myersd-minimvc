<?php
/**
* DMyers Super Simple MVC
*
* @package    Application File
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class Application {

	public $config;
	public $folder;
	public $run_code;
	public $server;
	public $is_ajax;
	public $base_url;
	public $raw_request;
	public $request;
	public $raw_uri;
	public $uri;
	public $input;
	public $controller;
	public $method;
	public $segs;
	public $main_controller;

	public function __construct($config=null) {
		$this->config = $config;
		
		$this->folder = $config['folder'];
		$this->run_code = $config['run code'];
		$this->server = $config['server'];

		$this->is_ajax = isset($this->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->server['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

		/* Defaults to no errors displayed */
		ini_set('display_errors',$config['display errors']);

		/* register the autoloader */
		spl_autoload_register(array($this,'autoLoader'));

		/* try to call hook if it's there */
		$this->trigger('startup');

		/* with http:// and with trailing slash - auto detect https adjustment will be needed here */
		$this->base_url = trim('http://'.$this->server['HTTP_HOST'].dirname($this->server['SCRIPT_NAME']),'/');

		/* The GET method is default so controller methods look like openAction, others are handled directly openPostAction, openPutAction, openDeleteAction, etc... */
		$this->raw_request = ucfirst(strtolower($this->server['REQUEST_METHOD']));
		$this->request = ($this->raw_request == $config['default request type']) ? '' : $this->raw_request;

		/* Merge Get, Post, Delete, Put into input */
		$temp = array();
		parse_str(file_get_contents('php://input'), $temp);
		$this->input = array_merge_recursive($config['get'], $config['post'], $temp);

		/* get the uri (uniform resource identifier) */
		$this->uri = $this->raw_uri = trim(urldecode(substr(parse_url($this->server['REQUEST_URI'],PHP_URL_PATH),strlen(dirname($this->server['SCRIPT_NAME'])))),'/');

		/* try to call hook if it's there */
		$this->trigger('preRouter');

		/* get the uri pieces */
		$segs = explode('/',$this->uri);

		/*
		we do assume a little here /controller/method
		the direct mapping can be "changed" in the router thou
		*/

		/* If they didn't include a controller and method use the defaults  main & index */
		$this->controller = (!empty($segs[0])) ? strtolower(array_shift($segs)) : $config['default controller'];
		$this->method = (!empty($segs[0])) ? strtolower(array_shift($segs)) : $config['default method'];

		/* store what ever is left over in segs */
		$this->segs = $segs;

		/* try to auto load the controller - will throw an error you must catch if it's not there */
		$classname = $this->controller.$config['controller suffix'];

		/* This throws a error and 4004 - handle it in your error handler */
		if (!class_exists($classname)) {
			throw new Exception($classname.' not found',4004);
		}

		$this->main_controller = new $classname;

		/* if we are just using this single file without all the rest we need some way to reference app */
		$this->main_controller->app = $this;

		/* try to call hook if it's there */
		$this->trigger('preController');

		$ajax = ($this->is_ajax && $this->config['include ajax']) ? $this->config['include ajax'] : '';

		/* call the method - will throw an error you must catch if it's not there */
		$method = $this->method.$this->request.$ajax.$config['method suffix'];

		/* This throws a error and 4005 - handle it in your error handler */
		if (!is_callable(array($this->main_controller,$method))) {
			throw new Exception($classname.' method '.$method.' not found',4005);
		}

		$this->output = call_user_func_array(array($this->main_controller,$method),$this->segs);

		/* try to call hook before output is shown ie. cache, clean, parse, etc... )*/
		$this->trigger('preOutput');
		
		/* This should be our only echo (in a normal application) */
		echo $this->output;

		/* try to call hook if it's there */
		$this->trigger('shutdown');
	}

	/* Controller, Library, Model Autoloader */
	public function autoLoader($name) {
		if (substr($name,-strlen($this->config['controller suffix'])) == $this->config['controller suffix']) {
			$path = $this->config['controller folder'];
		} else {
			$path = ($name{0} >= 'A' && $name{0} <='Z') ? $this->config['libraries folder'] : $this->config['models folder'];
		}

		$load = $path.'/'.strtolower($name).'.php';

		$isfound = false;

		if (file_exists($load)) {
			require_once($load);
			$isfound = true;
		}
		
		return $isfound;
	}
	
	private function trigger($trigger) {
		if (class_exists('Hooks')) {
			$hooks = new Hooks;
			$hooks->$trigger($this);
		}
	}

} /* end mvc controller class */
