<?php
class Router
{
	private static $_routes = array();
	/**
	 * Wether config routes are checked?
	 *
	 * @var bool
	 */
	private static $_checked = false;
	
	/**
	 * Add routes rule
	 *
	 * @param array $array
	 * 			array('route_name', // empty for anonymous route
	 * 				  ¡®rule', 		// rule
	 * 				  array('a' => 1)	// array $params 
	 * 				);
	 */
	public static function connect($routes)
	{
		self::$_routes = $routes;
	}
	/**
	 * Add route to routes table
	 *
	 * @param array $route
	 */
	public static function prepend($route)
	{
		self::$_routes = array_merge($route, self::$_routes);
	}
	
	/**
	 * Push route to the end of the routes table
	 *
	 * @param array $route
	 */
	public static function push($route)
	{
		self::$_routes = array_merge(self::$_routes, $route);
	}
	
	/**
	 * Route the request
	 * @return array array($controller, $action, $params);
	 */
	public static function route()
	{
		$request = Request::getInstance();
		
		// match the routes
		foreach (self::$_routes as $route)
		{
			list($rule, $tokens) = self::compile_route($route[1]);
			
			
			if(preg_match($rule, $request->getParameter('request_path_info'), $matches) == 1)
			{
				// fill the request
				foreach ($tokens as $i => $token)
				{
					$request->setParameter($token, $matches[$i + 1]);
				}
				
				// fill with params
				if(isset($route[2]) && is_array($route))
				{
					foreach($route[2] as $key => $value)
					{
						$request->setParameter($key, $value);
					}
				}
				
				Logger::log(ROUTE_LOG, "matched route: {$route[1]}");
				return;
			}
			// Log matching
			Logger::log(ROUTE_LOG, "mismatch route: {$route[1]}");
		}
		// no route match
		throw new RouterExecption('No route match:' . $_SERVER['REQUEST_URI']);
	}
	
	
	/**
	 * FIXME It's somehow ungly here
	 * TODO  add route cache
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
		// FIXME more characters should allowed in match parten		
		$route = preg_replace_callback("/:([a-zA-Z0-9]+)/", '_callback', $route);
		

		$route = "/^$route$/"; // add regex slash	
		
		return array($route, self::$compile_tokens);
	}
	
}

class RouterExecption extends MfException
{ }

