<?php
/**
* DMyers Super Simple MVC
*
* @package    error handler
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/
namespace libraries;

class errorhandlerbthp
{
	public static $c;

	public function __construct(&$c)
	{
		self::$c = &$c;

		set_exception_handler(array($this,'exceptionHandler'));
		set_error_handler(array($this,'oldSchoolErrorHandler'),error_reporting());
	}

	public function exceptionHandler($exception)
	{
		self::$c['Logger']->addCritical(print_r($exception,true));

		header('Location: '.self::$c['config']['dispatcher']['base url']);
		exit;
	}

	/* wrapper old school error handler into new error handler */
	public function oldSchoolErrorHandler($errno, $errstr, $errfile, $errline)
	{
		$e = new \ErrorException($errstr,$errno,0,$errfile,$errline);
		$this->exceptionHandler($e);
		return true;
	}

}
