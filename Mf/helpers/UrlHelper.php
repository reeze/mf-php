<?php
/**
 * MF standard helper UrlHelper
 * 
 * TODO imply it 
 */

function link_to($text, $url, $options = array())
{
	return "<a href='" . url_for($url) . "'>" . $text . "</a>"; 
}

// get the url link
function url_for($url, $absolute=false)
{
	return Router::generate($url, $absolute);
}
