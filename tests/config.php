<?php
class TestConfig extends PHPUnit_Framework_TestCase {  

	protected function setUp() {
		require_once '../app/libraries/config.php';
	}

	function testBasic() {
		$config = new config(__DIR__.'/config_mocks/');

		$this->assertEquals($config->get('application','sample'), 'Some Value');
		$this->assertEquals($config->get('application','bogus','foobar'), 'foobar');

		$this->assertEquals($config->get('cache','time'), 3600);
		$this->assertEquals($config->get('cache','bogus',10), 10);

		$this->assertEquals($config->get('view','title'), 'Default');
  }
  
  function testSepConfig() {
		$config = new config(__DIR__.'/config_mocks/','production');

		$this->assertEquals($config->get('application','sample'), 'Some Value');
		$this->assertEquals($config->get('application','bogus','foobar'), 'foobar');

		$this->assertEquals($config->get('view','title'), 'Production');
  }

  function testConfigRead() {
		$config = new config(__DIR__.'/config_mocks/');

		$this->assertEquals($config->read('application'),array('sample' => 'Some Value'));

		$this->assertEquals($config->read('view'),array('layout' => 'layout', 'body' => 'body', 'throw errors' => false, 'title' => 'Default'));
		
		$this->assertEquals($config->read('bogus'),array());

		$match = array('sample' => 'Some Value');
		$this->assertEquals($config->read('application'), $match);

		$this->assertEquals($config->read('bogus'), array());

		$match = array('time' => 3600);
		$this->assertEquals($config->read('cache'), $match);

		$config = new config(__DIR__.'/config_mocks/','production');
		
		$match = array('time' => 4800);
		$this->assertEquals($config->read('cache'), $match);

  }
  
  protected function tearDown() {

  }

} /* end unit test */
