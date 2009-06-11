<?php

/**
 * Dispatcher
 **/
class Dispatcher
{
    public static function dispatch()
    {
    	// Initial middleware classes
    	$middlewares = Config::get('middlewares', array());
    	
    	$start_processers = array();
    	foreach ($middlewares as $middleware) 
    	{
    			$start_processers[] = new $middleware;;
    	}
    	    	
    	
    	// start process request
    	$request = Request::getInstance();
    	foreach($start_processers as $processer)
    	{
    	if(method_exists($processer, 'process_request'))
    		{
    			$processer->proccess_request($request);
    		}
    	}
    	
    	// end process request
    	
    	
    	// Core Process
    	$controller = $request->getController();
    	$action = $request->getAction();
    	
        $controller_class = ucfirst($controller) . 'Controller';
        
        if(!class_exists($controller_class)) throw new MfException("Can't find Controller: $controller_class");
        
        $controller = new $controller_class;
        if(!$controller instanceof Controller) throw new MfException("Controller:$controller_class must extend from Controller class");
                
        $controller->execute($action . 'Action', $request);
       	// End Core Process
        
        
        
    	$end_processers = array_reverse($start_processers);
        // start process reponse
        $response = Response::getInstance();
        foreach ($end_processers as $processer)
        {
    		if(method_exists($processer, 'process_response'))
    		{
        		$processer->process_response($response);
    		}
        }
        // end process reponse
    }
}
