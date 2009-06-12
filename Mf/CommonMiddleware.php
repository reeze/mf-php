<?php
/**
 * Common Middleware class
 *
 */
class CommonMiddleware ///FIXME I can't extends from MiddleWare
{
	public function process_request($request)
	{
		// handle Flash system should initialized before any others
		// so we clean here
		// TODO do we need ajax request check before clean flash?
		Flash::getInstance()->clean();
		return $request;
	}
	/**
	 * This is last middleware to output the content of page
	 *
	 */
	public function process_response($response)
	{
		$response->display();
		return $response;
	}	
}