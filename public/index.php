<?php
/**
* DMyers Super Simple MVC
*
* @package    Config
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*
* The only publicly visible php file
*
*/

/* Set default timezone of server so PHP doesn't complain */
if (!ini_get('date.timezone')) {
	date_default_timezone_set('UTC');
}

/* turn off error by default */
error_reporting(0);

/* we need to start in the root directory */
chdir('..');

/* load the boot strap and away we go! */
require 'app/boot.php';