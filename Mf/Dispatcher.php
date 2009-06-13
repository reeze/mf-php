<?php

/**
 * Dispatcher
 **/
class Dispatcher
{
    public static function dispatch()
    {
    	// Initial middleware classes
    	$middleware_classes = Config::get('middlewares', array());
    	
    	$middlewares = array();
    	foreach ($middleware_classes as $middleware_class) 
    	{
    			$middlewares[] = new $middleware_class;;
    	}
    	    	
    	// ===========================================
    	// start process request
    	$request = Request::getInstance();
    	foreach($middlewares as $middleware)
    	{
    		if(method_exists($middleware, 'process_request'))
    		{
    			$middleware->process_request($request);
    		}
    	}
    	// end process request
    	
    	// ===========================================
    	// Core Process
    	$controller = $request->getController();
    	$action = $request->getAction();
    	
        $controller_class = ucfirst($controller) . 'Controller';
        
        if(!class_exists($controller_class)) throw new MfException("Can't find Controller: $controller_class");
        
        $controller = new $controller_class;
        if(!$controller instanceof Controller) throw new MfException("Controller:$controller_class must extend from Controller class");
                
        $controller->execute($action . 'Action', $request);
       	// End Core Process
        
        
        // ===========================================
        // start process response
        $response = Response::getInstance();
        // response middleware process in the reverse direction
        foreach (array_reverse($middlewares) as $middleware)
        {
    		if(method_exists($middleware, 'process_response'))
    		{
        		$middleware->process_response($response);
    		}
        }
        // end process reponse
    }
}
