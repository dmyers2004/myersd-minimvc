<?php

define('RUNCODE', getenv('RUNCODE'));
define('PATH', dirname(__FILE__));

/* load our config settings - or testing mockup */
require PATH.'/app/config.php';

/* load our application core */
require PATH.'/app/application.php';

/* start the application */
$app = new application($config);

echo $app->run();