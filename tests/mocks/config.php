<?php
/* bogus mock values */
$_PUT = array('name'=>'John Put');
$_SERVER = array(
	'RUNCODE' => 'testing',
	'HTTP_HOST' => 'basicmvc-template.localtest.me',
	'HTTP_CONNECTION' => 'keep-alive',
	'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
	'HTTP_USER_AGENT' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36',
	'HTTP_DNT' => '1',
	'HTTP_REFERER' => 'http://localhost/',
	'HTTP_ACCEPT_ENCODING' => 'gzip,deflate,sdch',
	'HTTP_ACCEPT_LANGUAGE' => 'en-US,en;q=0.8',
	'HTTP_COOKIE' => 'RES_TRACKINGID=57624278062440727; ResonanceSegment=1',
	'PATH' => '/usr/bin:/bin:/usr/sbin:/sbin',
	'SERVER_SIGNATURE' => '',
	'SERVER_SOFTWARE' => 'Apache/2.2.23 (Unix) mod_ssl/2.2.23 OpenSSL/0.9.8x DAV/2 PHP/5.4.4',
	'SERVER_NAME' => 'basicmvc-template.localtest.me',
	'SERVER_ADDR' => '127.0.0.1',
	'SERVER_PORT' => '80',
	'REMOTE_ADDR' => '127.0.0.1',
	'DOCUMENT_ROOT' => '/Applications/MAMP/htdocs',
	'SERVER_ADMIN' => 'you@example.com',
	'SCRIPT_FILENAME' => '/Applications/MAMP/htdocs/basicmvc-template/index.php',
	'REMOTE_PORT' => '51587',
	'GATEWAY_INTERFACE' => 'CGI/1.1',
	'SERVER_PROTOCOL' => 'HTTP/1.1',
	'REQUEST_METHOD' => 'GET',
	'QUERY_STRING' => '',
	'REQUEST_URI' => '/',
	'SCRIPT_NAME' => '/index.php',
	'PHP_SELF' => '/index.php',
	'REQUEST_TIME_FLOAT' => '1374154593.75',
	'REQUEST_TIME' => '1374154593',
	'argv' => Array(),
	'argc' => '0'
);
$_GET = array('name'=>'John Get');
$_POST = array('name'=>'John Post');
$_FILES = array();
$_SESSION = array('key'=>'abc123');
$_COOKIE = array('key'=>'abc123','type'=>'oatmeal');
$_ENV = array(
	'SHELL' => '/bin/bash',
	'TMPDIR' => '/var/folders/yx/1vm7hb_s76z5xzvbs9_d35xr0000gp/T/',
	'Apple_PubSub_Socket_Render' => '/tmp/launch-ssxeq9/Render',
	'__AUTHORIZATION' => 'auth 3',
	'USER' => 'myersd',
	'COMMAND_MODE' => 'unix2003',
	'SSH_AUTH_SOCK' => '/tmp/launch-J7P2Fw/Listeners',
	'_BASH_IMPLICIT_DASH_PEE' => '-p',
	'__CF_USER_TEXT_ENCODING' => '0x0:0:0',
	'Apple_Ubiquity_Message' => '/tmp/launch-Xp7KWJ/Apple_Ubiquity_Message',
	'PATH' => '/usr/bin:/bin:/usr/sbin:/sbin',
	'PWD' => '/',
	'SHLVL' => '3',
	'HOME' => '/Users/myersd',
	'DYLD_LIBRARY_PATH' => '/Applications/MAMP/Library/lib',
	'LOGNAME' => 'myersd',
	'DISPLAY' => '/tmp/launch-8JVGbw/org.macosforge.xquartz:0',
	'SECURITYSESSIONID' => '186a5',
	'_' => '/Applications/MAMP/Library/bin/httpd',
	'RUNCODE' => 'testing'
);

/* setup "assume nothing" config/injection and start the party! */
$config['app'] = array(
 	'run code' => 'mock',
 	'handler' => 'mocker',

	'default controller' => 'main',
	'default method' => 'index',
	'controller suffix' => 'Controller',
	'method suffix' => 'Action',
	'ajax prefix' => 'Ajax',

	'folder' => APP.'/app/'
);

/* injection! baby! */
$config['app']['input'] = array(
	'server' => $_SERVER,
	'get' => $_GET,
	'post' => $_POST,
	'files' => $_FILES,
	'cookies' => $_COOKIE,
	'env' => $_ENV,
	'session' => $_SESSION,
	'put' => $_PUT
);

/* customization baby! */
$config['app']['folders'] = array(
	'controllers' => APP/app/controllers/',
	'libraries' => APP/app/libraries/',
	'models' => APP/app/models/',
	'view' => APP/app/views/',
	'logs' => APP/app/var/logs/',
	'cache' => APP/app/var/cache/',
	'session' => APP/app/var/sessions/',
	'sqlite' => APP/app/var/sqlite/'
);

/* Routes mainController/indexGet[Ajax]Action/a/b/c?name=John */
$config['app']['routes'] = array(
	'#^helloController/(.*)GetAction(.*)$#i' => 'mainController/helloAction/$1$2',
	'#^(.*)/(.*)GetAction$#i' => '$1/$2Action',
	'#^(.*)Controller/(.*)GetAction(.*)$#i' => '$1Controller/$2Action$3'
);

/* database config */
$config['database'] = array(
	'db.dsn' => 'sqlite:'.$config['app']['folders']['sqlite'] .'messaging.sqlite3',
	'db.user' => null,
	'db.password' => null,

	'db.mysql.dsn' => 'mysql:host=localhost;dbname=pi',
	'db.mysql.user' => 'root',
	'db.mysql.password' => 'root'
);

/*
	'#^hello/(.*)$#i' => 'main/hello/$1',
	'#^unit/test$#i' => 'main/unit_test',
	'#^user/(.*)$#i' => 'main/user/$1',
	'#^app/test(.*)#i' => 'main/index$1',
	'#^app(.*)$#i' => 'main/app$1',
	'#^rest/(.*)$#i' => 'rest/index/$1',
*/