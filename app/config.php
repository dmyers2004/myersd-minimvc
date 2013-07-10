<?php

/* setup "assume nothing" config and start the party! */
$config['app'] = array(
 	'run code' => RUNCODE,

	'server' => $_SERVER,
	'get' => $_GET,
	'post' => $_POST,

	'default controller' => 'main',
	'default method' => 'index',
	'controller suffix' => 'Controller',
	'method suffix' => 'Action',
	'default request type' => 'Get',
	'display errors' => 'On',
	'include ajax' => 'Ajax',

	'folder' => PATH.'/app/',
	'controller folder' => PATH.'/app/controllers/',
	'libraries folder' => PATH.'/app/libraries/',
	'models folder' => PATH.'/app/models/',
	'view folder' => PATH.'/app/views/',
	'config folder' => PATH.'/app/config/',
	'logger folder' => PATH.'/app/var/logs/',
	'cache folder' => PATH.'/app/var/cache/',
	'session folder' => PATH.'/app/var/sessions/',
	'sqlite folder' => PATH.'/app/var/sqlite/'
);

/* setup the routes */
$config['app']['routes'] = array(
	'#^hello/(.*)$#i' => 'main/hello/$1',
	'#^unit/test$#i' => 'main/unit_test',
	'#^user/(.*)$#i' => 'main/user/$1',
	'#^app/test(.*)#i' => 'main/index$1',
	'#^app(.*)$#i' => 'main/app$1',
	'#^rest/(.*)$#i' => 'rest/index/$1',
);

/*
Request is now prepended to the beginning of the new url

/main/index get request becomes get/main/index
/main/index post request becomes post/main/index

*/
$config['app']['requests'] = array(
	'#^Get(.*)$#i' => '',
);

$config['database'] = array(
	'db.dsn' => 'sqlite:'.$config['app']['sqlite folder'] .'messaging.sqlite3',
	'db.user' => null,
	'db.password' => null,

	'db.mysql.dsn' => 'mysql:host=localhost;dbname=pi',
	'db.mysql.user' => 'root',
	'db.mysql.password' => 'root'
);

