<?php
class mfUser
{
    private static $_instance;
    private $authenticated = false;
    private $credentials = array();
    
    private function __construct()
    {
    	if(isset($_SESSION['mf.user']['authenticated']))
    	{
    		$this->authenticated = true;
    	}
    }
    
    
    /**
     * Check if user has authenticated
     *
     */
    public function authenticated()
    {
    	return $this->authenticated;
    }
    
    public function setAuthenticated()
    {
    	$this->authenticated = true;
    }
    
    public function hasCredential($credit)
    {
    	return array_search($credit, $this->credentials) !== FALSE; 
    }
    
    
	
    /**
     * get request instance
     *
     * @return mfUser
     */
    public static function getInstance()
    {
        if(!self::$_instance)
        {
            self::$_instance = new self(); 
        }
        return self::$_instance;
    }
}
