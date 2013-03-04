<?php

/* setup the routes */
$config['routes'] = array(
	'#^hello/(.*)$#i' => 'main/hello/$1',
	'#^unit/test$#i' => 'main/unit_test',
	'#^user/(.*)$#i' => 'main/user/$1',
	'#^app/test(.*)#i' => 'main/index/$1',
	'#^app(.*)$#i' => 'main/app$1',
	'#^rest/(.*)$#i' => 'rest/index/$1',
);

/*

we then take the match from
above (if any) and prepend
the raw request in lowercase to
the uri and run these matches

ie raw uri /hello/don converted to /main/hello/don
then the request is prepended to the uri
get/main/hello/don

therefore the get get converted to post using the following

^get/main/hello(.*)$ => 'post'

*/
$config['requests'] = array(
	'#^get(.*)$#i' => '',
);
