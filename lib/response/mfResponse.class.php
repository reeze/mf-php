<?php
class mfResponse
{
	private static $instance;
	private $headers = array();
	private $body;
	
	private function __constructor()
	{
		
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
	 * @return Response
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