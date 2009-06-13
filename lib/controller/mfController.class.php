<?php

/**
 * Base Controller
 */

 class mfController
 {
    protected $layout = false;
    protected $template;
    protected $_view_vars_ = array();
    protected $_layout_vars_ = array();

    public function execute($action, mfRequest $request)
    {
        // it's a private method of the class or action is not a method of the class
        if (substr($action, 0, 1) == '_' || ! method_exists($this, $action)) {
            throw new Exception("Action '{$action}' doesn't exist in " . get_class($this));
        }
        $this->layout = mfConfig::get('default_layout');
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
    	return mfRequest::getInstance();
    }
    
    public function setTitle($title)
    {
    	$this->_layout_vars_['title'] = $title;
    }
    
    public function setFlash($type, $message)
    {
    	mfFlash::getInstance()->set($type, $message);
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
    	$this->_view_vars_[$name] = $value;
    }
    protected function __get($name)
    {
    	return isset($this->_view_vars_[$name]) ? $this->_view_vars_[$name] : NULL;
    }
    
    /**
     * Get Magic View Vars
     *
     * @return array
     */
    public function getMagicViewVars()
    {
    	$magic_vars = array(
    		'mf_flash' => mfFlash::getInstance(),
    		'mf_request' => mfRequest::getInstance()
    	);
    	return $magic_vars;
    }
    
    // Render view
    protected function render()
    {
    	// Magic view variables
    	$magic_vars = self::getMagicViewVars();
    	// merge
    	
    	$this->_view_vars_   = array_merge($magic_vars, $this->_view_vars_);
    	$this->_layout_vars_ = array_merge($magic_vars, $this->_layout_vars_);
    	
        // TODO get the view path
        $controller_name = $this->getRequest()->getController();
        $action_name = $this->getRequest()->getAction();
        $view_path = APP_DIR . DS . 'views' . DS . $controller_name . DS;
        $tpl_path = $view_path . $action_name . ".php";
        
        
        $view = new mfView($tpl_path, $this->_view_vars_);
        
        // render layout
        if($this->layout)
        {
        	// content here
        	$this->_layout_vars_['mf_layout_content'] = $view->getOutput();
        	$layout_path = APP_DIR . DS . 'views' . DS . 'layout' . DS;
        	$layout = new mfView($layout_path . $this->layout . '.php', $this->_layout_vars_);
        	
        	mfResponse::getInstance()->setBody($layout->getOutput());
        }
        else
        {
	        // no layout
	       	mfResponse::getInstance()->setBody($view->getOutput());
        }
    }

 }
