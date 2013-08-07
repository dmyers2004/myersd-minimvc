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
* The only publicly visible php file
*
*/

/* Set default timezone of server so PHP doesn't complain */
date_default_timezone_set('UTC');

/* turn off error by default */
//error_reporting(0);

/* we need to start in the root directory */
chdir('..');

/* PSR-0 autoloader */
$loader = require 'vendor/autoload.php';

/* manually add core */
$loader->add('myersd\\core',getcwd());

/* setup our dependency injection container */
$c = new \myersd\core\container;

$c->Loader = $loader;
$c->Loader->add('', getcwd().'/app');
$c->Loader->add('myersd\\libraries',getcwd());

/* load our config, input & output settings (or mocks for testing) */
$config = (getenv('CONFIG')) ? getenv('CONFIG') : 'config.php';
require 'app/'.$config;

/* Setup out even handler */
$c->Event = new \myersd\core\event($c);

/* load our applications startup - users can modify this file as needed */
require 'app/startup.php';

/* instantiate core classes but don't do anything yet! */
$c->Request = new \myersd\core\request($c);
$c->Router = new \myersd\core\router($c);
$c->Dispatcher = new \myersd\core\dispatcher($c);
$c->Response = new \myersd\core\response($c);

/* Run the router */
$c->Router->route();

/* Call Dispatch! (too lazy load a controllers) */
$c->Dispatcher->dispatch();

/* Send Responses */
$c->Response->sendHeaders()->sendBody();
