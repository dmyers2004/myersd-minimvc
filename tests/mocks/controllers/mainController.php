<?php
/**
	* DMyers Super Simple MVC
	*
	* @package    main Controller File
	* @language   PHP
	* @author     Don Myers
	* @copyright  Copyright (c) 2011
	* @license    Released under the MIT License.
	*
	*/
namespace controllers;

class mainController extends basePublicController
{
	public function __construct(&$c)
	{
		parent::__construct($c);
	}

	public function indexAction()
	{
		return 'mainController indexAction';
	}
	
	public function param1Action($a=null)
	{
		return 'mainController param1Action '.$a;
	}

	public function param2Action($a=null,$b=null)
	{
		return 'mainController param2Action '.$a.' '.$b;
	}

	public function param3Action($a=null,$b=null,$c=null)
	{
		return 'mainController param3Action '.$a.' '.$b.' '.$c;
	}

	public function param4Action($a=null,$b=null,$c=null,$d=null)
	{
		return 'mainController param4Action '.$a.' '.$b.' '.$c.' '.$d;
	}

	public function indexAjaxAction()
	{
		return 'mainController indexAjaxAction';
	}
	
	public function param1AjaxAction($a=null)
	{
		return 'mainController param1AjaxAction '.$a;
	}

	public function param2AjaxAction($a=null,$b=null)
	{
		return 'mainController param2AjaxAction '.$a.' '.$b;
	}

	public function param3AjaxAction($a=null,$b=null,$c=null)
	{
		return 'mainController param3AjaxAction '.$a.' '.$b.' '.$c;
	}

	public function param4AjaxAction($a=null,$b=null,$c=null,$d=null)
	{
		return 'mainController param4AjaxAction '.$a.' '.$b.' '.$c.' '.$d;
	}

	public function indexPostAction()
	{
		return 'mainController indexPostAction '.$_POST['name'];
	}
	
	public function param1PostAction($a=null)
	{
		return 'mainController param1PostAction '.$a.' '.$_POST['name'];
	}

	public function param2PostAction($a=null,$b=null)
	{
		return 'mainController param2PostAction '.$a.' '.$b.' '.$_POST['name'];
	}

	public function param3PostAction($a=null,$b=null,$c=null)
	{
		return 'mainController param3PostAction '.$a.' '.$b.' '.$c.' '.$_POST['name'];
	}

	public function param4PostAction($a=null,$b=null,$c=null,$d=null)
	{
		return 'mainController param4PostAction '.$a.' '.$b.' '.$c.' '.$d.' '.$_POST['name'];
	}

	public function indexAjaxPostAction()
	{
		return 'mainController indexAjaxPostAction '.$_POST['name'];;
	}
	
	public function param1AjaxPostAction($a=null)
	{
		return 'mainController param1AjaxPostAction '.$a.' '.$_POST['name'];;
	}

	public function param2AjaxPostAction($a=null,$b=null)
	{
		return 'mainController param2AjaxPostAction '.$a.' '.$b.' '.$_POST['name'];;
	}

	public function param3AjaxPostAction($a=null,$b=null,$c=null)
	{
		return 'mainController param3AjaxPostAction '.$a.' '.$b.' '.$c.' '.$_POST['name'];;
	}

	public function param4AjaxPostAction($a=null,$b=null,$c=null,$d=null)
	{
		return 'mainController param4AjaxPostAction '.$a.' '.$b.' '.$c.' '.$d.' '.$_POST['name'];;
	}

} /* end controller */
