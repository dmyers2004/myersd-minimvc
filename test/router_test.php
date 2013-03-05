<?php

require_once(dirname(__FILE__) . '/simpletest/autorun.php');  

/* include our application.php class */
require_once('../app/libraries/router.php');

class TestRouter extends UnitTestCase {  

	function testBasic() {
		$app = new MockApp('main/controller','Get');
		$config = new MockConfig();
	
	  $router = new Router($app, $config);
		$router->route();

		$this->assertEqual($app->raw_uri, 'main/controller');
		$this->assertEqual($app->uri, 'main/controller');
		$this->assertEqual($app->raw_request, 'Get');
		$this->assertEqual($app->request, '');
  }

	function testPutBasic() {
		$app = new MockApp('main/controller','Put');
		$config = new MockConfig();
	
	  $router = new Router($app, $config);
		$router->route();

		$this->assertEqual($app->raw_uri, 'main/controller');
		$this->assertEqual($app->uri, 'main/controller');
		$this->assertEqual($app->raw_request, 'Put');
		$this->assertEqual($app->request, 'Put');
  }

	function testHello() {
		$app = new MockApp('hello/Joe','Get');
		$config = new MockConfig();
	
	  $router = new Router($app, $config);
		$router->route();

		$this->assertEqual($app->raw_uri, 'hello/Joe');
		$this->assertEqual($app->uri, 'main/hello/Joe');
		$this->assertEqual($app->raw_request, 'Get');
		$this->assertEqual($app->request, '');
  }

	function testUnitTest() {
		$app = new MockApp('unit/test','Get');
		$config = new MockConfig();
	
	  $router = new Router($app, $config);
		$router->route();

		$this->assertEqual($app->raw_uri, 'unit/test');
		$this->assertEqual($app->uri, 'main/unit_test');
		$this->assertEqual($app->raw_request, 'Get');
		$this->assertEqual($app->request, '');
  }

	function testComplex() {
		$app = new MockApp('complex/test/joe/black','Put');
		$config = new MockConfig();
	
	  $router = new Router($app, $config);
		$router->route();

		$this->assertEqual($app->raw_uri, 'complex/test/joe/black');
		$this->assertEqual($app->uri, 'main/complex/joe/black');
		$this->assertEqual($app->raw_request, 'Put');
		$this->assertEqual($app->request, 'Post');
  }

} /* end unit test */

class MockApp {

	public function __construct($raw_uri,$raw_request) {
		$this->uri = $this->raw_uri = $raw_uri;
		$this->request = $this->raw_request = $raw_request;
	}
	
} /* end MockApp */

class MockConfig {

	public function get($name,$key,$default=null) {
		if ($key == 'routes') {
			return array(
				'#^hello/(.*)$#i' => 'main/hello/$1',
				'#^unit/test$#i' => 'main/unit_test',
				'#^user/(.*)$#i' => 'main/user/$1',
				'#^app/test(.*)#i' => 'main/index/$1',
				'#^app(.*)$#i' => 'main/app$1',
				'#^rest/(.*)$#i' => 'rest/index/$1',
				'#^complex/test(.*)$#i' => 'main/complex$1',
			);
		}
		
		if ($key == 'requests') {
			return array(
				'#^Get(.*)$#i' => '',
				'#^Put/main/complex(.*)$#i' => 'Post'
			);
		}

	}

} /* end MockConfig */