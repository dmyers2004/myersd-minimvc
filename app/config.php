<?php
/**
* DMyers Super Simple MVC
*
* @package    Config
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*
*/

/* setup "assume nothing" config/injection and start the party! */
$c['config']['dispatch'] = array(
 	'run code' => getenv('RUNCODE'),
 	'handler' => php_sapi_name(),

	'app' => APP,
	'folder' => FOLDER,
	'include path' => get_include_path(),

	'routes' => array(
		'#^/([a-zA-Z0-9-_]*)/Get/red/([a-zA-Z0-9-_]*)/$#i' => '\\\example\\\controllers\\\redController/$2$1Action',

		'#^/([a-zA-Z0-9-_]*)/Get///$#i' => '\controllers\\\mainController/index$1Action',
		'#^/([a-zA-Z0-9-_]*)/Get/([a-zA-Z0-9-_]*)//$#i' => '\controllers\\\$2Controller/index$1Action',
		'#^/([a-zA-Z0-9-_]*)/Get/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$2Controller/$1$3Action',
		'#^/([a-zA-Z0-9-_]*)/Get/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$2Controller/$3$1Action',
		'#^/([a-zA-Z0-9-_]*)/Get/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$2Controller/$3$1Action/$4',
		'#^/([a-zA-Z0-9-_]*)/Get/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$2Controller/$3$1Action/$4/$5',
		'#^/([a-zA-Z0-9-_]*)/Get/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$2Controller/$3$1Action/$4/$5/$6',

		'#^/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)///$#i' => '\controllers\\\mainController/index$1$2Action',
		'#^/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)//$#i' => '\controllers\\\$2Controller/index$1$2Action',
		'#^/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$3Controller/$4$1$2Action',
		'#^/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$3Controller/$4$1$2Action',
		'#^/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$3Controller/$4$1$2Action/$5',
		'#^/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$3Controller/$4$1$2Action/$5/$6',
		'#^/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$3Controller/$4$1$2Action/$5/$6/$7',	
	)

);

$c['config']['folders'] = array(
	'view' => APP.'views/',
	'logs' => APP.'var/logs/',
	'cache' => APP.'var/cache/',
	'session' => APP.'var/sessions/',
	'sqlite' => APP.'var/sqlite/'
);

/* database config */
$c['config']['database'] = array(
	'db.dsn' => 'sqlite:'.$c['config']['folders']['sqlite'] .'messaging.sqlite3',
	'db.user' => null,
	'db.password' => null,

	'db.mysql.dsn' => 'mysql:host=localhost;dbname=pi',
	'db.mysql.user' => 'root',
	'db.mysql.password' => 'root'
);

/* PHP HTTP Put handler */
$_PUT = array();
\parse_str(file_get_contents('php://input'), $_PUT);

/* injection! baby! */
$c['input'] = array(
	'server' => $_SERVER,
	'get' => $_GET,
	'post' => $_POST,
	'files' => $_FILES,
	'cookies' => $_COOKIE,
	'env' => $_ENV,
	'session' => $_SESSION,
	'put' => $_PUT
);

$c['output'] = '';
