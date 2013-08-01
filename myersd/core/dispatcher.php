<?php
/**
* DMyers Super Simple MVC
*
* @package    Dispatch file
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/
namespace myersd\core;

class dispatcher
{
	public $events = array();
	public $c;

	public function __construct(&$c)
	{
		$this->c = &$c;

		/* NOTE: don't switch anything here - switch them in startup.php! */

		/* Set default timezone of server so PHP doesn't complain */
		date_default_timezone_set('UTC');

		/* turn off error by default */
		error_reporting(0);
	}

	public function dispatch()
	{
		/* what is the protocal http or https? this could be useful! */
		$this->c['config']['dispatcher']['is https'] = (strstr('https',$this->c['input']['server']['SERVER_PROTOCOL']) === TRUE);

		/* what is the base url */
		$this->c['config']['dispatcher']['base url'] = ($this->c['config']['dispatcher']['is https'] ? 'https' : 'http').'://'.trim($this->c['input']['server']['HTTP_HOST'].dirname($this->c['input']['server']['SCRIPT_NAME']),'/');

		/* The GET method is default so controller methods look like openAction, others are handled directly openPostAction, openPutAction, openDeleteAction, etc... */
		$this->c['config']['dispatcher']['request'] = ucfirst(strtolower($this->c['input']['server']['REQUEST_METHOD']));

		/* Is this a ajax request? */
		$this->c['config']['dispatcher']['is ajax'] = isset($this->c['input']['server']['HTTP_X_REQUESTED_WITH']) && strtolower($this->c['input']['server']['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

		/* get the uri (uniform resource identifier) */
		$this->c['config']['dispatcher']['uri'] = trim(urldecode(substr(parse_url($this->c['input']['server']['REQUEST_URI'],PHP_URL_PATH),strlen(dirname($this->c['input']['server']['SCRIPT_NAME'])))),'/');

		/* what are we looking for? raw route will also contain the "raw" pre router route incase you need it */
		$this->c['config']['dispatcher']['route'] = $this->c['config']['dispatcher']['route raw'] = '/'.($this->c['config']['dispatcher']['is ajax'] ? 'Ajax' : '').'/'.$this->c['config']['dispatcher']['request'].'/'.$this->c['config']['dispatcher']['uri'];

		/* call dispatch event */
		$this->trigger('preRouter');

		/* rewrite dispatch route */
		foreach ($this->c['config']['dispatcher']['routes'] as $regexpath => $switchto) {
			if (preg_match($regexpath, $this->c['config']['dispatcher']['route'])) {
				/* we got a match */
				$this->c['config']['dispatcher']['route'] = preg_replace($regexpath, $switchto, $this->c['config']['dispatcher']['route']);
				$this->c['config']['dispatcher']['route matched'] = $regexpath;
				break;
			}
		}

		/* ok let's explode our post router route */
		$segs = explode('/',$this->c['config']['dispatcher']['route']);

		/* new routed classname (Controller) */
		$this->c['config']['dispatcher']['classname'] = str_replace('-','_',array_shift($segs));

		/* new method to call on classname (Method or Action) replace dashes with underscores */
		$this->c['config']['dispatcher']['called method'] = str_replace('-','_',array_shift($segs));

		/* store whatever is left over in segs */
		$this->c['config']['dispatcher']['segs'] = $segs;

		/* call dispatch event */
		$this->trigger('preController');

		/* This throws a error and 4005 - handle it in your error handler */
		if (!class_exists($this->c['config']['dispatcher']['classname'])) {
			throw new \Exception($this->c['config']['dispatcher']['classname'].' not found',4004);
		}

		/* create new controller inject the container */
		$main_controller = new $this->c['config']['dispatcher']['classname']($this->c);

		/* call dispatch event */
		$this->trigger('preMethod');

		/* This throws a error and 4005 - handle it in your error handler */
		if (!is_callable(array($main_controller,$this->c['config']['dispatcher']['called method']))) {
			throw new \Exception($this->c['config']['dispatcher']['classname'].' method '.$this->c['config']['dispatcher']['called method'].' not found',4005);
		}

		/* let's call our method and capture the output */
		$this->c['output'] = call_user_func_array(array($main_controller,$this->c['config']['dispatcher']['called method']),$this->c['config']['dispatcher']['segs']);

		/* call dispatch event */
		$this->trigger('preOutput');
	}

	public function register($event,$callback)
	{
		$this->events[$event][get_class($callback[0]).'->'.$callback[1]] = $callback;
	}

	public function trigger($event)
	{
		$returned = array();

		if ($this->has_event($event)) {
			foreach ($this->events[$event] as $event) {
				if (is_callable($event)) {
					$returned[] = call_user_func_array($event, array(&$this->c));
				}
			}
		}

		return $returned;
	}

	public function has_event($event)
	{
		return (isset($this->events[$event]) && count($this->events[$event]) > 0);
	}

} /* end dispatcher */
