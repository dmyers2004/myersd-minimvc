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
		echo('mainController Loaded indexAction Run<pre>');
		print_r($this->App);
	}

} /* end controller */
