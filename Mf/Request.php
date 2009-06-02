<?php

/**
 * Request class
 **/
class Request
{
    // HTTP methods
    const GET = 'get';
    const POST = 'post';
    const PUT = 'put';
    const DELETE = 'delete';
    // special for ajax request
    const AJAX = 'ajax';

    private static $_instance;
    private $_parameters = array();

    // singleton parten, disable new method
    private function __construct()
    {
        // TODO clean it first
        $this->_parameters = $_REQUEST; // TODO GET POST and URL embed 
    }

    /**
     * Get the request value by key
     * @param $key string
     * @return mixed
     */
    public function getParameter($key)
    {
       return $this->_parameters[$key];
    }
    
    /**
     * Get controller name
     *
     * @return string
     */
    public function getController()
    {
    	return $this->getParameter('controller');	
    }
    public function getAction()
    {
    	return $this->getParameter('action');
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
            self::$_instance = new Request(); 
        }
        return self::$_instance;
    }
}
