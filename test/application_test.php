<?php

require_once(dirname(__FILE__) . '/simpletest/autorun.php');  

/* include our application.php class */
require_once('../app/application.php');

class TestApplication extends UnitTestCase {  
	function testServerBasic() {
		
		$config = $this->default_config();
	
	  $app = new Application($config);

		$this->assertEqual($app->run_code, 'production');
		$this->assertFalse($app->is_ajax);
		$this->assertEqual($app->base_url, 'http:');
		$this->assertEqual($app->raw_uri, '');
		$this->assertEqual($app->uri, '');
		$this->assertEqual($app->raw_request, '');
		$this->assertEqual($app->request, '');
		$this->assertEqual($app->controller, 'main');
		$this->assertEqual($app->method, 'index');
		$this->assertEqual($app->segs, Array(0 => ''));
		$this->assertIsA($app->main_controller, 'mainController');
  }

	function testServerStandard() {
		$server = $this->default_server('/foo/bar/model/put','PUT',true);
		$server['HTTP_HOST'] = 'dev.somethingelse.com';
		
		$post = array(
			'name' => 'Joe',
			'thing' => 'Coffee',
		);
		
		$config = $this->default_config($server,array(),$post);
		$config['run code'] = 'debug';

	  $app = new Application($config);  
		$this->assertEqual($app->run_code, 'debug');
		$this->assertTrue($app->is_ajax);
		$this->assertEqual($app->base_url, 'http://dev.somethingelse.com');
		$this->assertEqual($app->raw_uri, 'foo/bar/model/put');
		$this->assertEqual($app->uri, 'foo/bar/model/put');
		$this->assertEqual($app->raw_request, 'Put');
		$this->assertEqual($app->request, 'Put');
		$this->assertEqual($app->controller, 'foo');
		$this->assertEqual($app->method, 'bar');
		$this->assertEqual($app->segs, Array('model','put'));
		$this->assertEqual($app->input['name'], 'Joe');
		$this->assertEqual($app->input['thing'], 'Coffee');
		$this->assertIsA($app->main_controller, 'fooController');
  }  

	function testBasicOutput() {
		$server = $this->default_server('/main/foo');		
		$config = $this->default_config($server);

	  $app = new Application($config);
		
		$this->assertEqual($app->raw_uri, 'main/foo');
		$this->assertEqual($app->uri, 'main/foo');
		$this->assertIsA($app->main_controller, 'mainController');
		$this->assertEqual($app->output, 'Bar');
	}

	function testBasicInput() {
		$server = $this->default_server('/main/fobo/John/Doe');
		$config = $this->default_config($server);

	  $app = new Application($config);
		
		$this->assertEqual($app->raw_uri, 'main/fobo/John/Doe');
		$this->assertEqual($app->uri, 'main/fobo/John/Doe');
		$this->assertEqual($app->raw_request, 'Get');
		$this->assertEqual($app->request, '');
		$this->assertEqual($app->controller, 'main');
		$this->assertEqual($app->method, 'fobo');
		$this->assertEqual($app->segs, Array('John','Doe'));
		$this->assertEqual($app->output, 'A: John B: Doe');
	}

	function testAjaxPut() {
		$server = $this->default_server('/main/ajax/','PUT',true);

		$post = array();
		$post['a'] = 'Black';
		$post['b'] = 'Coffee';

		$config = $this->default_config($server,array(),$post);

	  $app = new Application($config);

		$this->assertEqual($app->run_code, 'production');
		$this->assertTrue($app->is_ajax);
		$this->assertEqual($app->base_url, 'http://www.devlocal.com');
		$this->assertEqual($app->raw_uri, 'main/ajax');
		$this->assertEqual($app->uri, 'main/ajax');
		$this->assertEqual($app->raw_request, 'Put');
		$this->assertEqual($app->request, 'Put');
		$this->assertEqual($app->controller, 'main');
		$this->assertEqual($app->method, 'ajax');
		$this->assertEqual($app->segs, Array());
		$this->assertIsA($app->main_controller, 'mainController');
		$this->assertEqual($app->input['a'], 'Black');
		$this->assertEqual($app->input['b'], 'Coffee');
		$this->assertEqual($app->output, 'A: Black B: Coffee');
	}

	/* helper functions */
	public function default_config($server=array(),$get=array(),$post=array(),$files=array(),$cookies=array()) {
		$app_dir = realpath(__DIR__.'/application_mocks');
	
		return array(
			'run code' => 'production',
			'default controller' => 'main',
			'default method' => 'index',
			'server' => $server,
			'get' => $get,
			'post' => $post,
			'path' => $app_dir.'/',
			'controller folder' => $app_dir.'/controllers',
			'libraries folder' => $app_dir.'/libraries',
			'models folder' => $app_dir.'/models',
			'controller suffix' => 'Controller',
			'method suffix' => 'Action',
			'default request type' => 'Get',
		);
	}
	
	public function default_server($uri='/',$method='GET',$isajax=false) {
		return array(  	
			'HTTP_X_REQUESTED_WITH' => ($isajax) ? 'xmlhttprequest' : '',
			'SCRIPT_NAME' => '/index.php',
			'REQUEST_METHOD' => strtoupper($method),
			'REQUEST_URI' => $uri,
			'HTTP_HOST' => 'www.devlocal.com',
		);
	}

}