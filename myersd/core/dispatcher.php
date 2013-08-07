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
		$this->segs = explode('/',$this->c->Router->route);

		/* classname seg1 (Controller) */
		$this->className = str_replace('-','_',array_shift($this->segs));

		/* method seg2 */
		$this->methodName = str_replace('-','_',array_shift($this->segs));

		/* call event */
		$this->c->Event->preController();

		/* This throws a error and 4004 - handle it in your error handler */
		if (!class_exists($this->className)) {
			throw new \Exception($this->className.' not found',4004);
		}

		/* create new controller inject the container */
		$controller = new $this->className($this->c);

		/* call dispatch event */
		$this->c->Event->preMethod();

		/* This throws a error and 4005 - handle it in your error handler */
		if (!is_callable(array($controller,$this->methodName))) {
			throw new \Exception($this->className.' method '.$this->methodName.' not found',4005);
		}

		/* let's call our method and capture the output */
		$this->c->Response->body .= call_user_func_array(array($controller,$this->methodName),$this->segs);
	}

} /* end dispatcher */
