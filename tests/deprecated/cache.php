<?php
/**
* DMyers Super Simple MVC
*
* @package    Cache for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class cache {
	public $time;
	public $path;

	public function __construct(&$app) {
		$this->path = $app->config['cache']['cache folder'];
		$this->time = $app->config['cache']['time'];

		if (!is_dir($this->path)) {
			mkdir($this->path, 0777, true);
		}
	}

	/* cache functions */
	public function __get($key) {
    $key = $this->path.'cache'.md5($key);

    if (!file_exists($key) || (filemtime($key) < (time() - $seconds))) {
      return null;
    }

    if (filesize($key) == 0) {
      return null;
    }

    return(unserialize(file_get_contents($key)));
	}

	public function __set($key, $data) {
    $folder = $this->path.'cache';
    $file = $folder.'/temp-'.md5(uniqid(md5(rand()), true));
    file_put_contents($file,serialize($data));
    rename($file,$folder.'/'.md5($key));
	}

}
