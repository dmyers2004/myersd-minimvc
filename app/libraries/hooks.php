<?php
/**
* DMyers Super Simple MVC
*
* @package    Hooks for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*
* Hooks:
* startup
* preRouter
* preController
* preOutput
* shutdown
*/

class hooks {
	public function startup(&$app) {
		/* default errors */
		error_reporting(E_ALL & ~E_NOTICE);

		/* Default timezone of server */
		date_default_timezone_set('UTC');

		/* setup classes app is really just used for variables since it has no useful methods */
		new ErrorHandler;
		new Config($app->folder.'/config/');
		new Cache($app->folder.'/var/cache/',new Config);
		new Logger($app->folder.'/var/logs/', new Config);
		new Database(new Config);
		new View($app->folder.'/views/', new Config);
		new basePublicController($app, new Config, new View);

		$events = new Events;
		$events->register('xlog','Logger','_');
		/* shorthand in 5.4 (new Events)->reqister... */

		/* Start Session */
		/*
		session_save_path($app->path.'var/sessions');
		session_name(md5($app->base_url));

		session_start();
		*/
		$db = new Database();
		$dbc = $db->connection();
	}

	public function preRouter(&$app) {
		/* run our router */
		$router = new Router($app, new Config);
		$router->route();
	}

	/* pre controller junk here */
	public function preController(&$app) {
	}

	/* pre output junk here */
	public function preOutput(&$app) {
	}

	/* before the app finished */
	public function shutdown(&$app) {
	}

} /* end hooks */
