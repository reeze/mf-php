<?php
class Router
{
	private static $_routes = array('named' => array(), 'anonymous' => array());
	
	/**
	 * Add routes rule
	 *
	 * @param array $array
	 * 			array('route_name' => $name, // empty for anonymous route
	 * 				  ¡®rule'	=> $rule,
	 * 				  'params'	=> $params
	 * 				);
	 */
	public static function connect($routes)
	{
		
		define("ROUTE_NAME", 0);		
		define("ROUTE_RULE", 1);
		define("ROUTE_PARAM", 2);
		foreach ($routes as $route)
		{
			$params = isset($route[ROUTE_PARAM]) ? $route[ROUTE_PARAM] : array();
			$map = array($route[ROUTE_RULE], $params);
			if($route[ROUTE_NAME])
			{
				self::$_routes['named'][$route[ROUTE_NAME]] = $map;
			}
			else
			{
				self::$_routes['anonymous'][] = $map;
			}
		}
	}
	
	/**
	 * Route the request
	 * @return array return array($controller, $action, $params);
	 */
	public static function route()
	{
		$request = Request::getInstance();
		
		// we just route, merge to one array
		$routes = array_merge(self::$_routes['named'], self::$_routes['anonymous']);

		// match the routes
		foreach ($routes as $route)
		{
			list($rule, $tokens) = self::compile_route($route[0]);

			if(preg_match($rule, $request->getParameter('request_path_info'), $matches) == 1)
			{
				// fill the request
				foreach ($tokens as $i => $token)
				{
					$request->setParameter($token, $matches[$i + 1]);
				}
				
				// fill with params FIXME XXX 0 and 1 is too bad :(.FIXME
				foreach($route[1] as $key => $value)
				{
					$request->setParameter($key, $value);
				}
				return;
			}
		}
		// no route match
		throw new MfException('No route match:' . $_SERVER['REQUEST_URI']);
	}
	
	
	/**
	 * FIXME It's somehow ungly here
	 *
	 * @var array
	 */
	public static $compile_tokens = array();
	/**
	 * Compile the config route to regex match
	 *
	 * @param string $route
	 * @return array regex
	 */
	private static function compile_route($route)
	{
		self::$compile_tokens = array();
		// internel call back function for regex replacement
		if(!function_exists('_callback'))
		{
			function _callback($match)
			{
				Router::$compile_tokens[] = $match[1];
				//var_dump(Router::$compile_tokens);echo "<br />";
				
				return "([a-zA-Z0-9]+)";
			}
		}
		
		$compile_tokens = array();
		// Strip regex chars: / + ? . and _ -
		$reg_strip_parten = "/([\/\._-])/";
		$reg_strip_repalce = '\\\$1'; // replace with \(regex char)
		
		$route = preg_replace($reg_strip_parten, $reg_strip_repalce, $route);		
		$route = preg_replace_callback("/:([a-zA-Z0-9]+)/", '_callback', $route);
		

		$route = "/^$route$/"; // add regex slash	
		
		return array($route, self::$compile_tokens);
	}
	
}