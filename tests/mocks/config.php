<?php 

$c['config']['dispatcher'] = array(
 	'run code' => 'mocker',
 	'handler' => 'bird',

	'app' => getcwd().'/app/',
	'folder' => getcwd(),

	'routes' => array(
		'#^(http|https)/(Ajax|)/(Get)/(red)$#i' => '\\\example\\\controllers\\\$4Controller/index$2Action',
		'#^(http|https)/(Ajax|)/(Get)/(red)/([a-zA-Z0-9-_]*)(.*)$#i' => '\\\example\\\controllers\\\$4Controller/$5$2Action$6',

		/* default */
		'#^(http|https)/(Ajax|)/(Get)/$#i' => '\controllers\\\mainController/index$2Action',
		'#^(http|https)/(Ajax|)/(Get)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$4Controller/index$2Action',
		'#^(http|https)/(Ajax|)/(Get)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)(.*)$#i' => '\controllers\\\$4Controller/$5$2Action$6',

		'#^(http|https)/(Ajax|)/(Post|Delete|Put)/$#i' => '\controllers\\\mainController/index$2$3Action',
		'#^(http|https)/(Ajax|)/(Post|Delete|Put)/([a-zA-Z0-9-_]*)$#i' => '\controllers\\\$4Controller/index$2$3Action',
		'#^(http|https)/(Ajax|)/(Post|Delete|Put)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)(.*)$#i' => '\controllers\\\$4Controller/$5$2$3Action$6',
	)

);

