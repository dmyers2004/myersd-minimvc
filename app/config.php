<?php

/* HTTP Put handler */
$_PUT = array();
parse_str(file_get_contents('php://input'), $_PUT);

/* setup "assume nothing" config/injection and start the party! */
$config['app'] = array(
 	'run code' => getenv('RUNCODE'),

	'default controller' => 'main',
	'default method' => 'index',
	'controller suffix' => 'Controller',
	'method suffix' => 'Action',
	'ajax prefix' => 'Ajax',

	'folder' => PATH.'/app/',
);

$config['app']['input'] = array(
	'server' => $_SERVER,
	'get' => $_GET,
	'post' => $_POST,
	'files' => $_FILES,
	'cookies' => $_COOKIE,
	'env' => $_ENV,
	'session' => $_SESSION,
	'put' => $_PUT,
);

$config['app']['folders'] = array(
	'controller' => PATH.'/app/controllers/',
	'libraries' => PATH.'/app/libraries/',
	'models' => PATH.'/app/models/',
	'view' => PATH.'/app/views/',
	'logs' => PATH.'/app/var/logs/',
	'cache' => PATH.'/app/var/cache/',
	'session' => PATH.'/app/var/sessions/',
	'sqlite' => PATH.'/app/var/sqlite/'
);

/* setup the routes mainController/indexGet[Ajax]Action/a/b/c */
$config['app']['routes'] = array(
	'#^helloController/(.*)GetAction(.*)$#i' => 'mainController/helloAction/$1$2',
	'#^(.*)/(.*)GetAction$#i' => '$1/$2Action',
	'#^(.*)Controller/(.*)GetAction(.*)$#i' => '$1Controller/$2Action$3',
);

$config['database'] = array(
	'db.dsn' => 'sqlite:'.$config['app']['folders']['sqlite'] .'messaging.sqlite3',
	'db.user' => null,
	'db.password' => null,

	'db.mysql.dsn' => 'mysql:host=localhost;dbname=pi',
	'db.mysql.user' => 'root',
	'db.mysql.password' => 'root'
);

/*
	'#^hello/(.*)$#i' => 'main/hello/$1',
	'#^unit/test$#i' => 'main/unit_test',
	'#^user/(.*)$#i' => 'main/user/$1',
	'#^app/test(.*)#i' => 'main/index$1',
	'#^app(.*)$#i' => 'main/app$1',
	'#^rest/(.*)$#i' => 'rest/index/$1',
*/