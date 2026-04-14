<?php
ini_set('display_errors',0);
ini_set('error_reporting',E_ERROR | E_PARSE );

define('basePath','/var/www/ash.scooom.xyz/');
define('baseTplPath',basePath.'/tpl/');
define('HardPath',basePath.'Classes/');
define('debugLog',basePath.'/logs/debugLog');
define('debugMode',1);

# A function which returns users IP
function client_ip()
{
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		return $_SERVER['REMOTE_ADDR'];
	}
}


