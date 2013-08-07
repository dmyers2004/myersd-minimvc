<?php
namespace example\controllers;

class RedController extends \controllers\basePublicController {

	public function __construct(&$app) {
		parent::__construct($app);
	}
	
	public function indexAction() {
		return '<h1>RedController indexAction</h1>';
	}
	
	public function shoesAction() {
		return '<h1>RedController shoesAction</h1>';
	}
	
	public function inputAction($a=null) {
		return '<h1>RedController inputAction</h1><p>'.$a.'</p>';
	}

	public function input_moreAction($a=null,$b=null) {
		return '<h1>RedController input_moreAction</h1><p>'.$a.'</p><p>'.$b.'</p>';
	}

	
} /* end controller */
