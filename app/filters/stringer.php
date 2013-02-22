<?php
/**
* DMyers Super Simple MVC
*
* @package    Example View Plugin SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class filterStringer {

	public function encode($data) {
		return base64_encode($data);
	}

	public function decode($data) {
		return base64_decode($data);
	}

	public function left($data,$cnt=0) {
		return substr($data,0,$cnt);
	}

	public function right($data,$cnt=0) {
		return substr($data,-$cnt);
	}

}
