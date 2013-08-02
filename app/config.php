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
$c['config']['dispatcher'] = array(
 	'run code' => getenv('RUNCODE'),
 	'handler' => php_sapi_name(),

	'app' => FOLDER.'app/',
	'folder' => FOLDER,

	'routes' => array(
		'#^(http|https)/(Ajax|)/Get/red/([a-zA-Z0-9-_]*)/$#i' => '\\\example\\\controllers\\\redController/$2$1Action',

		/* default */
		'#^(http|https)/(Ajax|)/(Get)/$#i' => '\controllers\\\mainController/index$2Action',
		'#^(http|https)/(Ajax|)/(Get)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$4Controller/index$2Action',
		'#^(http|https)/(Ajax|)/(Get)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)(.*)$#i' => '\controllers\\\$4Controller/$5$2Action$6',

		'#^(http|https)/(Ajax|)/(Post|Delete|Put)/$#i' => '\controllers\\\mainController/index$2$3Action',
		'#^(http|https)/(Ajax|)/(Post|Delete|Put)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$4Controller/index$2$3Action',
		'#^(http|https)/(Ajax|)/(Post|Delete|Put)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)(.*)$#i' => '\controllers\\\$4Controller/$5$2$3Action$6',
	)

);

$c['config']['folders'] = array(
	'view' => FOLDER.'app/views/',
	'logs' => FOLDER.'app/var/logs/',
	'cache' => FOLDER.'app/var/cache/',
	'session' => FOLDER.'app/var/sessions/',
	'sqlite' => FOLDER.'app/var/sqlite/'
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
