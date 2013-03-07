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
		return 'mainController Loaded indexAction Run';
	}
	
	public function helloAction($name) {
		return 'Hello '.$name;
	}
	
} /* end controller */
