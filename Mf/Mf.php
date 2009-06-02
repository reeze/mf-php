<?php
/** MF: Simple PHP MVC Framework **/

// MF Libray Dir
define('MF_CORE_DIR', dirname(__FILE__));

// for conivent
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

function debug($var)
{
	var_dump($var);exit;
}


/**
 * MF Main Framework class
 **/
class Mf
{
    public static function init()
    {
    	define('MF_START_TIME', time()); // framework start time
		if(!APP_DIR) throw new MfException('Application path havn\'t set yet');
		if(!defined('MF_ENV')) define('MF_EVN', 'dev'); // default env
		
		// set controller include path
		ini_set('include_path', ini_get('include_path') . PS . APP_DIR . DS . 'controllers');
		//debug(ini_get('include_path'));
		
		$env_file = ROOT_DIR . DS . 'config' . DS . MF_ENV . '.php';
		if(!file_exists($env_file)) throw new MfException("Missing env file: $env_file");
		
		// include env config file
		require_once $env_file;
    }
    
    public static function dispatch()
    {
    	self::init();
    	Dispatcher::dispatch();
    }

}

// add include path
ini_set('include_path', ini_get('include_path') . PS .  MF_CORE_DIR . '/'); // TODO add user app model dir.

// autoload
if(!function_exists('__autoload'))
{
    function __autoload($class_name)
    {
        require_once "$class_name.php";
    }
}


// exception handler
function exception_handler(Exception $e)
{
		echo $e->getMessage();
		echo "<pre>" . $e->getTraceAsString() . "</pre>";
		
		echo "<hr /> Vars:<br /><pre>" . var_dump(Request::getInstance()) . "</pre>";
}

set_exception_handler('exception_handler');