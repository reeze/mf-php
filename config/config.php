<?php

Config::set("default_500_handler", false); // TODO FIXME
Config::set('default_action', 'index');

// If your web server enabled url_rewrite,turn this on
Config::set('url_rewrite', true); 


/**
 * Middleware classes
 */
$middle_wares = array(
	'CommonMiddleware', // Common middleware should go first
	'ToolBarMiddleware'
);

Config::set('middlewares', $middle_wares);