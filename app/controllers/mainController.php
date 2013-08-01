<?php
/**
	* DMyers Super Simple MVC
	*
	* @package    main Controller File
	* @language   PHP
	* @author     Don Myers
	* @copyright  Copyright (c) 2011
	* @license    Released under the MIT License.
	*
	*/
namespace controllers;

class mainController extends basePublicController {

	/*
	pass in container
	I then pass it to the base controller but there doesn't have to be one.
	I could just store it locally here but,
	by extending base classes I can inherit a number of methods etc...
	*/
	public function __construct(&$c) {
		parent::__construct($c);
	}
	
	public function indexAction() {
		return 'Hello World';
		//return '<pre>mainController Loaded indexAction Run '.print_r($this->c,true);
	}
	
	public function helloAction($name) {
		return 'Hello '.$name.'<pre>'.print_r($this->c,true);
	}
	
	public function viewAction() {
		/* you could create the view object in basePublicController construct or within a hook */
		new \myersd\libraries\view($this->c);
		
		$this->c['view']->set('baseurl',$this->c['config']['dispatch']['base url'],'#');

		return $this->c['view']
			->set('body','<h2>This is the body</h2>')
			->load('layout');
	}
	
	public function dbAction() {
		/* you could do this in basePublicController construct or with a hook */
		new \myersd\libraries\database($this->c);
		
		echo '<pre>';

		$mPeople = new \models\mpeople;

		$mPeople->keyword_id = mt_rand(1, 9999);
		$mPeople->hash = md5($mPeople->keyword_id);
		$mPeople->create();

		print_r($mPeople);

		var_dump($mPeople->count());
	}
	
	public function jsonAction() {
		/* you could do this in basePublicController construct or with a hook */
		new \myersd\libraries\view($this->c);
		
		return $this->c['view']
			->set(array('name'=>'Don','age'=>42))
			->json($data);
	}
	
} /* end controller */
