<?php
class Testapplication extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		ini_set('display_errors','On');
		error_reporting(E_ALL);

		if (!defined('PATH')) {
			define('PATH', realpath(__DIR__.'/../../'));
			define('HERE', realpath(__DIR__.'/../'));
			echo chr(10).'Application Path '.PATH.chr(10);
			echo 'Tests Path '.HERE.chr(10);
		}

		/* go out and get the real application.php file */
		require_once PATH.'/app/application.php';
	}

  protected function tearDown() {

	}

	public function testConfig() {
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

	public function testEmpty() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';

	  $app = new application($config);

		$this->assertEquals($app->run(),'<h1>MainIndex</h1>');
  }

  public function testMain() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['config']['uri'] = 'main';

	  $app = new application($config);

		$this->assertEquals($app->run(),'<h1>MainIndex</h1>');
  }

  public function testMainIndex() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['config']['uri'] = 'main/index';

	  $app = new application($config);

		$this->assertEquals($app->run(),'<h1>MainIndex</h1>');
  }

  public function testBlue() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['input']['server']['REQUEST_URI'] = '/blue';

	  $app = new application($config);

		$this->assertEquals($app->run(),'<h1>BlueIndex</h1>');
  }

  public function testBlueShoes() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['input']['server']['REQUEST_URI'] = '/blue/shoes';

	  $app = new application($config);

		$this->assertEquals($app->run(),'<h1>BlueShoes</h1>');
  }

  public function testBlueShoes2() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['input']['server']['REQUEST_URI'] = '/BlUe/';

	  $app = new application($config);

		$this->assertEquals($app->run(),'<h1>BlueIndex</h1>');
  }

  public function testBlueShoes3() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['input']['server']['REQUEST_URI'] = '/blue///';

	  $app = new application($config);

		$this->assertEquals($app->run(),'<h1>BlueIndex</h1>');
  }

  public function testRouter1() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['input']['server']['REQUEST_URI'] = '/blue';
		$config['app']['routes'] = array('#^blueController/indexGetAction(.*)$#i' => 'mainController/indexAction/$1$2');

	  $app = new application($config);

		$this->assertEquals($app->run(),'<h1>MainIndex</h1>');
  }

  public function testRouter2() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['input']['server']['REQUEST_URI'] = '/hello/John';
		$config['app']['routes'] = array('#^helloController/(.*)GetAction(.*)$#i' => 'mainController/helloAction/$1$2');

	  $app = new application($config);

		$this->assertEquals($app->run(),'Hello John');
  }

  public function testRouter3() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['input']['server']['REQUEST_URI'] = '/hello/there/John';
		$config['app']['routes'] = array('#^helloController/(.*)GetAction(.*)$#i' => 'mainController/helloAction$2');

	  $app = new application($config);

		$this->assertEquals($app->run(),'Hello John');
  }

  public function testRouter4() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['input']['server']['REQUEST_URI'] = '/hello/foo/BAR';
		$config['app']['routes'] = array('#^helloController/(.*)GetAction(.*)$#i' => 'mainController/helloAction$2');

	  $app = new application($config);

		$this->assertEquals($app->run(),'Hello BAR');
  }

  public function testInput1() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';

	  $app = new application($config);

		$html = $app->run();

		$this->assertEquals($app->config['app']['is https'],'');
		$this->assertEquals($app->config['app']['base url'],'http://basicmvc-template.localtest.me');
		$this->assertEquals($app->config['app']['request'],'Get');
		$this->assertEquals($app->config['app']['is ajax'],'');
		$this->assertEquals($app->config['app']['uri'],'');
		$this->assertEquals($app->config['app']['raw route'],'mainController/indexGetAction');
		$this->assertEquals($app->config['app']['route'],'mainController/indexAction');
		$this->assertEquals($app->config['app']['classname'],'mainController');
		$this->assertEquals($app->config['app']['called method'],'indexAction');
		$this->assertEquals($app->config['app']['segs'],array());

		$this->assertEquals($html,'<h1>MainIndex</h1>');
  }

	public function testOutput1() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';

	  $app = new application($config);

		$html = $app->run();

		$this->assertEquals($app->output,'<h1>MainIndex</h1>');
		$this->assertEquals($html,'<h1>MainIndex</h1>');
	} 

	public function testPost1() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['input']['server']['REQUEST_METHOD'] = 'POST';

	  $app = new application($config);
		$html = $app->run();

		$this->assertEquals($app->output,'<h1>MainPostIndex</h1>');
		$this->assertEquals($html,'<h1>MainPostIndex</h1>');
	}

	public function testPost2() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['input']['server']['REQUEST_METHOD'] = 'POST';
		$config['app']['input']['server']['REQUEST_URI'] = '/hello/foo/BAR';		
		$config['app']['routes'] = array('#^helloController/(.*)PostAction(.*)$#i' => 'mainController/helloAction$2');

	  $app = new application($config);

		$html = $app->run();

		$this->assertEquals($app->output,'Hello BAR');
		$this->assertEquals($html,'Hello BAR');
	}

	public function testPost3() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['input']['server']['REQUEST_METHOD'] = 'POST';
		$config['app']['input']['server']['REQUEST_URI'] = '/hello/foo/BAR';		
		$config['app']['routes'] = array('#^helloController/(.*)PostAction(.*)$#i' => 'mainController/helloAction$2');

	  $app = new application($config);

		$html = $app->run();

		$this->assertEquals($app->input['post']['name'],'John Post');

		$this->assertEquals($app->output,'Hello BAR');
		$this->assertEquals($html,'Hello BAR');
	}

	public function testPut1() {
	  require HERE.'/mocks/config.php';

		$config['app']['folders']['controllers'] = HERE.'/mocks/controllers/';
		$config['app']['input']['server']['REQUEST_METHOD'] = 'POST';
		$config['app']['input']['server']['REQUEST_URI'] = '/hello/foo/BAR';		
		$config['app']['routes'] = array('#^helloController/(.*)PostAction(.*)$#i' => 'mainController/helloAction$2');

	  $app = new application($config);

		$html = $app->run();

		$this->assertEquals($app->input['put']['name'],'John Put');

		$this->assertEquals($app->output,'Hello BAR');
		$this->assertEquals($html,'Hello BAR');
	}

}