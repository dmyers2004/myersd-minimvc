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

class errorhandlerbasic
{
	public static $c;

	public function __construct(&$c)
	{
		self::$c = $c;

		set_exception_handler(array($this,'exceptionHandler'));
		set_error_handler(array($this,'oldSchoolErrorHandler'),error_reporting());
	}

	public function exceptionHandler($exception)
	{
		echo '<pre>';
		switch($exception->getCode()) {
			case 4004:
				echo $exception->getMessage();
			break;
			case 4005:
				echo $exception->getMessage();
			break;
			default:
				print_r($exception);
		}
	}

	/* wrapper old school error handler into new error handler */
	public function oldSchoolErrorHandler($errno, $errstr, $errfile, $errline)
	{
		$e = new \ErrorException($errstr,$errno,0,$errfile,$errline);
		$this->exceptionHandler($e);
		return true;
	}

}
