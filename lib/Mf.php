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
		
        //include helpers
		require_once 'util/mfUtils.class.php';

		if(!APP_DIR) throw new MfException('Application path havn\'t set yet');
		if(!defined('MF_ENV')) define('MF_EVN', 'dev'); // default env
		
		// start session support
		session_start();
		
			
		// We have to explict require auto load class here
		require_once MF_CORE_DIR . '/autoload/mfAutoloader.class.php';
		mfAutoLoader::initPath();
		
    	require_once 'sfYaml/sfYaml.php';
		
		
		// load config file	
		self::loadConfig();	
		
		self::loadModel();
		
		// register view classes
		self::registerViewClasses();

		$config_path = ROOT_DIR . DS . 'config';
		$env_file = $config_path . DS . 'env' .  DS . MF_ENV . '.php';
		if(!file_exists($env_file)) throw new MfException("Missing env file: $env_file");
		
		
		
		// use default helpers: url, view
		UseHelper("Url", 'View', 'Asset');
		
		// include env config file
		require_once $env_file;
		
		
		// add controller class path
		mfAutoLoader::addPath(APP_DIR . DS . 'controllers');
		mfAutoLoader::addPath(APP_DIR . DS . 'components');
		mfAutoLoader::addPath(APP_DIR . DS . 'models');
		mfAutoLoader::addPath(APP_DIR . DS . 'models' . DS . 'generated');
    }
    
    public static function dispatch()
    {
    	self::init();
    	
    	//load routes file
    	self::loadRoute();
    	
    	// Load models
    	
    	// get controller and action
    	mfRoute::route();
    	mfDispatcher::dispatch();
    }
    
    public static function loadModel()
    {
    	if(mfConfig::get('use_database'))
    	{
            $db_file = ROOT_DIR . DS . 'config'. DS . 'database.yml';
            if(!file_exists($db_file)) throw new mfException("Missing file: database.yml");

    	    $databases = sfYaml::load($db_file);
    		require_once 'Doctrine/Doctrine.php';
    		// autoload for doctrine
            spl_autoload_register(array('Doctrine', 'autoload'));
            
            $manager = Doctrine_Manager::getInstance();
            $conn = Doctrine_Manager::connection($databases[MF_ENV]['dsn']);
            
            $manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
    	}
    }
    
    public static function loadRoute()
    {
    	
    	$array = sfYaml::load(ROOT_DIR . DS . 'config' . DS . 'routing.yml');
    	
    	$routes = array();
    	foreach ($array as $name => $route)
    	{
    		$routes[] = array($name, $route['url'], $route['params']);
    		// formated route
    		$routes[] = array("{$name}_formatted", $route['url'] . '.:format', $route['params']);
    	}
    	
    	mfRoute::connect($routes);
    }
    
    /**
     * Load config files
     *
     */
    public static function loadConfig()
    {
    	$config = sfYaml::load(ROOT_DIR . DS . 'config' . DS . 'config.yml');
    	
    	mfConfig::init($config);
    }
    
    
    public static function registerViewClasses()
    {
    	$classes = array();
    	$views = mfConfig::get('views');
    	foreach ($views as $view)
    	{
    		$classes[] = call_user_func(array($view, 'register'));
    	}
    	mfConfig::set('mf.view.classes', $classes);
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
		
// I use findTemplateFileName() function here , so we have to include this file first
// FIXME it seems not good here
require_once 'util/mfUtils.class.php';

// exception handler
function exception_handler(Exception $e)
{
//	ob_clean();
	ob_start();
		echo "<div id=\"msg\">" . $e->getMessage() . "</div>";
		echo "<pre>" . $e->getTraceAsString() . "</pre>";
		
		echo "<hr /> Vars:<br /><pre>" . var_dump(mfRequest::getInstance()) . "</pre>";
	$content = ob_get_clean();

    // findTemplateFileName may throw exception, but PHP5.2.5 can't handle this
    try
    {
	    list($file, $view_class) = findTemplateFileName(MF_CORE_DIR . DS . 'default' . DS . 'layout');
	    $view = new $view_class($file, array('mf_layout_content' => $content));
	    $view->display();
    }
    catch (Exception $e_in)
    {
        echo $content . "<hr />";
        echo "<div>" . $e_in->getMessage() . "</div>";
        echo "<pre>" . $e_in->getTraceAsString() . "</pre>";
    }
}

set_exception_handler('exception_handler');
