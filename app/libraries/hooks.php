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
	public static $app;

	public function __construct(&$app=null) {
		if ($app) {
			self::$app = $app;
		}
	}

	public function startup() {
		/* default errors */
		error_reporting(E_ALL & ~E_NOTICE);

		/* Default timezone of server */
		date_default_timezone_set('UTC');

		new ErrorHandler;
		new Config(self::$app->path.'config/');
		new Cache(self::$app->path.'var/cache/',new Config);
		new Logger(self::$app->path.'var/logs/', new Config);
		new Database(new Config);
		new View(self::$app->path.'views/', new Config);

		/* Start Session */
		/*
		session_save_path(self::$app->path.'var/sessions');
		session_name(md5(self::$app->base_url));

		session_start();
		*/
	}

	public function preRouter() {
		$router = new Router(new Config);

		self::$app->uri = $router->uri(self::$app->raw_uri);
		self::$app->request = $router->request(self::$app->raw_request);
	}

	/* pre controller junk here */
	public function preController() {
		$view = new View;
		$view->data(array(
			'sitename'=>'Simple MVC Template',
			'baseurl'=>self::$app->base_url,
			'base_url'=>self::$app->base_url,
			'uri'=>self::$app->uri
		));

		/* inject into basecontroller here */
		//new basePublicController($app, new Config, new View);

		/* inject these this way to we can use $this->Config */
		/* App already set in Application incase your not using all the extra files */
		self::$app->main_controller->Config = new Config;
		self::$app->main_controller->View = new View;
	}

	public function shutdown() {
	}

} /* end hooks */
