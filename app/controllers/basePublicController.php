<?php
/**
	* DMyers Super Simple MVC
	*
	* @package    Bootstrap File
	* @language   PHP
	* @author     Don Myers
	* @copyright  Copyright (c) 2011
	* @license    Released under the MIT License.
	*
	*/

class basePublicController {
	public static $app;
	public static $config;
	public static $view;	

	public function __construct(&$app = null,&$config = null,&$view = null) {
		
		if ($app) {
			self::$app = $app;
			self::$config = $config;
			self::$view = $view;

			$view->set(array(
				'sitename'=>$config->get('view','title','set in config > title'),
				'baseurl'=>&$app->base_url,
				'base_url'=>&$app->base_url,
				'uri'=>&$app->uri
			));

		}
	
	}
	
	public function __get($name) {
		if (isset(self::$$name)) {
			return self::$$name;
		}
	}

	public function __set($name,$value) {
		if (property_exists($this,$name)) {
			self::$$name = $value;
		}
	}

} /* end controller */
