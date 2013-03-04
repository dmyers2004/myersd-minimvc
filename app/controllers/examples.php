<?php

class examplesController extends basePublicController {

	public function __construct() {
		parent::__construct();
	}

	public function indexAction() {
		$this->view->Memory_get_peak_usage_TRUE = memory_get_peak_usage(TRUE)/1024;
		$this->view->Memory_get_peak_usage = memory_get_peak_usage()/1024;
		$this->view->Memory_get_usage_TRUE = memory_get_usage(TRUE)/1024;
		$this->view->Memory_get_usage = memory_get_usage()/1024;

		$this->view->partial('examples/index')->render();
	}

	public function errorAction() {
		throw new Exception('Big Error Message',1234);
	}

	/* get */
	public function testAction($a='',$b='') {
		$this->view->method = 'GET';
		$this->view->a = $a;
		$this->view->b = $b;
		$this->view->partial('examples/test')->render();
	}

	/* same but method is post */
	public function testPostAction($a='',$b='') {
		$this->view->method = 'POST';
		$this->view->a = $a;
		$this->view->b = $b;
	}

	public function menuAction() {
		$this->view->projectname = 'Example';
		$this->view->activemenu = 'Example';
		$this->view->menus = array('menua'=>'Menu A','menub'=>'Menu B','menuc'=>'Menu C','menud'=>'Menu D');
		$this->view->name = 'Joe Coffee';

		$this->view->partial('partial/nav','nav')->partial('examples/menu')->render();
	}

	public function jsonAction() {
		$this->view->set('data',array('name'=>'John Doe','age'=>21))->render('json');
	}

	public function unit_testAction() {
		$unit[] = '';
		$unit[] = 'main/welcome';
		$unit[] = 'main/error';
		$unit[] = 'main/test/Test/Man';
		$unit[] = 'main/menu';
		$unit[] = 'main/json';

		$this->view->unit = $unit;
		$this->view->render('unit_test');
	}

	public function pluginAction($input = '') {
		$this->view->input = (string) $input;
		$this->view->filter('bogus');
		$this->view->filter('stringer')->partial('examples/plugin')->render();
	}

	public function eventsAction($log='') {
		Events::trigger('xlog','Log this');
		Events::trigger('xlog','and Log this');
		Events::trigger('xlog','Sent In '.$log);
	}

}
