<?php
/**
	* DMyers Super Simple MVC
	*
	* @package    blue Controller File
	* @language   PHP
	* @author     Don Myers
	* @copyright  Copyright (c) 2011
	* @license    Released under the MIT License.
	*
	*/
namespace controllers;

class cookController extends basePublicController
{
	public function __construct(&$c)
	{
		parent::__construct($c);
	}

	public function indexAction()
	{
		return 'CookController indexAction';
	}

	public function setAction($key='',$value='')
	{
		$foo = $this->c['Response']->set_cookie($key,$value);
		
		return 'Done'.print_r($foo,true);
	}

	public function getAction($key='')
	{
		if ($key == '') {
			return print_r($this->c['Request']->cookie(),true);	
		}

		return $this->c['Request']->cookie($key);
	}

} /* end controller */
