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
* You can place your user setup stuff here
* At this point $c is the container and config is loaded
* this is before request, router, dispatch, response are loaded
*/

/* turn them back on (this could be based on $app->config['app']['run code'] or something else */
error_reporting(E_ALL & ~E_NOTICE);

/* where are "our" modules are */
$c->Loader->add('example', getcwd().'/modules/');
