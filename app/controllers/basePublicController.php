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
	public $app;

	public function __construct(&$app=null) {
		
		if ($app !== null) {		
			$this->app = $app;
			
			$this->app->View->set(array(
				'baseurl'=>$this->app->config['app']['base url'],
				'uri'=>$this->app->config['app']['uri']
			));
			
			
			
		}
	
	}

} /* end controller */
