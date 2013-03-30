<?php
class TestRouter extends PHPUnit_Framework_TestCase {  

	public $config;

	protected function setUp() {
		/* get our real class */
		require_once __DIR__.'/../app/libraries/router.php';
		
		/* get our mocks */
		require_once 'router_mocks/app.php';
		require_once 'router_mocks/config.php';
		
		$this->config = new MockConfig();
	}
	
	public function testBasic() {
		$app = new MockApp('main/controller','Get');
	
	  $router = new Router($app, $this->config);
		$router->route();

		$this->assertEquals($app->raw_uri, 'main/controller');
		$this->assertEquals($app->uri, 'main/controller');
		$this->assertEquals($app->raw_request, 'Get');
		$this->assertEquals($app->request, '');
  }

	public function testPutBasic() {
		$app = new MockApp('main/controller','Put');
	
	  $router = new Router($app, $this->config);
		$router->route();

		$this->assertEquals($app->raw_uri, 'main/controller');
		$this->assertEquals($app->uri, 'main/controller');
		$this->assertEquals($app->raw_request, 'Put');
		$this->assertEquals($app->request, 'Put');
  }

	public function testHello() {
		$app = new MockApp('hello/Joe','Get');
	
	  $router = new Router($app, $this->config);
		$router->route();

		$this->assertEquals($app->raw_uri, 'hello/Joe');
		$this->assertEquals($app->uri, 'main/hello/Joe');
		$this->assertEquals($app->raw_request, 'Get');
		$this->assertEquals($app->request, '');
  }

	public function testUnitTest() {
		$app = new MockApp('unit/test','Get');
	
	  $router = new Router($app, $this->config);
		$router->route();

		$this->assertEquals($app->raw_uri, 'unit/test');
		$this->assertEquals($app->uri, 'main/unit_test');
		$this->assertEquals($app->raw_request, 'Get');
		$this->assertEquals($app->request, '');
  }

	public function testComplex() {
		$app = new MockApp('complex/test/joe/black','Put');
	
	  $router = new Router($app, $this->config);
		$router->route();

		$this->assertEquals($app->raw_uri, 'complex/test/joe/black');
		$this->assertEquals($app->uri, 'main/complex/joe/black');
		$this->assertEquals($app->raw_request, 'Put');
		$this->assertEquals($app->request, 'Post');
  }

  protected function tearDown() {

  }

} /* end unit test */
