<?php
/**
	* DMyers Super Simple MVC
	*
	* @package    Bootstrap File
	* @language   PHP
	* @author     Don Myers
	* @copyright  Copyright (c) 2011
	* @license    Released under the MIT License.
	*
	*/
namespace controllers;

class basePublicController {
	public $app;
	
	public function __construct(&$app) {
		$this->app = $app;
	}

} /* end controller */