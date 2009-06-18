<?php

/** MF: Simple PHP MVC Framework **/
/**
 * @author Reeze <reeze.xia@gmail.com>
 * @copyright GPL ? thoes license are confuse. maybey someday I will look into them
 * 
 * You can use it freely, but no guarantee made.
 *
 */

// MF Libray Dir
define('MF_CORE_DIR', dirname(__FILE__));

// for conivent
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

/**
 * MF Main Framework class
 **/
class Mf
{
	const MAJOR_VERSION = '0';
	const MINOR_VERSION = '1';
	const REVISION		= '1';
	
    public static function init()
    {
    	define('MF_START_TIME', time()); // framework start time
		if(!APP_DIR) throw new MfException('Application path havn\'t set yet');
		if(!defined('MF_ENV')) define('MF_EVN', 'dev'); // default env
		
		// start session support
		session_start();
		
		// We have to explict require auto load class here
		require_once MF_CORE_DIR . '/autoload/mfAutoloader.class.php';
		mfAutoLoader::initPath();
		

		
		$config_path = ROOT_DIR . DS . 'config';
		
		// load config file	
		require_once $config_path . DS . 'config.php';
		


		$env_file = $config_path . DS . 'env' .  DS . MF_ENV . '.php';
		if(!file_exists($env_file)) throw new MfException("Missing env file: $env_file");
		
		
		//include helpers
		require_once 'util/mfUtils.php';
		
		// use default helpers: url, view
		UseHelper("Url", 'View', 'Asset');
		
		// include env config file
		require_once $env_file;
    }
    
    public static function dispatch()
    {
    	self::init();
    	//load routes file
    	require_once ROOT_DIR . DS . 'config/routes.php';
    	
    	// get controller and action
    	mfRoute::route();
    	mfDispatcher::dispatch();
    }
    
    /**
     * Get the current MF version
     *
     */
    public static function getVersion()
    {
    	return self::MAJOR_VERSION . self::MINOR_VERSION . self::REVISION;
    } 

}


error_reporting(E_ALL | E_STRICT);

// exception handler
function exception_handler(Exception $e)
{
	ob_clean();
	ob_start();
		echo "<div id=\"msg\">" . $e->getMessage() . "</div>";
		echo "<pre>" . $e->getTraceAsString() . "</pre>";
		
		echo "<hr /> Vars:<br /><pre>" . var_dump(mfRequest::getInstance()) . "</pre>";
	$content = ob_get_clean();
	
	$view = new mfView(MF_CORE_DIR . DS . 'default' . DS . 'layout.php', array('mf_layout_content' => $content));
	$view->display();
}

set_exception_handler('exception_handler');
