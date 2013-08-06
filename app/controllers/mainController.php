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
	/*
	pass in container
	I then pass it to the base controller but there doesn't have to be one.
	I could just store it locally here but,
	by extending base classes I can inherit a number of methods etc...
	*/
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
		return 'mainController indexPostAction '.$this->c->Request->post('name');
	}

	public function param1PostAction($a=null)
	{
		return 'mainController param1PostAction '.$a.' '.$this->c->Request->post('name');
	}

	public function param2PostAction($a=null,$b=null)
	{
		return 'mainController param2PostAction '.$a.' '.$b.' '.$this->c->Request->post('name');
	}

	public function param3PostAction($a=null,$b=null,$c=null)
	{
		return 'mainController param3PostAction '.$a.' '.$b.' '.$c.' '.$this->c->Request->post('name');
	}

	public function param4PostAction($a=null,$b=null,$c=null,$d=null)
	{
		return 'mainController param4PostAction '.$a.' '.$b.' '.$c.' '.$d.' '.$this->c->Request->post('name');
	}

	public function indexAjaxPostAction()
	{
		return 'mainController indexAjaxPostAction '.$this->c->Request->post('name');
	}

	public function param1AjaxPostAction($a=null)
	{
		return 'mainController param1AjaxPostAction '.$a.' '.$this->c->Request->post('name');
	}

	public function param2AjaxPostAction($a=null,$b=null)
	{
		return 'mainController param2AjaxPostAction '.$a.' '.$b.' '.$this->c->Request->post('name');
	}

	public function param3AjaxPostAction($a=null,$b=null,$c=null)
	{
		return 'mainController param3AjaxPostAction '.$a.' '.$b.' '.$c.' '.$this->c->Request->post('name');
	}

	public function param4AjaxPostAction($a=null,$b=null,$c=null,$d=null)
	{
		return 'mainController param4AjaxPostAction '.$a.' '.$b.' '.$c.' '.$d.' '.$this->c->Request->post('name');
	}


	public function debugAction()
	{
		return '<pre><h3>debug</h3>'.print_r($this->c,true);
	}

	public function helloAction($name=null)
	{
		return 'Hello '.$name.'<pre>'.print_r($this->c,true);
	}

	public function viewAction()
	{
		/* you could create the view object in basePublicController construct or within a hook */
		new \myersd\libraries\view($this->c);

		$this->c->View->set('baseurl',$this->c->Request->base_url,'#');

		return $this->c->View->set('body','<h2>This is the body</h2>')->load('layout');
	}

	public function dbAction()
	{
		/* you could do this in basePublicController construct or with a hook */
		new \myersd\libraries\database($this->c);

		$mPeople = new \models\mpeople;

		$mPeople->keyword_id = mt_rand(1, 9999);
		$mPeople->hash = md5($mPeople->keyword_id);
		$mPeople->create();

		$html = '<pre>';

		$html .= print_r($mPeople,true);
		$html .= print_r($mPeople->count(),true);
		
		return $html;
	}

	public function jsonAction()
	{
		/* you could do this in basePublicController construct or with a hook */
		new \myersd\libraries\view($this->c);

		return $this->c->View
			->set(array('name'=>'Don','age'=>23))
			->json($data);
	}

} /* end controller */
