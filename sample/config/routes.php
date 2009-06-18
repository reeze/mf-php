<?php

$routes = array(
	array('root', '/', array('controller' => 'home', 'action' => 'index')),

	array('archive_index', '/archive', array('controller' => "blog", 'action' => "archive")),
	array('archive', '/archive/:year/:month/:day', array('controller' => 'blog', 'action' => 'archive')),
	array('view_post', '/:year/:month/:day/:slug', array('controller' => 'blog', 'action' => 'show', 'slug' => 'itslug')),
	
	array('feed', '/feed.:format', array('controller' => 'blog', 'action' => 'index')),
	
	// default route, all other route should apear before these
	array('', '/:controller/:action'),
	array('', '/:controller', array('action' => 'index'))
);

mfRoute::connect($routes);
