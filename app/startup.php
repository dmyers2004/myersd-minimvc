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
error_reporting(E_ALL & ~E_NOTICE);

/* load out error handler */
$c->ErrorHandler = new libraries\errorhandlerbasic($c);

/* where are "our" modules are */
$c->Loader->add('example', getcwd().'/modules/');
