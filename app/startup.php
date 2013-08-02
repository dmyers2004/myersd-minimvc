<?php
/**
* DMyers Super Simple MVC
*
* @package    Startup
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*
*/

/* turn them back on (this could be based on $app->config['app']['run code'] or something else */
//error_reporting(E_ALL & ~E_NOTICE);

/* Setup your time zone */
//date_default_timezone_set('UTC');

/* mono log example - create a log channel */
$c['Logger'] = new \Monolog\Logger($c['config']['dispatcher']['folder']);
$c['Logger']->pushHandler(new \Monolog\Handler\RotatingFileHandler($c['config']['folders']['logs'].'log.log', 5, \Monolog\Logger::WARNING));

//$c['Logger']->addWarning('Foo');
//$c['Logger']->addError('Bar');

/*
$c['Error Handler'] = new Whoops\Run();
$c['Error Handler']->pushHandler(new Whoops\Handler\PrettyPageHandler());
$c['Error Handler']->register();
*/

$c['Error Handler'] = new libraries\errorhandlerbasic($c);

//$c['Error Handler'] = new libraries\errorhandlerbthp($c);

$c['Cache'] = new Desarrolla2\Cache\Cache(new Desarrolla2\Cache\Adapter\NotCache());

/* Start Session */
/*
if (!headers_sent()) {
	session_save_path($c['config']['folders']['session']);
	session_name('s'.md5($c['config']['dispatch']['base url']));
	session_start();
}
*/

/* example event */

class foo
{
	public function bar(&$c)
	{
		echo 'Setting Foo to Bar<pre>';
		$c['foo'] = 'Bar';
	}

	public function echo_bar(&$c)
	{
		echo '<h1>foo is "'.$c['foo'].'"</h1>';
		echo'<pre>';
	}

	public function rot(&$c)
	{
		$c['output'] = str_rot13($c['output']);
	}
	
	public function route(&$c)
	{
		echo '<pre>';
		print_r($c);
	}

}

//$c['Dispatcher']->register('preRouter',array(new foo,'route'));


/*
$c['Dispatcher']->register('startup',array(new foo,'bar'));
$c['Dispatcher']->register('preRouter',array(new foo,'echo_bar'));
$c['Dispatcher']->register('preOutput',array(new foo,'rot'));
*/
