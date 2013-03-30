<?php
class TestHooks extends PHPUnit_Framework_TestCase {  

	protected function setUp() {
		require_once __DIR__.'/../app/libraries/hooks.php';
	}

	public function testBasic() {
		/* guess we will just test for is callable? */
	
		/* mock up app */
		$hooks = new hooks;

		$this->assertTrue(is_callable(array($hooks,'startup')));
		$this->assertTrue(is_callable(array($hooks,'preRouter')));
		$this->assertTrue(is_callable(array($hooks,'preController')));
		$this->assertTrue(is_callable(array($hooks,'preOutput')));
		$this->assertTrue(is_callable(array($hooks,'shutdown')));

  }
  
  protected function tearDown() {

  }

} /* end unit test */
