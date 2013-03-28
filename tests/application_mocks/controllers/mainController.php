<?php

class mainController {

	public function indexAction() {
	
	}
	
	public function fooAction() {
		return 'Bar';
	}
	
	public function foboAction($a='',$b='') {
		return 'A: '.$a.' B: '.$b;
	}

	public function fooPutAjaxAction() {
		return 'A: '.$this->app->input['a'].' B: '.$this->app->input['b'];
	}

}