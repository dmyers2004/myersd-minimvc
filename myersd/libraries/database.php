<?php
/**
* DMyers Super Simple MVC
*
* @package    Database file
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/
namespace myersd\libraries;

class database
{
	public static $c;
	public static $databaseHandles = array();

	public function __construct(&$c)
	{
		self::$c = &$c;
	}

	public function connection($prefix='default')
	{
		$dsn = self::$c->database['db.'.$prefix.'.dsn'];
		$user = self::$c->database['db.'.$prefix.'.user'];
		$password = self::$c->database['db.'.$prefix.'.password'];
		
		/* if the connection isn't there then try to create it */
		if (!isset(self::$databaseHandles[$prefix])) {
			try {
				$handle = new \PDO($dsn , $user, $password);
			} catch (PDOException $e) {
				throw new \Exception($e->getMessage());
			}
			self::$databaseHandles[$prefix] = $handle;
		}

		return self::$databaseHandles[$prefix];
	}

	public function _columns($tablename,$connection='default')
	{
		$connection = $this->connection($connection);

		$statement = $connection->prepare('DESCRIBE '.$tablename);
		$statement->execute();
		$table_fields = $statement->fetchAll(PDO::FETCH_COLUMN);
		echo "\$this->fields = array('".implode("','",$table_fields)."');";
	}

}
