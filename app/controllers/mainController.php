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

	public function __construct() {
		parent::__construct();
	}
	
	public function indexAction() {
		return '<pre>mainController Loaded indexAction Run '.print_r($this,true);
	}
	
	public function helloAction($name) {
		return 'Hello '.$name;
	}
	
	public function viewAction($name=null) {
		
		return $this->app->View
			->set('body',$name)
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
	
} /* end controller */
