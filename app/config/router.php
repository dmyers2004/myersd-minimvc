<?php

/* setup the routes */
$config['routes'] = array(
	'#^hello/(.*)$#i' => 'main/hello/$1',
	'#^unit/test$#i' => 'main/unit_test',
	'#^user/(.*)$#i' => 'main/user/$1',
	'#^app/test(.*)#i' => 'main/index/$1',
	'#^app(.*)$#i' => 'main/app$1',
	'#^rest/(.*)$#i' => 'rest/index/$1',

);

/*
these are test as follows
current request + currently matched route from above regex
ie. get/main/user/don/18
get is prepended to the matched url
*/

$config['requests'] = array(
	'#^get(.*)$#i' => '',
);
