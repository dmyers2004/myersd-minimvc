<?php
/**
* DMyers Super Simple MVC
*
* @package    response file
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/
namespace myersd\core;

class response
{
	private $c;
	public $headers = array();
	public $body = '';
	public $url;
	public $json;
	public $options;

	public function __construct(&$c)
	{
		$this->c = &$c;

		$this->headers = $this->c->response['headers'];
		$this->body = $this->c->response['body'];
	}

	public function addHeader($header)
	{
		$key = strtolower(substr($header,0,strpos($header, ':')));

		$this->headers[$key] = $header;

		return $this;
	}

	public function redirect($url)
	{
		/* call dispatch event */
		$this->url = &$url;

		$this->c->Event->preResponseRedirect();

		$this->add_header('Location: '.$this->url);

		return $this;
	}

	public function sendHeaders()
	{
		/* call dispatch event */
		$this->c->Event->preResponseHeaders();

		foreach ($this->headers as $h) {
			header($h);
		}

		return $this;
	}

	public function sendBody()
	{
		/* call dispatch event */
		$this->c->Event->preResponseBody();

		echo $this->body;

		if ($this->c->response['profile']) {
			echo '<p>'.(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']).'ms</p>';
			echo '<p>'.(memory_get_peak_usage(true)/1024).'k</p>';
		}
	}

	public function json($json=null,$options=0)
	{
		$this->json = &$json;
		$this->options = &$options;

		/* call dispatch event */
		$this->c->Event->preResponseJson();

		$this->addHeader('Cache-Control: no-cache, must-revalidate');
		$this->addHeader('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		$this->addHeader('Content-Type: application/json; charset=utf=8');

		$this->body = json_encode($this->json,$this->options);

		return $this;
	}

	/* lot o config */
	public function setCookie($key='',$value='',$expire=null,$path=null,$domain=null,$secure=null,$httponly=null)
	{
		$expire = ($expire === null) ? $this->c->response['cookie.expire'] : 0;
		$path = ($path === null) ? $this->c->response['cookie.path'] : '/';
		$domain = ($domain === null) ? $this->c->response['cookie.domain'] : null;
		$secure = ($secure === null) ? $this->c->response['cookie.secure'] : false;
		$httponly = ($httponly === null) ? $this->c->response['cookie.httponly'] : false;

		return setcookie($key,$value,time() + $expire,$path,$domain,$secure,$httponly);
	}

}
