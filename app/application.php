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
		/* set output */
		$this->output = '';
		
		/* setup input */
		$this->input = $config['app']['input'];
		
		/* clear out input in config to save memory and not have a 2nd copy */
		unset($config['app']['input']);
		
		/* setup config */
		$this->config = &$config;
	}

	public function run() {
		/* Turn off all by default */
		error_reporting(0);

		/* register the autoloader */
		spl_autoload_register(array($this,'autoLoader'));

		/* try to call hook if it's there */
		$this->trigger('startup');

		/* what is the protocal http or https? this could be useful! */
		$this->config['app']['is https'] = (strstr('https',$this->input['server']['SERVER_PROTOCOL']) === TRUE);

		/* what is the base url */
		$this->config['app']['base url'] = ($this->config['app']['is https'] ? 'https' : 'http').'://'.trim($this->input['server']['HTTP_HOST'].dirname($this->input['server']['SCRIPT_NAME']),'/');

		/* The GET method is default so controller methods look like openAction, others are handled directly openPostAction, openPutAction, openDeleteAction, etc... */
		$this->config['app']['request'] = ucfirst(strtolower($this->input['server']['REQUEST_METHOD']));

		/* if you don't want different method call for ajax turn this off in preRouter */
		$this->config['app']['is ajax'] = isset($this->input['server']['HTTP_X_REQUESTED_WITH']) && strtolower($this->input['server']['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

		/* get the uri (uniform resource identifier) */
		$this->config['app']['uri'] = trim(urldecode(substr(parse_url($this->input['server']['REQUEST_URI'],PHP_URL_PATH),strlen(dirname($this->input['server']['SCRIPT_NAME'])))),'/');

		/* get the raw uri pieces */
		$segs = explode('/',$this->config['app']['uri']);

		/* If they didn't include a controller and method use the defaults  main & index */
		$controller = (!empty($segs[0])) ? strtolower(array_shift($segs)) : $this->config['app']['default controller'];
		$method = (!empty($segs[0])) ? strtolower(array_shift($segs)) : $this->config['app']['default method'];

		/* what are we looking for? raw route will also contain the "raw" pre router route incase you need it */
		$this->config['app']['route'] = $this->config['app']['raw route'] = rtrim($controller.$this->config['app']['controller suffix'].'/'.$method.($this->config['app']['is ajax'] ? $this->config['app']['ajax prefix'] : '').$this->config['app']['request'].$this->config['app']['method suffix'].'/'.implode('/',$segs),'/');

		/* try to call hook if it's there */
		$this->trigger('preRouter');

		/* run our router http://www.example.com/main/index/a/b/c = mainController/indexGet[Ajax]Action/a/b/c */
		foreach ($this->config['app']['routes'] as $regex_path => $switchto) {
			if (preg_match($regex_path, $this->config['app']['raw route'])) {
				$this->config['app']['route'] = preg_replace($regex_path, $switchto, $this->config['app']['raw route']);
				break;
			}
		}

		/* ok let's explode our post router route */
		$segs = explode('/',$this->config['app']['route']);

		/* new routed classname and called method */
		$this->config['app']['classname'] = array_shift($segs);
		
		/* new method to call on classname */
		$this->config['app']['called method'] = array_shift($segs);

		/* store what ever is left over in segs */
		$this->config['app']['segs'] = $segs;

		/* try to call hook if it's there */
		$this->trigger('preController');

		/* This throws a error and 4004 - handle it in your error handler */
		if (!class_exists($this->config['app']['classname'])) {
			throw new Exception($this->config['app']['classname'].' not found',4004);
		}

		/* create new controller inject $app ($this) */	
		$main_controller = new $this->config['app']['classname']($this);

		/* try to call hook if it's there */
		$this->trigger('preMethod');

		/* This throws a error and 4005 - handle it in your error handler */
		if (!is_callable(array($main_controller,$this->config['app']['called method']))) {
			throw new Exception($this->config['app']['classname'].' method '.$this->config['app']['called method'].' not found',4005);
		}

		/* let's call our method and capture the output */
		$this->output = call_user_func_array(array($main_controller,$this->config['app']['called method']),$this->config['app']['segs']);

		/* try to call hook before output is shown ie. cache, clean, parse, etc... )*/
		$this->trigger('preOutput');

		/* return it to index.php for final echo */
		return $this->output;
	}

	/* Controller, Library, Model Autoloader */
	public function autoLoader($name) {
		if (substr($name,-strlen($this->config['app']['controller suffix'])) == $this->config['app']['controller suffix']) {
			$path = $this->config['app']['folders']['controllers'];
		} else {
			$path = ($name{0} >= 'A' && $name{0} <='Z') ? $this->config['app']['folders']['libraries'] : $this->config['app']['folders']['models'];
			$name = strtolower($name);
		}

		$load = $path.$name.'.php';

		$isfound = FALSE;

		if (file_exists($load)) {
			require_once($load);
			$isfound = TRUE;
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