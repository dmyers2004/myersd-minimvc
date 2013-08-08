<?php 

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