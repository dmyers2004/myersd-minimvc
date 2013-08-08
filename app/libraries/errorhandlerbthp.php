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


class DispatcherException extends \Exception
{
   public function __construct($code=0,$controller='',$method='')
   {
			switch($code) {
				case '4004':
					$msg = $controller.' Not Found '.$code;
				break;
				case '4005':
					$msg = $controller.' method '.$method.' Not Found '.$code;
				break;
				default:
					$msg = 'Unknown Dispatcher Exception '.$code;
			}

			die($msg);
   }
}

class DatabaseException extends \Exception
{
   public function __construct($error_txt,$error_code)
   {

   }
}