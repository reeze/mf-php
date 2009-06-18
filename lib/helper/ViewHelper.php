<?php
/**
 * Helpers for view
 */


/**
 * Include partial to the view
 * No need to explict echo the result of partial_include
 * It behavors like php include, borrowed from symfony
 * 
 * include_partial("index/apache");
 *
 * @param string $partial
 * @param array  $params
 */
function include_partial($partial, $params=array())
{
	$request = mfRequest::getInstance();
	
	$format = $request->getParameter('format', 'html');
	
	$array = explode('/', $partial);
	$count = count($array);
	$partial = '_' . $array[$count -1] . '.php'; // all partials start with '_'
	$formated_partial = '_' . $array[$count -1 ] . ".$format" . '.php';
	
	unset($array[$count -1 ]); // pop up partial file name
	
	$path =  implode('/', $array); // reconnect to the path
	
	define('VIEWS_DIR', APP_DIR . DS . 'views');
	
	// specify certain controller to render
	if($path)
	{
		$view_path = VIEWS_DIR . DS . $path;
	}
	else 
	{
		$view_path = VIEWS_DIR . DS . $request->getController();
	}
	
	// Request format support
	if(file_exists($view_path . DS . $formated_partial))
	{
		$view_tpl = $view_path . DS . $formated_partial;
	}
	else
	{
		$view_tpl = $view_path . DS . $partial;
	}
	$view = new mfView($view_tpl, $params);
	
	// before output ob_start have stop direct output to browse, so we echo but no return string
	echo $view->display(); 
}