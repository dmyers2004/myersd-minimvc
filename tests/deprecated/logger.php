<?php
/**
* DMyers Super Simple MVC
*
* @package    Logger for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class logger {
	public $path;
	public $config;
	public $stamp;
	public $filestamp;

	public function __construct(&$app) {
		$this->path = $app->config['logger']['logger path'];
		$this->stamp = $app->config['logger']['stamp'];
		$this->filestamp = $app->config['logger']['filestamp'];

		if (!is_dir($this->path)) {
			mkdir($this->path, 0777, true);
		}
	}

	public function _($msg,$name='log') {
		if ($log_handle = @fopen($this->path.$name.' '.date($this->filestamp).'.log','a')) {
			fwrite($log_handle,date($this->stamp).' '.$msg.chr(10));
			fclose($log_handle);
		}
	}

}
