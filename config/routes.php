<?php

$routes = array(
	array('root', '/', array('controller' => 'home', 'action' => 'index')),
	array('blog', '/blog', array('controller' => 'blog', 'action' => 'index')),
	
	// default route
	array('', '/:controller/:action'),
	array('', '/:controller', array('action' => 'index'))
);

Router::connect($routes);