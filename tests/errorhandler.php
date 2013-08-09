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

class errorhandler
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
		self::$c['Logger']->addCritical(print_r($exception,true));

		$this->c64error($exception);
	}

	/* wrapper old school error handler into new error handler */
	public function oldSchoolErrorHandler($errno, $errstr, $errfile, $errline)
	{
		$e = new \ErrorException($errstr,$errno,0,$errfile,$errline);
		$this->exceptionHandler($e);
		return true;
	}

	private function c64error($exception)
	{
		if (!headers_sent()) {
			header('HTTP/1.0 404 Not Found');
		}

		die('<!DOCTYPE html>
		<html lang="en">
		<head>
		<meta charset="utf-8">
		<title>Syntax Error</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link href="http://fonts.googleapis.com/css?family=VT323" rel="stylesheet" type="text/css">
		<!-- cursor blink from https://gist.github.com/2902229 -->
		<style>
		* { font-size: 36px; margin: 0; padding: 0; line-height: 36px; text-transform: uppercase;font-family: "VT323", "Courier New", Courier, mono; font-weight: 700;}
		html { height: 100%; width: 100%; display: table; }
		body { display: table-row; background-color: #3D2FCB; color: #9181FB; }
		b { display: block; text-align: center; font-weight: normal; }
		#wrapper { display: table-cell; border: 50px solid #9181FB; padding: 4px; }
		div.cursor { display: inline-block; background: #3D2FCB; -webkit-animation: blink 2s linear 0s infinite; -moz-animation: blink 2s linear 0s infinite; -ms-animation: blink 2s linear 0s infinite; -o-animation: blink 2s linear 0s infinite; }
		@-webkit-keyframes blink { 0% { background: #9181FB } 50% { background: #9181FB } 51% { background: #3D2FCB } 100% { background: #3D2FCB } }
		@-moz-keyframes blink { 0% { background: #9181FB } 50% { background: #9181FB } 51% { background: #3D2FCB } 100% { background: #3D2FCB } }
		@-ms-keyframes blink { 0% { background: #9181FB } 50% { background: #9181FB } 51% { background: #3D2FCB } 100% { background: #3D2FCB } }
		@-o-keyframes blink { 0% { background: #9181FB } 50% { background: #9181FB } 51% { background: #3D2FCB } 100% { background: #3D2FCB } }
		</style>
		</head>
		<body>
		<div id="wrapper">
		<b>**** Super Small MVC v'.phpversion().' ****</b>
		<b>memory '.floor(memory_get_peak_usage()/1024).'K of '.ini_get('memory_limit').' used</b>
		<p>&nbsp;</p>
		<p>ready.</p>
		<p>load "'.$exception->getFile().'",8,1</p>
		<P>run</P>
		<p>?syntax error '.$exception->getCode().' @ '.$exception->getLine().'</p>
		<p>'.$exception->getMessage().'</p>
		<p>ready.</p>
		<div class="cursor">&nbsp;</div>
		</div>
		</body>
		</html>');
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
