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

/* we need to start in the root directory */
chdir('..');

/* PSR-0 autoloader */
$loader = require 'vendor/autoload.php';

/* add our application folder and core folders */
$loader->add('', getcwd().'/app');
$loader->add('myersd\\core',getcwd());
$loader->add('myersd\\libraries',getcwd());

/* setup our "super simple" dependency injection container */
$c = array();

/*
Normally I start objects/closures with uppercase letter scalar/array are all lowercase
ie.
$c['Dispatcher'] = objects/closures
$c['dispatcher'] = scalar/array (config data for example)
*/

/* load our config, input & output settings (or mocks for testing) */
require 'app/config.php';

/* instantiate dispatcher */
$c['Dispatcher'] = new \myersd\core\dispatcher($c);

/* load our applications startup - users can modify this file as needed */
require 'app/startup.php';

/* Call Dispatch! */
$c['Dispatcher']->dispatch();

/* send output */
echo $c['response'];

/* Show Request time & memory usage -- comment/uncomment */
//echo '<p>'.(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']).'ms</p>';
//echo '<p>'.(memory_get_peak_usage(true)/1024).'k</p>';
