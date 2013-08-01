<?php 
/**
* DMyers Super Simple MVC
*
* @package    Startup
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*
*/

/* turn them back on (this could be based on $app->config['app']['run code'] or something else */
error_reporting(E_ALL & ~E_NOTICE);

/* Default timezone of server */
date_default_timezone_set('UTC');

// create a log channel
$c['logger'] = new \Monolog\Logger('name');
$c['logger']->pushHandler(new \Monolog\Handler\StreamHandler($c['config']['folders']['logs'].'log.log', \Monolog\Logger::WARNING));

$c['logger']->addWarning('Foo');
$c['logger']->addError('Bar');

/* Start Session */
/*
if (!headers_sent()) {
	session_save_path($c['config']['folders']['session']);
	session_name('s'.md5($c['config']['dispatch']['base url']));
	session_start();
}
*/