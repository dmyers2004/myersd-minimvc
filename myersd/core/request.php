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
	public $requests = array();

	public function __construct(&$c)
	{
		$this->c = &$c;

		/* let's clean them out only use this class to pull request data */
		$_POST = $_GET = $_SERVER = $_FILES = $_COOKIE = $_ENV = $_REQUEST = null;

		$this->requests['server'] = $c->request['server'];
		$this->requests['get'] = $c->request['get'];
		$this->requests['post'] = $c->request['post'];
		$this->requests['files'] = $c->request['files'];
		$this->requests['cookie'] = $c->request['cookie'];
		$this->requests['env'] = $c->request['env'];
		$this->requests['put'] = $c->request['put'];
		$this->requests['attributes'] = $c->request['attributes'];

		foreach ($this->requests['server'] as $key => $val) {
			if (substr(strtolower($key),0,4) == 'http') {
				$this->requests['header'][substr($key,strpos($key,'_') + 1)] = $val;
			}
		}

		/* is this http or https? */
		$this->is_https = (strstr('https',strtolower($this->requests['server']['SERVER_PROTOCOL'])) === TRUE);

		/* is this a ajax request? */
		$this->is_ajax = ($this->requests['server']['HTTP_X_REQUESTED_WITH'] !== NULL && strtolower($this->requests['server']['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

		/* what is the base url */
		$this->base_url = ($this->is_https ? 'https' : 'http').'://'.trim($this->requests['server']['HTTP_HOST'].dirname($this->requests['server']['SCRIPT_NAME']),'/');

		/* what is the requested method? */
		$this->request = ucfirst(strtolower($this->requests['server']['REQUEST_METHOD']));

		/* what is the uri */
		$this->uri = trim(urldecode(substr(parse_url($this->requests['server']['REQUEST_URI'],PHP_URL_PATH),strlen(dirname($this->requests['server']['SCRIPT_NAME'])))),'/');

		/* put these in parameters */
		$this->requests['parameters'] = explode('/',$this->uri);
	}

	public function __call($method,$args)
	{
		if (!in_array($method,array('server','get','post','files','cookies','env','put','attributes'))) {
			return null;
		}

		$key = ($args[0]) ? $args[0] : null;

		if ($key === null) {
			return $this->request[$method];
		}

		$default = ($args[1]) ? $args[1] : null;

		$val = (isset($this->requests[$method][$key])) ? $this->requests[$method][$key] : $default;

		$filter = ($args[2]) ? $args[2] : null;
		$options = ($args[3]) ? $args[3] : null;

		if ($filter) {
			return filter_var($val,$filter,$options);
		} else {
			return $val;
		}
	}

} /* end request */