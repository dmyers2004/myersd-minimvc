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

		new ErrorHandler;
		new Config($app->path.'config/');
		new Cache($app->path.'var/cache/',new Config);
		new Logger($app->path.'var/logs/', new Config);
		new Database(new Config);
		new View($app->path.'views/', new Config);
		new Events();
		
		Events::register('xlog','Logger','_');

		/* Start Session */
		/*
		session_save_path($app->path.'var/sessions');
		session_name(md5($app->base_url));

		session_start();
		*/
	}

	public function preRouter(&$app) {
		$router = new Router(new Config);

		$app->uri = $router->uri($app->raw_uri);
		$app->request = $router->request($app->raw_request);
	}

	/* pre controller junk here */
	public function preController(&$app) {
		$view = new View;
		$view->data(array(
			'sitename'=>'Simple MVC Template',
			'baseurl'=>$app->base_url,
			'base_url'=>$app->base_url,
			'uri'=>$app->uri
		));

		/* inject into basecontroller here */
		//new basePublicController($app, new Config, new View);

		/* inject these this way to we can use $this->Config */
		/* App already set in Application incase your not using all the extra files */
		$app->main_controller->Config = new Config;
		$app->main_controller->View = new View;
	}

	public function shutdown(&$app) {
	}

} /* end hooks */
