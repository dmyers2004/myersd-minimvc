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

class mainController extends basePublicController {

	/*
	pass injected $app to parent to setup
	you could handle it here but by extending
	basePublicController I only need to write the logic once
	another base class could be baseAdminController or jsonPublicContoller
	which could also extend basePublicController for example
	*/
	public function __construct(&$app) {
		parent::__construct($app);
	}
	
	public function indexAction() {
		return '<h1>MainIndex</h1>';
	}
	
	public function indexPostAction() {
		return '<h1>MainPostIndex</h1>';	
	}
	
	public function helloAction($name) {
		return 'Hello '.$name;
	}
	
} /* end controller */
