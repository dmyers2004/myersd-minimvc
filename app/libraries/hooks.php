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
* preMethod
* preOutput
*/

class hooks {

	/* called after turn off all errors (default) and register the autoloader */
	public function startup(&$app) {
		/* turn them back on (this could be based on $app->config['app']['run code'] or something else */
		error_reporting(E_ALL & ~E_NOTICE);

		/* Default timezone of server */
		date_default_timezone_set('UTC');

		/* setup error handler */
		new Errorhandler;
				
		/* Setup Database & View */
		new Database($app);
		new View($app);

		/* Start Session */
		/*
		session_save_path($app->config['app']['session folder']);
		session_name(md5($app->base_url));
		session_start();
		*/
	}

	/* called before the controller and method and request type is actually used */
	public function preRouter(&$app) {

		/* run our router */
		foreach ($app->config['router']['routes'] as $regex_path => $switchto) {
			$matches = array();
			if (preg_match($regex_path, $app->config['app']['raw uri'], $matches)) {
				$app->config['app']['uri'] = preg_replace($regex_path, $switchto, $app->config['app']['raw uri']);
				break;
			}
		}

		foreach ($app->config['router']['requests'] as $regex_path => $switchto) {
			$matches = array();
			if (preg_match($regex_path, $app->config['app']['raw request'].'/'.$app->config['app']['uri'], $matches)) {
				$app->config['app']['request'] = $switchto;
				break;
			}
		}
		
	}

	/* called before the controller is instantiated */
	public function preController(&$app) {
		new basePublicController($app);
	}
	
	/* called before the method on the controller is called */
	public function preMethod(&$app)
	}

	/* if the contoller has returned anything it will be in $app->output */
	public function preOutput(&$app) {
	}
	
	/* you can add additional hooks here */

} /* end hooks */
