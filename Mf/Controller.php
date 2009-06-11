<?php

/**
 * Base Controller
 */

 abstract class Controller
 {
    protected $layout = false;
    protected $template;
    protected $__view_vars__ = array();
    protected $__layout_vars__ = array();

    public function execute($action, Request $request)
    {
    	$this->request = $request;
        // it's a private method of the class or action is not a method of the class
        if (substr($action, 0, 1) == '_' || ! method_exists($this, $action)) {
            throw new Exception("Action '{$action}' doesn't exist");
        }
        $this->layout = Config::get('default_layout');
        if($this->getRequest()->isAjax()) $this->layout = false;
        
        /**
         * User can define a preExecute and postExecute to round there action
         * 
         * preExecute will execute before every action began and
         * postExecute will execute after every action end
         */
        if(method_exists($this, 'preExecute'))
        {
        	call_user_func_array(array($this, 'preExecute'), array($request));	
        }
        // main action
    	call_user_func_array(array($this, $action), array($request));
    	
        if(method_exists($this, 'postExecute'))
        {
        	call_user_func_array(array($this, 'postExecute'), array($request));	
        }
    	
    	// render the view
    	$this->render();
    }
    
    /**
     * get request object	
     *
     * @return Request
     */
    public function getRequest()
    {
    	return Request::getInstance();
    }
    
    public function setTitle($title)
    {
    	$this->__layout_vars__['title'] = $title;
    }
    // redirect
    protected function redirect($url)
    {
        header("Location: $url"); // TODO Is it right?
        exit;
    }

    // set new layout
    protected function setLayout($layout)
    {
        $this->layout = $layout;    
    }
    // Use assigned new template to render view
    protected function setTemplate($tpl)
    {
        $this->template = $tpl; 
    }
    
    // Now view support direct assign
    // set function $this->name = $value
    protected function __set($name, $value)
    {
    	$this->__view_vars__[$name] = $value;
    }
    protected function __get($name)
    {
    	return isset($this->__view_vars__[$name]) ? $this->__view_vars__[$name] : NULL;
    }
    
    // Render view
    protected function render()
    {
        // TODO get the view path
        $controller_name = $this->getRequest()->getController();
        $action_name = $this->getRequest()->getAction();
        $view_path = APP_DIR . DS . 'views' . DS . $controller_name . DS;
        $tpl_path = $view_path . $action_name . ".php";
        
        
        $view = new View($tpl_path, $this->__view_vars__);
        
        // render layout
        if($this->layout)
        {
        	// content here
        	$this->__layout_vars__['mf_layout_content'] = $view->getOutput();
        	$layout_path = APP_DIR . DS . 'views' . DS . 'layout' . DS;
        	$layout = new View($layout_path . $this->layout . '.php', $this->__layout_vars__);
        	
        	Response::getInstance()->setBody($layout->getOutput());
        }
        else
        {
	        // no layout
	       	Response::getInstance()->setBody($view->getOutput());
        }
    }

 }
