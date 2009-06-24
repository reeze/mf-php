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
	$partial = '_' . $array[$count -1]; // all partials start with '_'
	$formated_partial = '_' . $array[$count -1 ] . ".$format";
	
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
//	if(file_exists($view_path . DS . $formated_partial))
//	{
//		$view_tpl = $view_path . DS . $formated_partial;
//	}
//	else
//	{
//		$view_tpl = $view_path . DS . $partial;
//	}
	
	list($view_tpl, $view_class) = findTemplateFileName($view_path . DS . $partial);
	
	$view = new $view_class($view_tpl, $params);
	
	// before output ob_start have stop direct output to browse, so we echo but no return string
	echo $view->display(); 
}



/**
 * Slot function
 * if  $value is set then no end_slot() needed
 *
 */

function slot($name, $value=NULL)
{
	// direct slot
	if($value)
	{
		mfResponse::getInstance()->setSlot($name, $value);
	}
	else
	{
		ob_start(); // start output buffer
		mfConfig::set('mf.response.view.slots', $name);
	}
}

function end_slot()
{
	$slot_name = mfConfig::get('mf.response.view.slots');
	if(!$slot_name) throw new mfException("end_slot() should follow with a slot() function");
	
	$response = mfResponse::getInstance();
	$content = ob_get_clean();
	$response->setSlot($slot_name, $content);
	// empty it
	mfConfig::set('mf.response.view.slots', NULL);
}


function include_slot($name, $default=NULL)
{
	$response = mfResponse::getInstance();
	
	$slot = $response->getSlot($name, $default);
	if($slot)
	{
		echo $slot;
		return true;
	}
	else
	{
		return false;
	}
}

function has_slot($name)
{
	return mfResponse::getInstance()->getSlot($name);
}
