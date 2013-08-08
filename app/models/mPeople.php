<?php
/**
	* DMyers Super Simple MVC
	*
	* @package    Example Model File
	* @language   PHP
	* @author     Don Myers
	* @copyright  Copyright (c) 2011
	* @license    Released under the MIT License.
	*
	*/
namespace models;

class mPeople extends \myersd\libraries\orm
{
	public $tablename = 'people';
	public $pkname = 'id'; //Name of auto-incremented Primary Key
	public $fields = array('id','hash','keyword_id');
	public $connection = 'default';
	
	public function __construct()
	{
		parent::__construct();
	}

}
