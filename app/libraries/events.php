<?php

namespace libraries;

class events {

	public $events = array();

	public function __construct(&$c) {
		$c['events'] = $this; /* assign a copy of me to the application */
	}

	public function register($event,$callback) {
		$this->events[$event][get_class($callback[0]).'->'.$callback[1]] = $callback;
	}

	public function trigger($event,$data='') {
		$returned = array();

		if ($this->has_event($event)) {
			foreach ($this->events[$event] as $event) {
				if (is_callable($event)) {
					$returned[] = call_user_func($event, $data);
				}
			}
		}

		return $returned;
	}

	public function has_event($event) {
		return (isset($this->events[$event]) && count($this->events[$event]) > 0);
	}

}

/* end events */