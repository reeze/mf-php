<?php

/**
 * Request class
 **/
class mfRequest
{
    // HTTP methods
    const GET = 'get';
    const POST = 'post';
    const PUT = 'put';
    const DELETE = 'delete';
    // special for ajax request
    const AJAX = 'ajax';

    private static $_instance;
    private $parameters = array();
    

    // singleton parten, disable new method
    private function __construct()
    {
        // TODO clean it first
        $this->parameters = $_REQUEST; // TODO GET POST and URL embed
        
        //
        if(!mfConfig::get('url_rewrite') && 
        	strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']) == 0) // eg: /index.php/blah
        {
        	$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
        }
        else // url_rewrited
        {
        	$query_str = $_SERVER['QUERY_STRING'];
        	$path_info = $_SERVER['REQUEST_URI'];
        	// trim the query string
        	if($query_str)
        	{
        		// +1 means the '?' before query string
        		$path_info = substr($_SERVER['REQUEST_URI'], 0, - (strlen($query_str) + 1));
        	}
        }
        $this->setParameter('request_path_info', $path_info);
    }

    /**
     * Get the request value by key
     * @param $key string
     * @return mixed
     */
    public function getParameter($key, $default = null)
    {
       return isset($this->parameters[$key]) ? $this->parameters[$key] : $default;
    }
    
    public function setParameter($key, $value)
    {
    	if(!$key) return;
    	$this->parameters[$key] = $value;
    }
    
    public function getAction()
    {
    	return $this->getParameter('action');
    }
    
    public function getController()
    {
    	return $this->getParameter('controller');
    }
    
    public function setAction($action)
    {
    	$this->setParameter('action', $action);
    }
    
    public function getFormat()
    {
    	return $this->getParameter('format', 'html');
    }
    public function setFormat($value)
    {
    	$this->setParameter('format', $value);
    }

    public function getMethod()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') return self::AJAX;
     	if(!empty($_POST)) return self::POST;
     	
        return self::GET;
    }

    public function isAjax()
    {
        return $this->getMethod() == self::AJAX;
    }

    /**
     * get request instance
     *
     * @return Request
     */
    public static function getInstance()
    {
        if(!self::$_instance)
        {
            self::$_instance = new self(); 
        }
        return self::$_instance;
    }
}
