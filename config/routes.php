<?php

$routes = array(
	array('root', '/', array('controller' => 'home', 'action' => 'index')),
	array('blog', '/blog', array('controller' => 'blog', 'action' => 'index')),
	array('archive', '/archive/:year/:month/:day', array('controller' => 'blog', 'action' => 'archive')),
	array('view_post', '/:year/:month/:day/:slug', array('controller' => 'blog', 'action' => 'show')),
	
	array('', '/:name/google', array('controller' => 'home', 'action' => 'list')),
	array('test', '/test/:name', array('controller' => "home", 'action' => 'test')),
	
	// default route, all other route should apear before these
	array('', '/:controller/:action'),
	array('', '/:controller', array('action' => 'index'))
);

Router::connect($routes);
