<?php 
// INSTALL_ROOT is defined in the index.php bootstrap file
define('MODULES_FOLDER', '../modules');
define('FUEL_FOLDER', 'fuel');
define('MODULES_PATH', APPPATH.MODULES_FOLDER.'/');
define('MODULES_FROM_APPCONTROLLERS', '../'.MODULES_FOLDER.'/');
define('FUEL_PATH', MODULES_PATH.FUEL_FOLDER.'/');
define('WEB_ROOT', str_replace('\\', '/', realpath(dirname(SELF)).DIRECTORY_SEPARATOR)); // replace \ with / for windows

// needed to take care of some server environments
$_SERVER['SCRIPT_NAME'] = preg_replace('#^/(.+)\.php/(.*)#', '/$1.php', $_SERVER['SCRIPT_NAME']);
define('WEB_PATH', str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']));

// change slashes for some Windows platforms
$_FUEL_SEGS = explode('/', str_replace("\\", '/', $_SERVER['SCRIPT_FILENAME']));

define('WEB_FOLDER', (count($_FUEL_SEGS) > 1) ? $_FUEL_SEGS[count($_FUEL_SEGS)-2] : '/');
define('MODULES_WEB_PATH', FUEL_FOLDER.'/modules/');


/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

// Define Ajax Request
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
//  

/* End of file constants.php */
/* Location: ./application/config/constants.php */