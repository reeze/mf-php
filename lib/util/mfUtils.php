<?php

function UseHelper()
{
	$args = func_get_args();
	foreach ($args as $arg)
	{
		require_once 'helper' . DS . $arg . 'Helper.php';
	}
}


function findTemplateFileName($file_without_ext)
{
    $format = mfRequest::getInstance()->getParameter('format', 'html');
    
        // choose the right view class by the file extension found
    $associations = mfConfig::get('mf.view.classes', array());
    
    foreach ($associations as $association) {
    	if(file_exists($file = $file_without_ext . ".$format." . $association['extension'])|| // formated file
    	   file_exists($file = $file_without_ext . '.' . $association['extension']))
    	{
    		$view_class = $association['class'];
    		break;
    	}
    }
    
    if(!isset($view_class)) throw new mfException("Can't find template: $file_without_ext");
    
    return array($file, $view_class);
}