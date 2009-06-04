<?php

$query_str = '?' . $_SERVER['QUERY_STRING'];
// trim the query string
$path_info = substr($_SERVER['REQUEST_URI'], 0,  - strlen($query_str));

echo $path_info;exit;

var_dump($_SERVER['PATH_INFO']);exit;


function compile_route($route)
{
		
	// internel call back function for regex replacement
	function _callback($match)
	{
		global $tokens;
		$tokens[] = $match[1];
		
		return "([a-zA-Z0-9]+)";
	}
	
		
	$tokens = array();
	// Strip regex chars: / + ? . and _ -
	$reg_strip_parten = "/([\/\._-])/";
	$reg_strip_repalce = '\\\$1'; // replace with \(regex char)
	
	$route = preg_replace($reg_strip_parten, $reg_strip_repalce, $route);

	$route = preg_replace_callback("/:([a-zA-Z0-9]+)/", '_callback', $route);
	

	$route = "/^$route$/"; // add regex slash	
	
	return array($route, $tokens);
}

$rule = "/:controller/:action/show-user";

list($p, $tokens) = compile_route($rule);

echo "<br />";

echo preg_match($p, "/user/index/show-user", $m);

echo "<br />";var_dump($m);