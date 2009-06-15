<?php

/**
 * Asset helpers
 */

/**
 * Output the added javascripts
 *
 * @return unknown
 */
function include_javascripts()
{
	// we may have new javascripts
	if(($new = func_get_args()))
	{
		mfResponse::getInstance()->addJavascript($new);
	}
	
	$files = mfResponse::getInstance()->getJavascripts();
	$output = '';
	foreach ($files as $file)
	{
		$output .= "<script src='/js/$file.js' type='text/javascript'></script>\n"; // TODO rewrite it ,hard code here		
	}

	return $output;
}