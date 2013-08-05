<?php
/**
* DMyers Super Simple MVC
*
* @package    Dispatcher file
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

		/* what is the protocal http or https? this could be useful! */
		$this->is_https = (strstr('https',$this->c['request']['server']['SERVER_PROTOCOL']) === TRUE);

		/* Is this a ajax request? */
		$this->is_ajax = isset($this->c['request']['server']['HTTP_X_REQUESTED_WITH']) && strtolower($this->c['request']['server']['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
	}

	public function dispatch()
	{
		/* what is the base url */
		$this->base_url = ($this->c['dispatcher']['is https'] ? 'https' : 'http').'://'.trim($this->c['request']['server']['HTTP_HOST'].dirname($this->c['request']['server']['SCRIPT_NAME']),'/');

		/* The GET method is default so controller methods look like openAction, others are handled directly openPostAction, openPutAction, openDeleteAction, etc... */
		$this->request = ucfirst(strtolower($this->c['request']['server']['REQUEST_METHOD']));

		/* get the uri (uniform resource identifier) */
		$this->uri = trim(urldecode(substr(parse_url($this->c['request']['server']['REQUEST_URI'],PHP_URL_PATH),strlen(dirname($this->c['request']['server']['SCRIPT_NAME'])))),'/');

		/* what are we looking for? raw route will also contain the "raw" pre router route incase you need it */
		$this->route = $this->route_raw = ($this->is_https ? 'https' : 'http').'/'.($this->is_ajax ? 'Ajax' : '').'/'.$this->request.'/'.$this->uri;

		/* call dispatch event */
		$this->trigger('preRouter');

		/* rewrite dispatch route */
		foreach ($this->c['dispatcher']['routes'] as $regexpath => $switchto) {
			if (preg_match($regexpath, $this->route)) {
				/* we got a match */
				$this->route = preg_replace($regexpath, $switchto, $this->route);
				$this->route_matched = $regexpath;
				break;
			}
		}

		/* ok let's explode our post router route */
		$this->segs = explode('/',$this->route);

		/* new routed classname (Controller) */
		$this->classname = str_replace('-','_',array_shift($this->segs));

		/* new method to call on classname (Method or Action) replace dashes with underscores */
		$this->called_method = str_replace('-','_',array_shift($this->segs));

		/* call dispatch event */
		$this->trigger('preController');

		/* This throws a error and 4005 - handle it in your error handler */
		if (!class_exists($this->classname)) {
			throw new \Exception($this->classname.' not found',4004);
		}

		/* create new controller inject the container */
		$main_controller = new $this->classname($this->c);

		/* call dispatch event */
		$this->trigger('preMethod');

		/* This throws a error and 4005 - handle it in your error handler */
		if (!is_callable(array($main_controller,$this->called_method))) {
			throw new \Exception($this->classname.' method '.$this->called_method.' not found',4005);
		}

		/* let's call our method and capture the output */
		$this->c['response'] = call_user_func_array(array($main_controller,$this->called_method),$this->segs);

		/* call dispatch event */
		$this->trigger('preOutput');
	}

	public function register($event,$callback,$priority=10)
	{
		$this->events[$event][$priority][get_class($callback[0]).'->'.$callback[1]] = $callback;
	}

	public function trigger($event)
	{
		$returned = array();

		if ($this->has_event($event)) {
			ksort($this->events[$event]);
			foreach ($this->events[$event] as $priority) {
				foreach ($priority as $event) {
					if (is_callable($event)) {
						$returned[] = call_user_func_array($event, array(&$this->c));
					}
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
