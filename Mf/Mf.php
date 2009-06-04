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
		
		$config_path = ROOT_DIR . DS . 'config';
		
		// load config file	
		require_once $config_path . DS . 'config.php';
		
		$env_file = $config_path . DS . 'env' .  DS . MF_ENV . '.php';
		if(!file_exists($env_file)) throw new MfException("Missing env file: $env_file");
		
		
		//include helpers
		require_once 'MfUtils.php';
		
		// use default helpers: url, view
		UseHelper("Url", 'View');
		
		// include env config file
		require_once $env_file;
    }
    
    public static function dispatch()
    {
    	self::init();
    	
    	//load routes file
    	require_once ROOT_DIR . DS . 'config/routes.php';
    	
    	// get controller and action
    	Router::route();
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
        include "$class_name.php";
    }
}

error_reporting(E_ALL | E_STRICT);
// exception handler
function exception_handler(Exception $e)
{
	ob_start();
		echo "<div id=\"msg\">" . $e->getMessage() . "</div>";
		echo "<pre>" . $e->getTraceAsString() . "</pre>";
		
		echo "<hr /> Vars:<br /><pre>" . var_dump(Request::getInstance()) . "</pre>";
	$content = ob_get_clean();
	
	$view = new View(MF_CORE_DIR . DS . 'default' . DS . 'layout.php', array('mf_layout_content' => $content));
	$view->display();
}

set_exception_handler('exception_handler');