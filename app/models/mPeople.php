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

class mPeople extends Orm {

	public function __construct() {
		$fields = 'id,hash,keyword_id';

		$this->tablename = 'people';
		$this->pkname = 'id'; //Name of auto-incremented Primary Key
		$this->fields = explode(',',$fields);
		$this->connection = (new Database)->connection(); // database connection

		parent::__construct();
	}

}
