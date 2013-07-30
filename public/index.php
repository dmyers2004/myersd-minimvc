<?php
/* where are we? - this is used a lot so let's define it */
define('PATH', realpath(__DIR__.'/../app').'/');

/* examples
define('PATH', __DIR__); - everything in root folder
define('PATH', realpath(__DIR__.'/..')); - everything in "public" folder and app 1 level down 
*/

/* add a include path to the core files */
set_include_path(get_include_path().':'.PATH);

/* register the PSR-0-ish autoloader */
spl_autoload_register(function ($classname) {
  preg_match('/^(.+)?([^\\\\]+)$/U', ltrim($classname, "\\"), $match);
  include_once str_replace("\\", "/", $match[1]).str_replace(["\\", '_'], '/', $match[2]).'.php';
});

/* setup our dependency injection container */
$c = array();

/* load our config, input & output settings - or testing mockup */
require PATH.'config.php';

/* load our application personalized startup */
require PATH.'startup.php';

/* create dispatcher and dispatch! */
$c['dispatch'] = new \libraries\dispatch($c);

/* send output */
echo $c['output'];

/* Show Request time & memory usage -- comment/uncomment */
/*
echo '<p>'.(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']).'ms</p>';
echo '<p>'.(memory_get_peak_usage(true)/1024).'k</p>';
*/