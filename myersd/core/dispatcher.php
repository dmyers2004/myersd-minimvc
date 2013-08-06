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
	private $c;

	public function __construct(&$c)
	{
		$this->c = &$c;
	}

	public function dispatch()
	{
		/* ok let's explode our post router route */
		$this->segs = explode('/',$this->c['Router']->route);

		/* new routed classname (Controller) */
		$this->classname = str_replace('-','_',array_shift($this->segs));

		/* new method to call on classname (Method or Action) replace dashes with underscores */
		$this->called_method = str_replace('-','_',array_shift($this->segs));

		/* call dispatch event */
		$this->c['Event']->trigger('preController');

		/* This throws a error and 4005 - handle it in your error handler */
		if (!class_exists($this->classname)) {
			throw new \Exception($this->classname.' not found',4004);
		}

		/* create new controller inject the container */
		$main_controller = new $this->classname($this->c);

		/* call dispatch event */
		$this->c['Event']->trigger('preMethod');

		/* This throws a error and 4005 - handle it in your error handler */
		if (!is_callable(array($main_controller,$this->called_method))) {
			throw new \Exception($this->classname.' method '.$this->called_method.' not found',4005);
		}

		/* let's call our method and capture the output */
		$this->c['Response']->body = call_user_func_array(array($main_controller,$this->called_method),$this->segs);
	}

} /* end dispatcher */
