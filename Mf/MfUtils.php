<?php

function UseHelper()
{
	$args = func_get_args();
	foreach ($args as $arg)
	{
		include 'helpers' . DS . $arg . 'Helper.php';
	}
}



/**
 * Debug util tool for debug and stop
 * 
 * debug($a, $b, $c); // you can use any number of args 
 * to inpect them and stop the
 */
function debug()
{
	if(Config::get('debug_mode') == true)
	{
		$args = func_get_args();
		foreach ($args as $arg)
		{
			var_dump($var);echo "<hr />"; // add hr to  improve readability
		}
		exit;
	}
}