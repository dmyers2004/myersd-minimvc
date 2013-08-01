<?php
/* where are we? - this is used a lot so let's define it */
define('FOLDER', realpath(__DIR__.'/../').'/');

/* PSR-0 autoloader */
require FOLDER.'vendor/autoload.php';

/* setup our "super simple" dependency injection container */
$c = array();

/* load our config, input & output settings (or mocks for testing) */
require FOLDER.'app/config.php';

/* instantiate dispatcher */
$c['Dispatcher'] = new \myersd\core\dispatcher($c);

/* load our applications startup - users can modify this file as needed */
require FOLDER.'app/startup.php';

/* Call Dispatch! */
$c['Dispatcher']->dispatch();

/* send output */
echo $c['output'];

/* Show Request time & memory usage -- comment/uncomment */

//echo '<p>'.(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']).'ms</p>';
//echo '<p>'.(memory_get_peak_usage(true)/1024).'k</p>';
