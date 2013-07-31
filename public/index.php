<?php
/* where are we? - this is used a lot so let's define it */
define('FOLDER', realpath(__DIR__.'/../').'/');
define('APP', FOLDER.'app/');

/* PSR-0 autoloader */
require FOLDER.'vendor/autoload.php';

/* setup our "super simple" dependency injection container */
$c = array();

/* load our config, input & output settings - or testing mockup */
require APP.'config.php';

/* setup error handler */
new \myersd\core\errorhandler;

/* setup event handler */
new \myersd\core\events($c);

/* load our applications startup - users should modify this file as needed */
require APP.'startup.php';

/* create dispatcher and dispatch! */
new \myersd\core\dispatch($c);

/* send output */
echo $c['output'];

/* Show Request time & memory usage -- comment/uncomment */

//echo '<p>'.(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']).'ms</p>';
//echo '<p>'.(memory_get_peak_usage(true)/1024).'k</p>';
