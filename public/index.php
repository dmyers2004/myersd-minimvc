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
error_reporting(0);

/* we need to start in the root directory */
chdir('..');

/* PSR-0 autoloader */
$loader = require 'vendor/autoload.php';

/* add our application folder and core folders */
$loader->add('', getcwd().'/app');
$loader->add('myersd\\core',getcwd());
$loader->add('myersd\\libraries',getcwd());

/* setup our dependency injection container */
$c = new \myersd\core\container;

/*
Normally I start objects/closures with uppercase letter scalar/array are all lowercase
ie.
$c['Dispatcher'] = objects/closures
$c['dispatcher'] = scalar/array (config data for example)
*/

/* load our config, input & output settings (or mocks for testing) */
require 'app/config.php';

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

/* Call Dispatch! (too lazy load stuff) */
$c->Dispatcher->dispatch();

/* Send Responses */
$c->Response->sendHeaders()->sendBody();