Array
(
    [config] => Array
        (
            [dispatcher] => Array
                (
                    [run code] => testing
                    [handler] => apache2handler
                    [app] => /Applications/MAMP/htdocs/basicmvc-template/app/
                    [folder] => /Applications/MAMP/htdocs/basicmvc-template/
                    [routes] => Array
                        (
                            [#^(http|https)/(Ajax|)/(Get)/(red)$#i] => \\example\\controllers\\$4Controller/index$2Action
                            [#^(http|https)/(Ajax|)/(Get)/(red)/([a-zA-Z0-9-_]*)(.*)$#i] => \\example\\controllers\\$4Controller/$5$2Action$6
                            [#^(http|https)/(Ajax|)/(Get)/$#i] => \controllers\\mainController/index$2Action
                            [#^(http|https)/(Ajax|)/(Get)/([a-zA-Z0-9-_]*)$#i] => \controllers\\$4Controller/index$2Action
                            [#^(http|https)/(Ajax|)/(Get)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)(.*)$#i] => \controllers\\$4Controller/$5$2Action$6
                            [#^(http|https)/(Ajax|)/(Post|Delete|Put)/$#i] => \controllers\\mainController/index$2$3Action
                            [#^(http|https)/(Ajax|)/(Post|Delete|Put)/([a-zA-Z0-9-_]*)$#i] => \controllers\\$4Controller/index$2$3Action
                            [#^(http|https)/(Ajax|)/(Post|Delete|Put)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)(.*)$#i] => \controllers\\$4Controller/$5$2$3Action$6
                        )

                    [is https] => 
                    [base url] => http://basicmvc-template.vcap.me
                    [request] => Get
                    [is ajax] => 
                    [uri] => main/debug
                    [route raw] => http//Get/main/debug
                    [route] => \controllers\mainController/debugAction
                    [route matched] => #^(http|https)/(Ajax|)/(Get)/([a-zA-Z0-9-_]*)/([a-zA-Z0-9-_]*)(.*)$#i
                    [classname] => \controllers\mainController
                    [called method] => debugAction
                    [segs] => Array
                        (
                        )

                )

            [folders] => Array
                (
                    [view] => /Applications/MAMP/htdocs/basicmvc-template/app/views/
                    [logs] => /Applications/MAMP/htdocs/basicmvc-template/app/var/logs/
                    [cache] => /Applications/MAMP/htdocs/basicmvc-template/app/var/cache/
                    [session] => /Applications/MAMP/htdocs/basicmvc-template/app/var/sessions/
                    [sqlite] => /Applications/MAMP/htdocs/basicmvc-template/app/var/sqlite/
                )

            [database] => Array
                (
                    [db.dsn] => sqlite:/Applications/MAMP/htdocs/basicmvc-template/app/var/sqlite/messaging.sqlite3
                    [db.user] => 
                    [db.password] => 
                    [db.mysql.dsn] => mysql:host=localhost;dbname=pi
                    [db.mysql.user] => root
                    [db.mysql.password] => root
                )

        )

    [input] => Array
        (
            [server] => Array
                (
                    [REDIRECT_RUNCODE] => testing
                    [REDIRECT_STATUS] => 200
                    [RUNCODE] => testing
                    [HTTP_HOST] => basicmvc-template.vcap.me
                    [HTTP_USER_AGENT] => Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/536.30.1 (KHTML, like Gecko) Version/6.0.5 Safari/536.30.1
                    [HTTP_ACCEPT] => text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
                    [HTTP_DNT] => 1
                    [HTTP_ACCEPT_LANGUAGE] => en-us
                    [HTTP_ACCEPT_ENCODING] => gzip, deflate
                    [HTTP_CONNECTION] => keep-alive
                    [PATH] => /usr/bin:/bin:/usr/sbin:/sbin
                    [SERVER_SIGNATURE] => 
                    [SERVER_SOFTWARE] => Apache/2.2.23 (Unix) mod_ssl/2.2.23 OpenSSL/0.9.8x DAV/2 PHP/5.4.4
                    [SERVER_NAME] => basicmvc-template.vcap.me
                    [SERVER_ADDR] => 127.0.0.1
                    [SERVER_PORT] => 80
                    [REMOTE_ADDR] => 127.0.0.1
                    [DOCUMENT_ROOT] => /Applications/MAMP/htdocs
                    [SERVER_ADMIN] => you@example.com
                    [SCRIPT_FILENAME] => /Applications/MAMP/htdocs/basicmvc-template/public/index.php
                    [REMOTE_PORT] => 53688
                    [REDIRECT_URL] => /main/debug
                    [GATEWAY_INTERFACE] => CGI/1.1
                    [SERVER_PROTOCOL] => HTTP/1.1
                    [REQUEST_METHOD] => GET
                    [QUERY_STRING] => 
                    [REQUEST_URI] => /main/debug
                    [SCRIPT_NAME] => /index.php
                    [PATH_INFO] => /main/debug
                    [PATH_TRANSLATED] => redirect:/index.php/main/debug/debug
                    [PHP_SELF] => /index.php/main/debug
                    [REQUEST_TIME_FLOAT] => 1375482767.88
                    [REQUEST_TIME] => 1375482767
                    [argv] => Array
                        (
                        )

                    [argc] => 0
                )

            [get] => Array
                (
                )

            [post] => Array
                (
                )

            [files] => Array
                (
                )

            [cookies] => Array
                (
                )

            [env] => Array
                (
                    [SHELL] => /bin/bash
                    [TMPDIR] => /var/folders/yx/1vm7hb_s76z5xzvbs9_d35xr0000gp/T/
                    [Apple_PubSub_Socket_Render] => /tmp/launch-QovYRG/Render
                    [__AUTHORIZATION] => auth 3
                    [USER] => myersd
                    [COMMAND_MODE] => unix2003
                    [SSH_AUTH_SOCK] => /tmp/launch-g20pIn/Listeners
                    [_BASH_IMPLICIT_DASH_PEE] => -p
                    [__CF_USER_TEXT_ENCODING] => 0x0:0:0
                    [Apple_Ubiquity_Message] => /tmp/launch-UdmOIR/Apple_Ubiquity_Message
                    [PATH] => /usr/bin:/bin:/usr/sbin:/sbin
                    [PWD] => /
                    [SHLVL] => 3
                    [HOME] => /Users/myersd
                    [DYLD_LIBRARY_PATH] => /Applications/MAMP/Library/lib
                    [LOGNAME] => myersd
                    [DISPLAY] => /tmp/launch-bFIzqX/org.macosforge.xquartz:0
                    [SECURITYSESSIONID] => 186a6
                    [_] => /Applications/MAMP/Library/bin/httpd
                    [RUNCODE] => testing
                )

            [session] => 
            [put] => Array
                (
                )

        )

    [output] => 