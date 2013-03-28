<?php
require('app/application.php');

/* setup "assume nothing" config and start the party! */
$config = array(
 	'run code' => 'debug',
	'default controller' => 'main',
	'default method' => 'index',
	'server' => $_SERVER,
	'get' => $_GET,
	'post' => $_POST,
	'folder' => realpath(__DIR__.'/app'),
	'controller folder' => realpath(__DIR__).'/app/controllers',
	'libraries folder' => realpath(__DIR__).'/app/libraries',
	'models folder' => realpath(__DIR__).'/app/models',
	'controller suffix' => 'Controller',
	'method suffix' => 'Action',
	'default request type' => 'Get',
	'display errors' => 'On',
	'include ajax' => 'Ajax';
);

$app = new Application($config);
