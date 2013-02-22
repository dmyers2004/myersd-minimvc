<?php

class restController extends basePublicController {

	public function indexAction($a='') {
		echo 'REST Get '.$a;
		print_r($_GET);
	}

	public function indexPutAction() {
		echo 'REST Put';
		print_r($_POST);
	}

	public function indexPostAction() {
		echo 'REST Post';
		print_r($_POST);
	}

	public function indexDeleteAction($a='') {
		echo 'REST Delete '.$a;
		print_r($_GET);
	}

} /* end class */
