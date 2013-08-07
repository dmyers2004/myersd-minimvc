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
namespace example\controllers;

class blueShoesController extends  \controllers\basePublicController
{
	public function __construct(&$c)
	{
		parent::__construct($c);
	}

	public function indexAction()
	{
		return 'blueShoesController indexAction';
	}

	public function shoesAction()
	{
		return '<h1>blueShoesController shoesAction</h1>';
	}

	public function inputAction($a=null)
	{
		return '<h1>blueShoesController inputAction</h1><p>'.$a.'</p>';
	}

	public function input_moreAction($a=null,$b=null)
	{
		return '<h1>blueShoesController input_moreAction</h1><p>'.$a.'</p><p>'.$b.'</p>';
	}

} /* end controller */
