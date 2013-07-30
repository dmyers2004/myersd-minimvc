<?php
namespace example\controllers;

class RedController extends \controllers\basePublicController {

	public function __construct(&$app) {
		parent::__construct($app);
	}
	
	public function indexAction() {
		return '<h1>Red Index</h1><pre>'.print_r($this,true);
	}
	
	public function shoesAction() {
		return '<h1>Red Shoes</h1><pre>'.print_r($this,true);
	}
	
	public function inputAction($a=null) {
		return '<h1>Red inputAction</h1><p>'.$a.'</p><pre>'.print_r($this,true);
	}

	public function input_moreAction($a=null,$b=null) {
		return '<h1>Red inputAction</h1><p>'.$a.'</p><p>'.$b.'</p><pre>'.print_r($this,true);
	}

	
} /* end controller */
