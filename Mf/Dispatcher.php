<?php

/**
 * Dispatcher
 **/
class Dispatcher
{
    public static function dispatch()
    {
    	$request = Request::getInstance(); 
    	$controller = $request->getController();
    	$action = $request->getAction();
    	
        $controller_class = ucfirst($controller) . 'Controller';
        
        if(!class_exists($controller_class)) throw new MfException("Can't find Controller: $controller_class");
        
        $controller = new $controller_class;
        if(!$controller instanceof Controller) throw new MfException("Controller:$controller_class must extend from Controller class");
                
        $controller->execute($action . 'Action', $request);
    }
}
