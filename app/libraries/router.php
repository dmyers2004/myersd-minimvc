<?php
/**
* DMyers Super Simple MVC
*
* @package    Router for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class router {

	public static $app;
	public static $routes;
	public static $requests;

	public function __construct(&$app = null, &$config=null) {
		if ($app) {
			self::$app = $app;
			self::$routes = $config->get(get_class($this),'routes',array());
			self::$requests = $config->get(get_class($this),'requests',array());
		}
	}

	public function route() {

		foreach (self::$routes as $regex_path => $switchto) {
			$matches = array();
			if (preg_match($regex_path, self::$app->raw_uri, $matches)) {
				self::$app->uri = preg_replace($regex_path, $switchto, self::$app->raw_uri);
				break;
			}
		}

		foreach (self::$requests as $regex_path => $switchto) {
			$matches = array();
			if (preg_match($regex_path, self::$app->raw_request.'/'.self::$app->uri, $matches)) {
				self::$app->request = $switchto;
				break;
			}
		}


		return $this;
		
	} /* end route */

}
