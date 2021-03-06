<?php

/**
 * Dispatcher
 **/
class mfDispatcher
{
    public static function dispatch()
    {
    	// Initial middleware classes
    	$middleware_classes = mfConfig::get('middlewares', array());
    	
    	$middlewares = array();
    	foreach ($middleware_classes as $middleware_class) 
    	{
    		require_once "middleware/$middleware_class.php";
    		$middlewares[] = new $middleware_class;;
    	}
    	    	
    	// ===========================================
    	// start process request
    	$request = mfRequest::getInstance();
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
        if(!$controller instanceof mfController) throw new MfException("Controller:$controller_class must extend from mfController class");
        
        $controller->execute($action . 'Action', $request);
       	// End Core Process
        
        
        // ===========================================
        // start process response
        $response = mfResponse::getInstance();
        // response middleware process in the reverse direction
        foreach (array_reverse($middlewares) as $middleware)
        {
    		if(method_exists($middleware, 'process_response'))
    		{
        		$middleware->process_response($response);
    		}
        }
        // end process response
    }
}
