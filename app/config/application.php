<?php

$root_dir = realpath(__DIR__.'/../');

/* setup "assume nothing" config and start the party! */
$config = array(
 	'run code' => 'debug',
	'default controller' => 'main',
	'default method' => 'index',
	'server' => $_SERVER,
	'get' => $_GET,
	'post' => $_POST,
	'folder' => $root_dir.'/',
	'controller folder' => $root_dir.'/controllers/',
	'libraries folder' => $root_dir.'/libraries/',
	'models folder' => $root_dir.'/models/',
	'controller suffix' => 'Controller',
	'method suffix' => 'Action',
	'default request type' => 'Get',
	'display errors' => 'On',
	'include ajax' => 'Ajax'
);

return $config;