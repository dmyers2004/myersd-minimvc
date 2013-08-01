<?php
/* where are we? - this is used a lot so let's define it */
define('FOLDER', realpath(__DIR__.'/../').'/');

/* PSR-0 autoloader */
require FOLDER.'vendor/autoload.php';

/* setup our "super simple" dependency injection container */
$c = array();

/* load our config, input & output settings - or testing mockup */
require FOLDER.'app/config.php';

/* load our applications startup - users should modify this file as needed */
require FOLDER.'app/startup.php';

/* create dispatcher and dispatch! */
$c['Dispatcher'] = new \myersd\core\dispatcher($c);

$c['Dispatcher']->dispatch();

/* send output */
echo $c['output'];

/* Show Request time & memory usage -- comment/uncomment */

//echo '<p>'.(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']).'ms</p>';
//echo '<p>'.(memory_get_peak_usage(true)/1024).'k</p>';
