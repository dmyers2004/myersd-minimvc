<?php

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