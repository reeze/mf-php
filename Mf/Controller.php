<?php

/**
 * Base Controller
 */

 class Controller
 {
    protected $layout = false;
    protected $template;
    protected $request;
    protected $vars = array();
    protected $layout_vars = array();

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
    	return $this->request;
    }
    
    public function setTitle($title)
    {
    	$this->layout_vars['title'] = $title;
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

    // Assign the var_name to the view
    protected function assign($var_name, $value)
    {
        $this->vars[$var_name] = $value;
    }
    // Render view
    protected function render()
    {
        // TODO get the view path
        $controller_name = $this->getRequest()->getController();
        $action_name = $this->getRequest()->getAction();
        $view_path = APP_DIR . DS . 'views' . DS . $controller_name . DS;
        $tpl_path = $view_path . $action_name . ".php";
        
        
        $view = new View($tpl_path, $this->vars);
        
        // render layout
        if($this->layout)
        {
        	// content here
        	$this->layout_vars['mf_layout_content'] = $view->getOutput();
        	$layout_path = APP_DIR . DS . 'views' . DS . 'layout' . DS;
        	$layout = new View($layout_path . $this->layout . '.php', $this->layout_vars);
        	
        	$layout->display();
        }
        else
        {
	        // simply display the content
	       	$view->display();
        }
    }

 }
