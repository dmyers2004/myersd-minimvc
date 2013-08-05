<?php
class Testapplication extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		/* where are we? - this is used a lot so let's define it */
		define('FOLDER', realpath(__DIR__.'/../').'/');
		
		/* PSR-0 autoloader */
		$loader = require FOLDER.'../vendor/autoload.php';
		
		/* add our application folder and core folders */
		$loader->add('', FOLDER.'mocks/');
		$loader->add('myersd\\core',FOLDER.'../');
		$loader->add('myersd\\libraries',FOLDER.'../');
	}

  protected function tearDown() {

	}

	public function testConfig() {
		/* setup our "super simple" dependency injection container */
		$c = array();
		
		/* load our config, input & output settings (or mocks for testing) */
		require FOLDER.'mocks/config.php';
		
		$this->assertEquals($c['config']['dispatcher']['run code'], 'mocker');
  }

	public function testEmpty() {
		/* setup our "super simple" dependency injection container */
		$c = array();
		
		/* load our config, input & output settings (or mocks for testing) */
		require FOLDER.'mocks/config.php';
		
		/* instantiate dispatcher */
		$c['Dispatcher'] = new \myersd\core\dispatcher($c);
				
		$this->assertEquals($c['Dispatcher']->dispatch(),'<h1>MainIndex</h1>');
  }


}