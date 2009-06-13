<?php

mfConfig::set("default_500_handler", false); // TODO FIXME
mfConfig::set('default_action', 'index');

// If your web server enabled url_rewrite,turn this on
mfConfig::set('url_rewrite', true); 


/**
 * Middleware classes
 */
$middle_wares = array(
	'CommonMiddleware',  // Common middleware should go first
						 // It output the content of page
	'ToolBarMiddleware'
);

mfConfig::set('middlewares', $middle_wares);
