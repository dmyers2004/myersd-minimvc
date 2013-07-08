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

class mainController {

	public function indexAction() {
		return '<pre>mainController Loaded indexAction Run '.print_r($this,true);
	}
	
	public function helloAction($name) {
		return 'Hello '.$name;
	}
	
} /* end controller */
