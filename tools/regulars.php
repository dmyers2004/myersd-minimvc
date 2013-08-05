#!/usr/bin/env php
<?php

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

$argc = $_SERVER['argc'];
$argv = $_SERVER['argv'];

$dir = dirname(__FILE__).'/';
$filename = basename(__FILE__);

date_default_timezone_set('America/New_York');

$ajax_map = array('only'=>'Ajax','yes'=>'Ajax|','no'=>'');

$foo = json_decode(file_get_contents($dir.'/array.json'),true);

$bar = array();

foreach ($foo as $record) {
	$protocol = (empty($record['protocol'])) ? 'http|https' : str_replace(',','|',$record['protocol']);
	$ajax = (empty($record['ajax'])) ? 'Ajax|' :  $ajax_map[$record['ajax']];
	$request = (empty($record['request'])) ? 'Get' : str_replace(',','|',$record['request']);
	$controller = (empty($record['controller'])) ? 'main' : str_replace(',','|',$record['controller']);
	$method = ($record['method']) ? '/([a-zA-Z0-9-_]*)' : '' ;
	$args = ($record['args'] && $record['method']) ? '(.*)' : '';

	$call_controller = str_replace('/',chr(92).chr(92).chr(92),$record['class'].'$4Controller');

	$call_method  = ($record['method']) ? '$5$2Action' : 'index$2Action';
	$call_method .= ($record['args']) ? '$6' : '';

	$bar[] = array('#^('.$protocol.')/('.$ajax.')/('.$request.')/('.$controller.')'.$method.$args.'$#i',$call_controller.'/'.$call_method);
}

$foo = array();
foreach ($bar as $r) {
	$foo[] = "'".$r[0]."' => '".$r[1]."'";
}

usort($foo,'sorter');

echo implode(','.chr(10),$foo);
echo chr(10);

function sorter($a,$b){
    return strlen($a)-strlen($b);
}