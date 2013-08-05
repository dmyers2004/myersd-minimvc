<?php
/**
* DMyers Super Simple MVC
*
* @package    request file
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/
namespace myersd\core;

class request
{
	private $c;

	public function __construct(&$c) {
		$this->c = &$c;
	}

	public function get($key=null,$default=null,$xss=true) {
		return $this->get_val('get',$key,$default,$xss);
	}

	public function post($key=null,$default=null,$xss=true) {
		return $this->get_val('post',$key,$default,$xss);
	}

	public function put($key=null,$default=null,$xss=true) {
		return $this->get_val('put',$key,$default,$xss);
	}

	public function env($key=null,$default=null,$xss=true) {
		return $this->get_val('env',$key,$default,$xss);
	}

	public function files($key=null,$default=null,$xss=true) {
		return $this->get_val('files',$key,$default,$xss);
	}

	public function cookie($key=null,$default=null,$xss=true) {
		return $this->get_val('cookie',$key,$default,$xss);
	}

	public function param($idx=null,$default=null,$xss=true) {
		$this->c['request']['param'] = explode('/',$this->c['Dispatcher']->uri);
		return $this->get_val('param',$idx-1,$default,$xss);
	}

	public function server($key=null,$default=null,$xss=false) {
		return $this->get_val('server',$key,$default,$xss);
	}

	public function filter_xss($val) {
		if (is_array($val)) {
			array_walk_recursive($val, function( &$str) {
				$str = strip_tags($str);
			});
		} else {
			$val = strip_tags($val);
		}
		
		return $val;
	}

	private function get_val($ary,$key,$default,$xss) {
		if ($key === null) {
			return $this->c['request'][$ary];
		}
		
		$val = (isset($this->c['request'][$ary][$key])) ? $this->c['request'][$ary][$key] : $default;
		
		return ($xss) ? $this->filter_xss($val) : $val;
	}

}