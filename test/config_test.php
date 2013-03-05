<?php

require_once(dirname(__FILE__) . '/simpletest/autorun.php');  

/* include our application.php class */
require_once('../app/libraries/config.php');

class TestConfig extends UnitTestCase {  

	function testBasic() {
		$config = new config(__DIR__.'/config_mocks/');

		$this->assertEqual($config->get('application','sample'), 'Some Value');
		$this->assertEqual($config->get('application','bogus','foobar'), 'foobar');

		$this->assertEqual($config->get('cache','time'), 3600);
		$this->assertEqual($config->get('cache','bogus',10), 10);

		$this->assertEqual($config->get('view','title'), 'Default');
  }
  
  function testSepConfig() {
		$config = new config(__DIR__.'/config_mocks/','production');

		$this->assertEqual($config->get('application','sample'), 'Some Value');
		$this->assertEqual($config->get('application','bogus','foobar'), 'foobar');

		$this->assertEqual($config->get('view','title'), 'Production');
  }

  function testConfigRead() {
		$config = new config(__DIR__.'/config_mocks/');

		$this->assertIsA($config->read('application'), 'Array');
		$this->assertIsA($config->read('view'), 'Array');
		$this->assertIsA($config->read('bogus'), 'Array');

		$match = array('sample' => 'Some Value');
		$this->assertEqual($config->read('application'), $match);

		$this->assertEqual($config->read('bogus'), array());

		$match = array('time' => 3600);
		$this->assertEqual($config->read('cache'), $match);

		$config = new config(__DIR__.'/config_mocks/','production');
		
		$match = array('time' => 4800);
		$this->assertEqual($config->read('cache'), $match);

  }


} /* end unit test */
