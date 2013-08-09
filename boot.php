<?php 

/* PSR-0 autoloader */
$loader = require 'vendor/autoload.php';

/* manually add our core */
$loader->add('myersd\\core',getcwd());

/* setup our dependency injection container */
$c = new \myersd\core\container;

/* attach the loader */
$c->Loader = $loader;

/* load our config, input & output settings (or mocks for testing) */
$config = (getenv('CONFIG')) ? getenv('CONFIG') : 'config.php';

require 'app/'.$config;

/* Setup out even handler */
$c->Event = new \myersd\core\event($c);

/* load our applications startup - users can modify this file as needed */
require 'app/setup.php';

/* my exception handlers */
require $c->application['exception.handlers'];

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
