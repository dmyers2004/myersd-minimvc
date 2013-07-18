<?php
class Testapplication extends PHPUnit_Framework_TestCase {  

	protected function setUp() {
		ini_set('display_errors','On');
		error_reporting(E_ALL);
		
		define('PATH', realpath(__DIR__.'/../../'));
		define('HERE', realpath(__DIR__.'/../'));
		
		echo chr(10).'Application Path '.PATH.chr(10);
		echo 'Tests Path '.HERE.chr(10);
		
		/* go out and get the real application.php file */
		require_once PATH.'/app/application.php';
	}

  protected function tearDown() {

	}

	public function testBasic() {
	  require HERE.'/mocks/config.php';

	  $app = new application($config);
	  
		$this->assertEquals($app->config['app']['run code'], 'mock');
		$this->assertEquals($app->config['app']['handler'], 'mocker');
		$this->assertEquals($app->config['app']['default controller'], 'main');
		$this->assertEquals($app->config['app']['default method'], 'index');
		$this->assertEquals($app->config['app']['controller suffix'], 'Controller');
		$this->assertEquals($app->config['app']['method suffix'], 'Action');
		$this->assertEquals($app->config['app']['ajax prefix'], 'Ajax');
		$this->assertEquals($app->config['app']['folder'], '/Applications/MAMP/htdocs/basicmvc-template/app/');
  }

	public function xtestStandard() {
		$server = $this->default_server('/foo/bar/model/put','PUT',true);
		$server['HTTP_HOST'] = 'dev.somethingelse.com';
		
		$post = array(
			'name' => 'Joe',
			'thing' => 'Coffee',
		);
		
		$config = $this->default_config($server,array(),$post);
		$config['run code'] = 'debug';

	  $app = new application($config); 
		$this->assertEquals($app->run_code, 'debug');
		$this->assertTrue($app->is_ajax);
		$this->assertEquals($app->base_url, 'http://dev.somethingelse.com');
		$this->assertEquals($app->raw_uri, 'foo/bar/model/put');
		$this->assertEquals($app->uri, 'foo/bar/model/put');
		$this->assertEquals($app->raw_request, 'Put');
		$this->assertEquals($app->request, 'Put');
		$this->assertEquals($app->controller, 'foo');
		$this->assertEquals($app->method, 'bar');
		$this->assertEquals($app->segs, Array('model','put'));
		$this->assertEquals($app->input['name'], 'Joe');
		$this->assertEquals($app->input['thing'], 'Coffee');
		$this->assertInstanceOf('fooController',$app->main_controller);
  }  

	public function xtestOutput() {
		$server = $this->default_server('/main/foo');		
		$config = $this->default_config($server);

	  $app = new application($config);
		
		$this->assertEquals($app->raw_uri, 'main/foo');
		$this->assertEquals($app->uri, 'main/foo');
		$this->assertInstanceOf('mainController',$app->main_controller);
		$this->assertEquals($app->output, 'Bar');
	}

	public function xtestInput() {
		$server = $this->default_server('/main/fobo/John/Doe');
		$config = $this->default_config($server);

	  $app = new application($config);
		
		$this->assertEquals($app->raw_uri, 'main/fobo/John/Doe');
		$this->assertEquals($app->uri, 'main/fobo/John/Doe');
		$this->assertEquals($app->raw_request, 'Get');
		$this->assertEquals($app->request, '');
		$this->assertEquals($app->controller, 'main');
		$this->assertEquals($app->method, 'fobo');
		$this->assertEquals($app->segs, Array('John','Doe'));
		$this->assertEquals($app->output, 'A: John B: Doe');
	}

	public function xtestAjaxPut() {
		$server = $this->default_server('/main/foo/','PUT',true);

		$post = array();
		$post['a'] = 'Black';
		$post['b'] = 'Coffee';

		$config = $this->default_config($server,array(),$post);

	  $app = new application($config);

		$this->assertEquals($app->run_code, 'production');
		$this->assertTrue($app->is_ajax);
		$this->assertEquals($app->base_url, 'http://www.devlocal.com');
		$this->assertEquals($app->raw_uri, 'main/foo');
		$this->assertEquals($app->uri, 'main/foo');
		$this->assertEquals($app->raw_request, 'Put');
		$this->assertEquals($app->request, 'Put');
		$this->assertEquals($app->controller, 'main');
		$this->assertEquals($app->method, 'foo');
		$this->assertEquals($app->segs, Array());
		$this->assertInstanceOf('mainController', $app->main_controller);
		$this->assertEquals($app->input['a'], 'Black');
		$this->assertEquals($app->input['b'], 'Coffee');
		$this->assertEquals($app->output, 'A: Black B: Coffee');
	}

	/* helper functions */
	private function xdefault_config($server=array(),$get=array(),$post=array(),$files=array(),$cookies=array()) {
		$app_dir = realpath(__DIR__.'/application_mocks');
	
		return array(
			'run code' => 'production',
			'default controller' => 'main',
			'default method' => 'index',
			'server' => $server,
			'get' => $get,
			'post' => $post,
			'folder' => $app_dir.'/',
			'controller folder' => $app_dir.'/controllers',
			'libraries folder' => $app_dir.'/libraries',
			'models folder' => $app_dir.'/models',
			'controller suffix' => 'Controller',
			'method suffix' => 'Action',
			'default request type' => 'Get',
			'display errors' => 'On',
			'include ajax' => 'Ajax'
		);
	}
	
	private function xdefault_server($uri='/',$method='GET',$isajax=false) {
		return array(  	
			'HTTP_X_REQUESTED_WITH' => ($isajax) ? 'xmlhttprequest' : '',
			'SCRIPT_NAME' => '/index.php',
			'REQUEST_METHOD' => strtoupper($method),
			'REQUEST_URI' => $uri,
			'HTTP_HOST' => 'www.devlocal.com',
		);
	}

}