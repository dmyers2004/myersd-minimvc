<?php 

set_exception_handler('exceptionHandler');
set_error_handler('oldSchoolErrorHandler',error_reporting());

function exceptionHandler($exception) {
	if (!headers_sent()) {
		header('HTTP/1.0 404 Not Found');
	}

	echo '<pre>';
	print_r($exception);
}

/* wrapper old school error handler into new error handler */
function oldSchoolErrorHandler($errno, $errstr, $errfile, $errline) {
	exceptionHandler(new \ErrorException($errstr,$errno,0,$errfile,$errline));
	return true;
}

class DispatcherException extends Exception
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

class DatabaseException extends Exception
{
   public function __construct($msg,$code)
   {
			die($code.' '.$msg);
   }
}

