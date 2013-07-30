<?php
/* where are we? - this is used a lot so let's define it */
define('FOLDER', realpath(__DIR__.'/../').'/');

define('APP', FOLDER.'app/');

/* add include paths for app and vendor folders */
set_include_path(get_include_path().':'.APP);
set_include_path(get_include_path().':'.FOLDER.'/vendor/');

/*
register the PSR-0-ish autoloader
copied from http://stackoverflow.com/questions/12082507/php-most-lightweight-psr-0-compliant-autoloader
*/
spl_autoload_register(function($c) {
	@include preg_replace('#\\\|_(?!.+\\\)#','/',$c).'.php';
});


/* setup our dependency injection container */
$c = array();

/* load our config, input & output settings - or testing mockup */
require APP.'config.php';

/* load our application personalized startup */
require APP.'startup.php';

/* create dispatcher and dispatch! */
$c['dispatch'] = new \myersd\core\dispatch($c);

/* send output */
echo $c['output'];

/* Show Request time & memory usage -- comment/uncomment */
/*
echo '<p>'.(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']).'ms</p>';
echo '<p>'.(memory_get_peak_usage(true)/1024).'k</p>';
*/