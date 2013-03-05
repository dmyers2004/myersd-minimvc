<?php

require_once(dirname(__FILE__) . '/simpletest/autorun.php');  

/* include our application.php class */
require_once('../app/libraries/hooks.php');

class TestHooks extends UnitTestCase {  

	function testBasic() {
		/* guess we will just test for is callable? */
	
		/* mock up app */
		$hooks = new hooks;

		$this->assertTrue(is_callable(array($hooks,'startup')));
		$this->assertTrue(is_callable(array($hooks,'preRouter')));
		$this->assertTrue(is_callable(array($hooks,'preController')));
		$this->assertTrue(is_callable(array($hooks,'preOutput')));
		$this->assertTrue(is_callable(array($hooks,'shutdown')));

  }

} /* end unit test */
