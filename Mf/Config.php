<?php

class Config
{
	private static $_data = array();
	
	public static function get($key)
	{
		return self::$_data[$key];
	}
	public static function set($key, $value)
	{
		if($key) self::$_data[$key] = $value;
	}
}
