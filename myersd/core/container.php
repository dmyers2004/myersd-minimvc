<?php
/**
* DMyers Super Simple MVC
*
* @package    Container file
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/
namespace myersd\core;

class container
{
	protected $container = array();

	public function __set($key, $val)
	{
		$this->container[$key] = $val;
	}

	public function __get($key)
	{
		return $this->container[$key];
	}

	public function set($path,$val)
	{
		/* cheap and fast 4 levels */
		$parts = explode('\\', $path);
		
		switch (count($parts)) {
			case 1:
				$this->container[$parts[0]] = &$val;
			break;
			case 2:
				$this->container[$parts[0]][$parts[1]] = &$val;
			break;
			case 3:
				$this->container[$parts[0]][$parts[1]][$parts[2]] = &$val;
			break;
			case 4:
				$this->container[$parts[0]][$parts[1]][$parts[2]][$parts[3]] = &$val;
			break;
		}			

		return $this;
	}
	
} /* end container */
