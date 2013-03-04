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
* pre_router
* pre_controller
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
		new Config($app->path.'config/');
		new Cache($app->path.'var/cache/',new Config);
		new Logger($app->path.'var/logs/', new Config);
		new Events();
		new Database(new Config);
		new View($app->path.'views/', new Config);
		new basePublicController($app, new Config, new View);

		Events::register('xlog','Logger','_');

		/* Start Session */
		/*
		session_save_path($app->path.'var/sessions');
		session_name(md5($app->base_url));

		session_start();
		*/
	}

	public function preRouter(&$app) {
		/* run our router */
		(new Router($app, new Config))->route();
	}

	/* pre controller junk here */
	public function preController(&$app) {
	}

	/* before the app finished */
	public function shutdown(&$app) {
	}

} /* end hooks */
