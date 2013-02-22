<?php
/**
* DMyers Super Simple MVC
*
* @package    Database for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class Database {
	public static $connections = array();
	public static $config;

	public function __construct($config = NULL) {
		if ($config) {
			self::$config = $config;
		}
	}

	public function connect($dsn,$user,$password,$connection='default') {
		/* if the connection isn't there then try to create it */
		if (!isset(self::$connections[$connection])) {
			try {
				$handle = new PDO($dsn , $user, $password);
			} catch (PDOException $e) {
				throw new Exception($e->getMessage());
			}
			self::$connections[$connection] = $handle;
		}

		return self::$connections[$connection];
	}

	public function connection($connection='default') {
		$prefix = ($connection == 'default') ? '' : $connection.'_';

		$dsn = self::$config['db.'.$prefix.'dsn'];
		$user = self::$config['db.'.$prefix.'user'];
		$password = self::$config['db.'.$prefix.'password'];

		return $this->connect($dsn,$user,$password,$connection);
	}

	public function columns($tablename,$connection='default') {
		$connection = self::$connections[$connection];

		$statement = $connection->prepare('DESCRIBE '.$tablename);
		$statement->execute();
		$table_fields = $statement->fetchAll(PDO::FETCH_COLUMN);
		echo "\$fields = '".implode(',',$table_fields)."';";
	}

}
