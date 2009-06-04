<?php

function UseHelper()
{
	$args = func_get_args();
	foreach ($args as $arg)
	{
		include 'helpers' . DS . $arg . 'Helper.php';
	}
}
