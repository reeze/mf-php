<?php
/**
 * Helpers for view
 */


/**
 * Include partial to the view
 * No need to explict echo the result of partial_include
 * It behavors like php include, borrowed from symfony
 *
 * @param string $partial
 * @param array  $params
 */
function include_partial($partial, $params)
{
	$request = mfRequest::getInstance();
	
	$view_path = APP_DIR . DS . 'views' . DS . $request->getController() . DS . "_$partial.php";
	$view = new mfView($view_path, $params);
	
	// before output ob_start have stop direct oupt to browse, so we echo but no return string
	echo $view->display(); 
}