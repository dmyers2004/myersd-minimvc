<?php
/**
* DMyers Super Simple MVC
*
* @package    Event file
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/
namespace myersd\core;

class event
{
	private $c;
	
	public $events = array();

	public function __construct(&$c)
	{
		$this->c = &$c;
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

} /* end event */
