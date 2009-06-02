<?php

/**
 * Dispatcher
 **/
class Dispatcher
{
    public static function dispatch()
    {
        $request = Request::getInstance();

        $controller_name = $request->getController();
        $action = $request->getAction();
        
        if(!$controller_name) throw new MfException('no controller set');
        $controller_class = ucfirst($controller_name) . 'Controller';
        
        if(!class_exists($controller_class)) throw new MfException("Can't find Controller: $controller_class");
        
        $controller = new $controller_class;
        if(!$controller instanceof Controller) throw new MfException("Controller:$contoller_class must extend from Controller class");
        
        $controller->execute($action . 'Action', $request);
    }
}
