<?php
/* where are we? - this is used a lot so let's define it */
define('PATH', realpath(__DIR__.'/..'));

/* examples
define('PATH', __DIR__); - everything in root folder
define('PATH', realpath(__DIR__.'/..')); - everything in "public" folder and app 1 level down 
*/

/* load our config settings - or testing mockup */
require PATH.'/app/config.php';

/* load our application core */
require PATH.'/app/application.php';

/* start the application */
$app = new application($config);

/* echo any output */
echo $app->run();




/* Show Request time & memory usage -- comment/uncomment */
/*
echo '<p>'.(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']).'ms</p>';
echo '<p>'.(memory_get_peak_usage(true)/1024).'k</p>';
*/