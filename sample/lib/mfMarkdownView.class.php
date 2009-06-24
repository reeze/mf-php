<?php

class mfMarkdownView extends mfView 
{
	protected static $extension = 'txt';
	
	public function render($view_file, $params=NULL)
	{
		require_once 'markdown.php';
		
		$this->output =  Markdown(file_get_contents($view_file));
	}
	
  	public static function register()
    {
    	return array('extension' => self::getExtension(), 'class' => __CLASS__);
    }
    
    /**
     * Get the extension of this view connected with
     *
     */
    public static function getExtension()
    {
    	return self::$extension;
    }
}