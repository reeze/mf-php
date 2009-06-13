<?php
class Debug
{
	public static function p()
	{
		$args = func_get_args();
		echo "<pre>";
		foreach ($args as $arg)
		{
			var_dump($arg);
		}
		echo "</pre>";
	}
}