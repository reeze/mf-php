<?php

function UseHelper()
{
	$args = func_get_args();
	foreach ($args as $arg)
	{
		require_once 'helper' . DS . $arg . 'Helper.php';
	}
}
