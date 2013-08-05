<?php
/**
	* DMyers Super Simple MVC
	*
	* @package    base Controller File
	* @language   PHP
	* @author     Don Myers
	* @copyright  Copyright (c) 2011
	* @license    Released under the MIT License.
	*
	*/
namespace controllers;

class basePublicController
{
	public $c;

	public function __construct(&$c)
	{
		$this->c = &$c;
	}

} /* end controller */
