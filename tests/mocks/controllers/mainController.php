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
		return '<h1>MainIndex</h1>';
	}
	
	public function indexPostAction() {
		return '<h1>MainPostIndex</h1>';	
	}
	
	public function helloAction($name) {
		return 'Hello '.$name;
	}
	
	public function viewAction() {
		/* you could do this in basePublicController construct or with a hook */
		new View($this->app);
		$this->app->View->set('baseurl',$this->app->config['app']['base url'],'#');

		return $this->app->View
			->set('body','<h2>This is the body</h2>')
			->load('layout');
	}
	
	public function dbAction() {
		/* you could do this in basePublicController construct or with a hook */
		new Database($this->app);
		
		echo '<pre>';

		$mPeople = new mPeople;

		$mPeople->keyword_id = mt_rand(1, 9999);
		$mPeople->hash = md5($mPeople->keyword_id);
		$mPeople->create();

		print_r($mPeople);

		var_dump($mPeople->count());
	}
	
	public function jsonAction() {
		/* you could do this in basePublicController construct or with a hook */
		new View($this->app);
		
		return $this->app->View
			->set(array('name'=>'Don','age'=>42))
			->json($data);
	}
	
} /* end controller */
