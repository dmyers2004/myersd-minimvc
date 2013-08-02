#!/usr/bin/env php
<?php

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

$argc = $_SERVER['argc'];
$argv = $_SERVER['argv'];

$dir = dirname(__FILE__).'/';
$filename = basename(__FILE__);

date_default_timezone_set('America/New_York');

$tests = array(
	/* get */
	array('http://basicmvc-template.vcap.me','mainController indexAction','get',false),
	array('http://basicmvc-template.vcap.me/main','mainController indexAction','get',false),
	array('http://basicmvc-template.vcap.me/main/','mainController indexAction','get',false),
	array('http://basicmvc-template.vcap.me/main/index','mainController indexAction','get',false),
	array('http://basicmvc-template.vcap.me/main/index/','mainController indexAction','get',false),
	array('http://basicmvc-template.vcap.me/main/foo/','<pre>\controllers\mainController method fooAction not found','get',false),
	array('http://basicmvc-template.vcap.me/foo/bar/','<pre>\controllers\fooController not found','get',false),

	array('http://basicmvc-template.vcap.me/main/param1/a','mainController param1Action a','get',false),
	array('http://basicmvc-template.vcap.me/main/param2/a/b','mainController param2Action a b','get',false),
	array('http://basicmvc-template.vcap.me/main/param3/a/b/c','mainController param3Action a b c','get',false),
	array('http://basicmvc-template.vcap.me/main/param4/a/b/c/d','mainController param4Action a b c d','get',false),

	/* get ajax */
	array('http://basicmvc-template.vcap.me','mainController indexAjaxAction','get',true),
	array('http://basicmvc-template.vcap.me/main','mainController indexAjaxAction','get',true),
	array('http://basicmvc-template.vcap.me/main/','mainController indexAjaxAction','get',true),
	array('http://basicmvc-template.vcap.me/main/index','mainController indexAjaxAction','get',true),
	array('http://basicmvc-template.vcap.me/main/index/','mainController indexAjaxAction','get',true),
	array('http://basicmvc-template.vcap.me/main/foo/','<pre>\controllers\mainController method fooAjaxAction not found','get',true),
	array('http://basicmvc-template.vcap.me/foo/bar/','<pre>\controllers\fooController not found','get',true),

	array('http://basicmvc-template.vcap.me/main/param1/a','mainController param1AjaxAction a','get',true),
	array('http://basicmvc-template.vcap.me/main/param2/a/b','mainController param2AjaxAction a b','get',true),
	array('http://basicmvc-template.vcap.me/main/param3/a/b/c','mainController param3AjaxAction a b c','get',true),
	array('http://basicmvc-template.vcap.me/main/param4/a/b/c/d','mainController param4AjaxAction a b c d','get',true),

	/* post */
	array('http://basicmvc-template.vcap.me','mainController indexPostAction John Doe','post',false),
	array('http://basicmvc-template.vcap.me/main','mainController indexPostAction John Doe','post',false),
	array('http://basicmvc-template.vcap.me/main/','mainController indexPostAction John Doe','post',false),
	array('http://basicmvc-template.vcap.me/main/index','mainController indexPostAction John Doe','post',false),
	array('http://basicmvc-template.vcap.me/main/index/','mainController indexPostAction John Doe','post',false),
	array('http://basicmvc-template.vcap.me/main/foo/','<pre>\controllers\mainController method fooPostAction not found','post',false),
	array('http://basicmvc-template.vcap.me/foo/bar/','<pre>\controllers\fooController not found','post',false),

	array('http://basicmvc-template.vcap.me/main/param1/a','mainController param1PostAction a John Doe','post',false),
	array('http://basicmvc-template.vcap.me/main/param2/a/b','mainController param2PostAction a b John Doe','post',false),
	array('http://basicmvc-template.vcap.me/main/param3/a/b/c','mainController param3PostAction a b c John Doe','post',false),
	array('http://basicmvc-template.vcap.me/main/param4/a/b/c/d','mainController param4PostAction a b c d John Doe','post',false),

	/* post ajax */
	array('http://basicmvc-template.vcap.me','mainController indexAjaxPostAction John Doe','post',true),
	array('http://basicmvc-template.vcap.me/main','mainController indexAjaxPostAction John Doe','post',true),
	array('http://basicmvc-template.vcap.me/main/','mainController indexAjaxPostAction John Doe','post',true),
	array('http://basicmvc-template.vcap.me/main/index','mainController indexAjaxPostAction John Doe','post',true),
	array('http://basicmvc-template.vcap.me/main/index/','mainController indexAjaxPostAction John Doe','post',true),
	array('http://basicmvc-template.vcap.me/main/foo/','<pre>\controllers\mainController method fooAjaxPostAction not found','post',true),
	array('http://basicmvc-template.vcap.me/foo/bar/','<pre>\controllers\fooController not found','post',true),

	array('http://basicmvc-template.vcap.me/main/param1/a','mainController param1AjaxPostAction a John Doe','post',true),
	array('http://basicmvc-template.vcap.me/main/param2/a/b','mainController param2AjaxPostAction a b John Doe','post',true),
	array('http://basicmvc-template.vcap.me/main/param3/a/b/c','mainController param3AjaxPostAction a b c John Doe','post',true),
	array('http://basicmvc-template.vcap.me/main/param4/a/b/c/d','mainController param4AjaxPostAction a b c d John Doe','post',true),
);

/* get tests */
foreach ($tests as $rec) {
	$reply = run_curl($rec[2],$rec[0],$rec[3]);

	$foo = $rec[0].' '.$rec[2].' '.(($rec[3]) ? 'Ajax' : '');

	if ($reply === $rec[1]) {
		echo '++ Passed '.$foo.chr(10);
	} else {
		echo '** Fail   '.$foo.chr(10);
		echo '   Looking for '.$rec[1].chr(10);
		echo '   Received '.$reply.chr(10);
		die();
	}
}

function run_curl($type,$url,$ajax) {
	$ch = curl_init();

	switch ($type) {
		case 'get':
		break;
		case 'post':
			$fields = array('name'=>'John Doe');
		
			curl_setopt($ch, CURLOPT_POST, count($fields));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
		break;
	}

	if ($ajax) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
	    "Accept: application/json, text/javascript, */*; q=0.01",
	    "Accept-Language: en-us,en;q=0.5",
	    "Accept-Encoding: gzip, deflate",
	    "Connection: keep-alive",
	    "X-Requested-With: XMLHttpRequest",
	    "Referer: http://www.somehost.com/"
	  ));
	}

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
