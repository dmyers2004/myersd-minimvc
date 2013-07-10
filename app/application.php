<?php
/**
* DMyers Super Simple MVC
*
* @package    application File
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class Application {

	public $config;
	public $input;
	public $output;

	public function __construct(&$config){
		$this->config = $config;
	}

	public function run() {
		/* Turn off all by default */
		error_reporting(0);

		/* register the autoloader */
		spl_autoload_register(array($this,'autoLoader'));

		/* try to call hook if it's there */
		$this->trigger('startup');
		
		/* with http:// and with trailing slash - auto detect https adjustment will be needed here */
		$this->config['app']['base url'] = trim('http://'.$this->config['app']['server']['HTTP_HOST'].dirname($this->config['app']['server']['SCRIPT_NAME']),'/');

		/* The GET method is default so controller methods look like openAction, others are handled directly openPostAction, openPutAction, openDeleteAction, etc... */
		$this->config['app']['raw request'] = ucfirst(strtolower($this->config['app']['server']['REQUEST_METHOD']));
		$this->config['app']['request'] = ($this->config['app']['raw request'] == $config['app']['default request type']) ? '' : $this->config['app']['raw request'];

		/* Merge Get, Post, Delete, Put into input */
		$rest = array();
		parse_str(file_get_contents('php://input'), $rest);
		$this->input = array_merge_recursive($this->config['app']['server'], $this->config['app']['get'], $this->config['app']['post'], $rest);

		/* get the uri (uniform resource identifier) */
		$this->config['app']['uri'] = $this->config['app']['raw uri'] = trim(urldecode(substr(parse_url($this->config['app']['server']['REQUEST_URI'],PHP_URL_PATH),strlen(dirname($this->config['app']['server']['SCRIPT_NAME'])))),'/');

		/* try to call hook if it's there */
		$this->trigger('preRouter');

		/* get the uri pieces */
		$segs = explode('/',$this->config['app']['uri']);

		/* If they didn't include a controller and method use the defaults  main & index */
		$this->config['app']['controller'] = (!empty($segs[0])) ? strtolower(array_shift($segs)) : $this->config['app']['default controller'];
		$this->config['app']['method'] = (!empty($segs[0])) ? strtolower(array_shift($segs)) : $this->config['app']['default method'];

		/* store what ever is left over in segs */
		$this->config['app']['segs'] = $segs;

		/* try to auto load the controller - will throw an error you must catch if it's not there */
		$this->config['app']['classname'] = $this->config['app']['controller'].$this->config['app']['controller suffix'];

		/* This throws a error and 4004 - handle it in your error handler */
		if (!class_exists($this->config['app']['classname'])) {
			throw new Exception($this->config['app']['classname'].' not found',4004);
		}

		/* try to call hook if it's there */
		$this->trigger('preController');

		$this->config['app']['main controller'] = new $this->config['app']['classname'];

		/* if we are just using this single file without all the rest we need some way to reference app */
		$this->config['app']['main controller']->app = $this;

		$this->config['app']['is ajax'] = isset($this->config['app']['server']['HTTP_X_REQUESTED_WITH']) && strtolower($this->config['app']['server']['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

		$ajax = ($this->config['app']['is ajax'] && $this->config['app']['include ajax']) ? $this->config['app']['include ajax'] : '';

		/* call the method - will throw an error you must catch if it's not there */
		$this->config['app']['called method'] = $this->config['app']['method'].$this->config['app']['request'].$ajax.$this->config['app']['method suffix'];

		/* This throws a error and 4005 - handle it in your error handler */
		if (!is_callable(array($this->config['app']['main controller'],$this->config['app']['called method']))) {
			throw new Exception($this->config['app']['classname'].' method '.$this->config['app']['called method'].' not found',4005);
		}

		/* try to call hook if it's there */
		$this->trigger('preMethod');

		$this->output = call_user_func_array(array($this->config['app']['main controller'],$this->config['app']['called method']),$this->config['app']['segs']);

		/* try to call hook before output is shown ie. cache, clean, parse, etc... )*/
		$this->trigger('preOutput');
		
		return $this->output;
	}
	
	/* Controller, Library, Model Autoloader */
	public function autoLoader($name) {
		if (substr($name,-strlen($this->config['app']['controller suffix'])) == $this->config['app']['controller suffix']) {
			$path = $this->config['app']['controller folder'];
		} else {
			$path = ($name{0} >= 'A' && $name{0} <='Z') ? $this->config['app']['libraries folder'] : $this->config['app']['models folder'];
		}

		$load = $path.'/'.strtolower($name).'.php';

		$isfound = false;

		if (file_exists($load)) {
			require_once($load);
			$isfound = true;
		}
		
		return $isfound;
	}

	public function trigger($trigger) {
		if (class_exists('Hooks')) {
			$hooks = new Hooks;
			$hooks->$trigger($this);
		}
	}

} /* end mvc controller class */

