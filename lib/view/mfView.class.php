<?php

/**
 * View layer. PHPView
 **/
class mfView
{
    private $vars = array();
    private $output;
    
    public function __construct($view_file, $params)
    {
    	if(!file_exists($view_file)) throw new MfException("Missing view: $view_file");
    	$this->vars = $params;
    	$this->render($view_file, $params);
    }
    
    public function getOutput()
    {
    	return $this->output;
    }
    public function render($view_file, $params)
    {
    	ob_start();
        extract($this->vars, EXTR_SKIP);
        include $view_file; // this is the core method of PHPView imply
        $this->output = ob_get_clean(); // get and clean the buffer
    }
    public function display()
    {
    	echo $this->output;
    }
}
