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
		return '<pre>mainController Loaded indexAction Run '.print_r($this,true);
	}
	
	public function helloAction($name) {
		return 'Hello '.$name.'<pre>'.print_r($this->app,true);
	}
	
	public function viewAction() {
		
		return $this->app->View
			->set('body','<h2>This is the body</h2>')
			->load('layout');
	}
	
	public function dbAction() {
		echo '<pre>';

		$mPeople = new mPeople;

		$mPeople->keyword_id = mt_rand(1, 9999);
		$mPeople->hash = md5($mPeople->keyword_id);
		$mPeople->create();

		print_r($mPeople);

		var_dump($mPeople->count());
	}
	
	public function jsonAction() {
		return $this->app->View
			->set(array('name'=>'Don','age'=>42))
			->json($data);
	}
	
} /* end controller */
