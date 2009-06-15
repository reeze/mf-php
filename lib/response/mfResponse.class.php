<?php
class mfResponse
{
	private static $instance;
	private $headers = array();
	private $stylesheets = array();
	private $javascripts = array();
	private $body;
	
	private function __constructor()
	{
		
	}
	
	/**
	 * add stylesheets
	 * 
	 * addStylesheet('a', 'b'); or
	 * addStylesheet(array('a', 'b'));
	 * The same as addJavascript()
	 *
	 */
	public function addStylesheet()
	{
		$files = func_get_args();
		if(is_array($files[0])) $files = $files[0];
		
		$this->stylesheets = array_unique(array_merge($files, $this->stylesheets));
	}
	
	public function getStylesheets()
	{
		return $this->stylesheets;
	}
	
	public function addJavascript()
	{
		$files = func_get_args();
		if(is_array($files[0])) $files = $files[0];
		
		$this->javascripts = array_unique(array_merge($files, $this->javascripts));
	}
	
	public function getJavascripts()
	{
		return $this->javascripts;
	}
	
	public function setHeader($header)
	{
		$this->headers[] = $header;
	}
	
	public function setBody($body)
	{
		$this->body = $body;
	}
	public function getBody()
	{
		return $this->body;
	}
	public function display()
	{
		echo $this->body;
	}
	
	/**
	 * get instance
	 *
	 * @return mfResponse
	 */
	public static function getInstance()
	{
        if(!self::$instance)
        {
            self::$instance = new self(); 
        }
        return self::$instance;
	}
}