<?php

/* setup "assume nothing" config and start the party! */
$config['app'] = array(
 	'run code' => 'production',

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
$config['router']['routes'] = array(
	'#^hello/(.*)$#i' => 'main/hello/$1',
	'#^unit/test$#i' => 'main/unit_test',
	'#^user/(.*)$#i' => 'main/user/$1',
	'#^app/test(.*)#i' => 'main/index/$1',
	'#^app(.*)$#i' => 'main/app$1',
	'#^rest/(.*)$#i' => 'rest/index/$1',
);

/*

we then take the match from
above (if any) and prepend
the raw request to
the uri and run these matches

ie raw uri /hello/don converted to /main/hello/don
then the request is prepended to the uri
get/main/hello/don

therefore the "get" gets converted to post using the following

^Get/main/hello(.*)$ => 'post'

*/
$config['router']['requests'] = array(
	'#^Get(.*)$#i' => '',
);


$config['cache'] = array(
	'time' => 3600
);

$config['database'] = array(
	'db.dsn' => 'sqlite:'.$config['app']['sqlite folder'] .'messaging.sqlite3',
	'db.user' => null,
	'db.password' => null,

	'db.mysql.dsn' => 'mysql:host=localhost;dbname=pi',
	'db.mysql.user' => 'root',
	'db.mysql.password' => 'root'
);

$config['logger'] = array(
	'stamp' => 'Y-m-d H:i:s',
	'filestamp' => 'Y-m-d'
);
