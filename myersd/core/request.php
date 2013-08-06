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

	public $is_https;
	public $is_ajax;
	public $base_url;
	public $request;
	public $uri;
	public $route;
	public $route_raw;

	public function __construct(&$c) {
		$this->c = &$c;

		/* let's clean them out only use this class */
		$_POST = $_GET = $_SERVER = $_FILES = $_COOKIE = $_ENV = $_REQUEST = null;

		foreach ($this->c['request']['server'] as $key => $val) {
			if (substr(strtolower($key),0,4) == 'http') {
				$this->c['request']['header'][substr($key,strpos($key,'_') + 1)] = $val;
			}
		}

		/* what is the protocol http or https? this could be useful! */
		$this->is_https = (strstr('https',strtolower($this->server('SERVER_PROTOCOL'))) === TRUE);

		/* is this a ajax request? */
		$this->is_ajax = ($this->server('HTTP_X_REQUESTED_WITH',NULL) !== NULL && strtolower($this->server('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest');

		/* what is the base url */
		$this->base_url = ($this->is_https ? 'https' : 'http').'://'.trim($this->server('HTTP_HOST').dirname($this->server('SCRIPT_NAME')),'/');

		/* The request method */
		$this->request = ucfirst(strtolower($this->server('REQUEST_METHOD')));

		/* get the uri (uniform resource identifier) */
		$this->uri = trim(urldecode(substr(parse_url($this->server('REQUEST_URI'),PHP_URL_PATH),strlen(dirname($this->server('SCRIPT_NAME'))))),'/');
	}

	public function get($key=null,$default=null,$filter=true) {
		return $this->get_val('get',$key,$default,$filter);
	}

	public function post($key=null,$default=null,$filter=true) {
		return $this->get_val('post',$key,$default,$filter);
	}

	public function put($key=null,$default=null,$filter=true) {
		return $this->get_val('put',$key,$default,$filter);
	}

	public function env($key=null,$default=null,$filter=true) {
		return $this->get_val('env',$key,$default,$filter);
	}

	public function files($key=null,$default=null,$filter=true) {
		return $this->get_val('files',$key,$default,$filter);
	}

	public function cookie($key=null,$default=null,$filter=true) {
		return $this->get_val('cookie',$key,$default,$filter);
	}

	public function param($idx=null,$default=null,$filter=true) {
		$this->c['request']['param'] = explode('/',$this->c['Request']->uri);
		return $this->get_val('param',$idx-1,$default,$filter);
	}

	public function server($key=null,$default=null,$filter=false) {
		return $this->get_val('server',$key,$default,$filter);
	}

	public function header($key=null,$default=null,$filter=false) {
		return $this->get_val('header',$key,$default,$filter);
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

	private function get_val($ary,$key,$default,$filter) {
		if ($key === null) {
			return $this->c['request'][$ary];
		}

		$val = (isset($this->c['request'][$ary][$key])) ? $this->c['request'][$ary][$key] : $default;

		if ($filter === false) {
			return $val;
		}

		if ($filter === true) {
			return $this->filter_xss($val);
		}

		$options = null;
		
		if (is_array($filter)) {
			$key = array_keys($filter);
			$options = $filter[0];
			$filter = $key[0];
		}
		
		if (in_array($filter,filter_list())) {
			return filter_var($val,$filter,$options);
		}

		throw new \Exception('Filter '.$filter.' Not Found',4100);		

		return null;
	}

}