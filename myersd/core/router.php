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

class router
{
	private $c;

	public $route;
	public $route_raw;
	public $route_matched;

	public function __construct(&$c)
	{
		$this->c = &$c;
	}

	public function route()
	{
		/* build our route format */
		$this->route = $this->route_raw = ($this->c->Request->is_https ? 'https' : 'http').'/'.($this->c->Request->is_ajax ? 'Ajax' : '').'/'.$this->c->Request->request.'/'.$this->c->Request->uri;

		/* call dispatch event */
		$this->c->Event->preRouter();

		/* rewrite dispatch route */
		foreach ($this->c->router['routes'] as $regexpath => $switchto) {
			if (preg_match($regexpath, $this->route)) {
				/* we got a match */
				$this->route = preg_replace($regexpath, $switchto, $this->route);
				$this->route_matched = $regexpath;
				break;
			}
		}

		/* call dispatch event */
		$this->c->Event->postRouter();

	}

} /* end router */
