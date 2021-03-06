<?php

/**
 * Base Controller
 */

 class mfController
 {
    protected $_layout_ = false;
    protected $_layout_dir_;
    protected $_template_;
    protected $_template_dir_;
    protected $_view_vars_ = array();
    protected $_layout_vars_ = array();
    
    protected $_respond_formats_ = array();

    public function execute($action, mfRequest $request)
    {
        // it's a private method of the class or action is not a method of the class
        if (substr($action, 0, 1) == '_' || ! method_exists($this, $action)) {
            throw new Exception("Action '{$action}' doesn't exist in " . get_class($this));
        }
        $this->_layout_ = mfConfig::get('default_layout');
        if($this->getRequest()->isAjax()) $this->_layout_ = false;
        
        
        
        //==============Template default set==============================
        $controller_name = $this->getRequest()->getController();
        $action_name = $this->getRequest()->getAction();// Add Format support
        $format = $this->getRequestParameter('format', 'html');
        
        // Template & Layout dir
        $template_dir = APP_DIR . DS . 'views' . DS . $controller_name;
        $template = $action_name;
        $layout_dir = APP_DIR . DS . 'views' . DS . 'layout';
        
        $view_class = mfResponse::getInstance()->getViewClass();
        // formated template
        if(file_exists($template_fmt = $template_dir . DS . $template . ".{$format}." .  call_user_func(array($view_class, 'getExtension'))))
        {
        	$template .= ".{$format}";
        }
    
        $this->setTemplateDir($template_dir);
        $this->setTemplate($template);
        $this->setLayoutDir($layout_dir);        
        
        // the name as helpers will load automaticly
        $helper_file = APP_DIR . DS . 'helpers' . DS . $this->getRequest()->getController() . 'Helper.php';
        if(file_exists($helper_file))
        {
        	require_once $helper_file;
        }
        
        $this->setTemplateDir($template_dir);
        $this->setTemplate($template);
        //==============End template default set===========================
        
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
    
    public function setLayoutDir($dir)
    {
    	$this->_layout_dir_  = $dir;
    }
    public function getLayoutDir()
    {
    	return $this->_layout_dir_;
    }
    
    public function setTemplateDir($dir)
    {
    	$this->_template_dir_ = $dir;
    }
    public function getTemplateDir()
    {
    	return $this->_template_dir_;
    }
    
    /**
     * get request object	
     *
     * @return mfRequest
     */
    public function getRequest()
    {
    	return mfRequest::getInstance();
    }
    
    public function getUser()
    {
    	return mfUser::getInstance();
    }
    
    public function getRequestParameter($key, $default=null)
    {
    	return mfRequest::getInstance()->getParameter($key, $default);
    }
    
    public function setTitle($title)
    {
    	$this->_layout_vars_['title'] = $title;
    }
    
    public function setFlash($type, $message)
    {
    	mfFlash::getInstance()->set($type, $message);
    }
    
    
    /**
     *  respond for certern format
     */
    public function respond($formats)
    {
    	foreach ($formats as $format => $params)
    	{
    		if($this->getRequestParameter('format') == $format)
    		{
    			// layout
    			if(isset($params['layout']) && $params['layout'] == false)
    			{
    				$this->setLayout(false);
    			}
    			
    			// check mime-types
    			// Load mime types
    			$mimes = sfYaml::load(ROOT_DIR . DS . 'config' . DS . 'mime.yml');
    			if(isset($mimes[$format]))
    			{
    				$header = 'Content-Type: ' . $mimes[$format] . '; charset=' . mfConfig::get('encode');
    				mfResponse::getInstance()->header($header);
    			}
    			break;
    		}
    	}
    }
    
    
    // redirect
    protected function redirect($url)
    {
    	$url = url_for($url);
        header("Location: $url"); // TODO Is it right?
        exit;
    }

    // set new layout
    protected function setLayout($layout)
    {
        $this->_layout_ = $layout;    
    }
    protected function getLayout()
    {
    	return $this->_layout_;
    }
    // Use assigned new template to render view
    protected function setTemplate($tpl)
    {
        $this->_template_ = $tpl; 
    }
    public function getTemplate()
    {
    	return $this->_template_;
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
    	   'mf_request' => mfRequest::getInstance(),
    	   'mf_user' => mfUser::getInstance()
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
        
		
    	list($template, $view_class) = findTemplateFileName($this->getTemplateDir() . DS . $this->getTemplate());
    	    	
        $view = new $view_class($template, $this->_view_vars_);
        
        // render layout
        if($this->_layout_)
        {
        	// content here
        	$this->_layout_vars_['mf_layout_content'] = $view->getOutput();
        	
        	list($layout_file, $layout_class) = findTemplateFileName($this->getLayoutDir() . DS . $this->getLayout());
        	
        	$layout = new $layout_class($layout_file, $this->_layout_vars_);
        	
        	mfResponse::getInstance()->setBody($layout->getOutput());
        }
        else
        {
	        // no layout
	       	mfResponse::getInstance()->setBody($view->getOutput());
        }
    }
 }
