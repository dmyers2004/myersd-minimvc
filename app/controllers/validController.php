<?php
/**
	* DMyers Super Simple MVC
	*
	* @package    blue Controller File
	* @language   PHP
	* @author     Don Myers
	* @copyright  Copyright (c) 2011
	* @license    Released under the MIT License.
	*
	*/
namespace controllers;

class validController extends basePublicController
{
	public function __construct(&$c)
	{
		parent::__construct($c);
	}

	public function indexAction()
	{
		return 'CookController indexAction';
	}

	public function setAction($name='')
	{
		/* https://github.com/vlucas/valitron */
		$v = new \Valitron\Validator(array('name' => $name));

		\Valitron\Validator::addRule('md5', function($field, $value) {
    	return (!preg_match('/^([a-zA-Z0-9]{32})$/', $value)) ? false : true;
		}, 'is not a MD5 value');
		
		$v->rule('required','name');
		$v->rule('md5','name');
		$v->rule('length','name','32');
		
		if ($v->validate()) {
			return "Yay! We're all good!";
		} else {
			return print_r($v->errors(),true);
		}
	}
	
	public function testAction($num='')
	{
		$foo = $this->c->Request->get('num',0,FILTER_SANITIZE_STRING);
		
		return '<h3>Foo is: '.(($foo) ? 'true' : 'false').'</h3>';
	}

} /* end controller */
