<?php
/**
 * MF standard helper UrlHelper
 * 
 * TODO imply it 
 */

function link_to()
{
	
}

// get the url link
function url_for($url, $absolute=false)
{
	return Router::generate($url, $absolute);
}
