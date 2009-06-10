<?php

$routes = array(
	array('root', '/', array('controller' => 'home', 'action' => 'index')),
	array('blog', '/blog', array('controller' => 'blog', 'action' => 'index')),
	
	array('', '/test/:name', array('controller' => "home", 'action' => 'test')),
	
	// default route, all other route should apear before these
	array('', '/:controller/:action'),
	array('', '/:controller', array('action' => 'index'))
);

Router::connect($routes);