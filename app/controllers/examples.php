<?php

class examplesController extends basePublicController {

	public function indexAction() {
		$this->View->sitename = 'Most Basic Example';
		$this->View->Memory_get_peak_usage_TRUE = memory_get_peak_usage(TRUE)/1024;
		$this->View->Memory_get_peak_usage = memory_get_peak_usage()/1024;
		$this->View->Memory_get_usage_TRUE = memory_get_usage(TRUE)/1024;
		$this->View->Memory_get_usage = memory_get_usage()/1024;

		$this->View->partial('examples/index')->render();
	}

	public function errorAction() {
		throw new Exception('Big Error Message',1234);
	}

	/* get */
	public function testAction($a='',$b='') {
		$this->View->method = 'GET';
		$this->View->a = $a;
		$this->View->b = $b;
		$this->View->partial('examples/test')->render();
	}

	/* same but method is post */
	public function testPostAction($a='',$b='') {
		$this->View->method = 'POST';
		$this->View->a = $a;
		$this->View->b = $b;
	}

	public function menuAction() {
		$this->View->projectname = 'Example';
		$this->View->activemenu = 'Example';
		$this->View->menus = array('menua'=>'Menu A','menub'=>'Menu B','menuc'=>'Menu C','menud'=>'Menu D');
		$this->View->name = 'Joe Coffee';

		$this->View->partial('partial/nav','nav')->partial('examples/menu')->render();
	}

	public function jsonAction() {
		$this->View->set('data',array('name'=>'John Doe','age'=>21))->render('json');
	}

	public function unit_testAction() {
		$unit[] = '';
		$unit[] = 'main/welcome';
		$unit[] = 'main/error';
		$unit[] = 'main/test/Test/Man';
		$unit[] = 'main/menu';
		$unit[] = 'main/json';

		$this->View->unit = $unit;
		$this->View->render('unit_test');
	}

	public function pluginAction($input = '') {
		$this->View->input = (string) $input;
		$this->View->filter('bogus');
		$this->View->filter('stringer')->partial('examples/plugin')->render();
	}

	public function eventsAction($log='') {
		Events::trigger('xlog','Log this');
		Events::trigger('xlog','and Log this');
		Events::trigger('xlog','Sent In '.$log);
	}

}
