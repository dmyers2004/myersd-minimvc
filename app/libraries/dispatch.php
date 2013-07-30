<?php
/**
* DMyers Super Simple MVC
*
* @package    Dispatch file
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/
namespace libraries;

class dispatch {

	public function __construct(&$c) {
		/* Turn off all by default */
		//error_reporting(0);

		/* call dispatch hook */
		$c['events']->trigger('startup',$c);

		/* what is the protocal http or https? this could be useful! */
		$c['config']['dispatch']['is https'] = (strstr('https',$c['input']['server']['SERVER_PROTOCOL']) === TRUE);

		/* what is the base url */
		$c['config']['dispatch']['base url'] = ($c['config']['dispatch']['is https'] ? 'https' : 'http').'://'.trim($c['input']['server']['HTTP_HOST'].dirname($c['input']['server']['SCRIPT_NAME']),'/');

		/* The GET method is default so controller methods look like openAction, others are handled directly openPostAction, openPutAction, openDeleteAction, etc... */
		$c['config']['dispatch']['request'] = ucfirst(strtolower($c['input']['server']['REQUEST_METHOD']));

		/* if you don't want different method call for ajax turn this off in preRouter */
		$c['config']['dispatch']['is ajax'] = isset($c['input']['server']['HTTP_X_REQUESTED_WITH']) && strtolower($c['input']['server']['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

		/* get the uri (uniform resource identifier) */
		$c['config']['dispatch']['uri'] = trim(urldecode(substr(parse_url($c['input']['server']['REQUEST_URI'],PHP_URL_PATH),strlen(dirname($c['input']['server']['SCRIPT_NAME'])))),'/');

		/* get the raw uri pieces */
		$segs = explode('/',$c['config']['dispatch']['uri']);

		/* what are we looking for? raw route will also contain the "raw" pre router route incase you need it */
		$c['config']['dispatch']['route'] = $c['config']['dispatch']['route raw'] = '/'.($c['config']['dispatch']['is ajax'] ? 'Ajax' : '').'/'.$c['config']['dispatch']['request'].'/'.array_shift($segs).'/'.array_shift($segs).'/'.implode('/',$segs);

		/* call dispatch hook */
		$c['events']->trigger('preRouter',$c);

		/* rewrite dispatch route */
		foreach ($c['config']['dispatch']['routes'] as $regexpath => $switchto) {
			if (preg_match($regexpath, $c['config']['dispatch']['route'])) {
				/* we got a match */
				$c['config']['dispatch']['route'] = preg_replace($regexpath, $switchto, $c['config']['dispatch']['route']);
				$c['config']['dispatch']['route matched'] = $regexpath;
				break;
			}
		}

		/* ok let's explode our post router route */
		$segs = explode('/',$c['config']['dispatch']['route']);

		/* new routed classname (Controller) */
		$c['config']['dispatch']['classname'] = str_replace('-','_',array_shift($segs));
		
		/* new method to call on classname (Method or Action) replace dashes with underscores */
		$c['config']['dispatch']['called method'] = str_replace('-','_',array_shift($segs));

		/* store whatever is left over in segs */
		$c['config']['dispatch']['segs'] = $segs;

		/* call dispatch hook */
		$c['events']->trigger('preController',$c);

		/* This throws a error and 4004 - handle it in your error handler */
		if (!class_exists($c['config']['dispatch']['classname'])) {
			throw new \Exception($c['config']['dispatch']['classname'].' not found',4004);
		}

		/* create new controller inject $app ($this) */	
		$main_controller = new $c['config']['dispatch']['classname']($c);

		/* call dispatch hook */
		$c['events']->trigger('preMethod',$c);

		/* This throws a error and 4005 - handle it in your error handler */
		if (!is_callable(array($main_controller,$c['config']['dispatch']['called method']))) {
			throw new \Exception($c['config']['dispatch']['classname'].' method '.$c['config']['dispatch']['called method'].' not found',4005);
		}

		/* let's call our method and capture the output */
		$c['output'] = call_user_func_array(array($main_controller,$c['config']['dispatch']['called method']),$c['config']['dispatch']['segs']);

		/* call dispatch hook */
		$c['events']->trigger('preOutput',$c);
	}

}