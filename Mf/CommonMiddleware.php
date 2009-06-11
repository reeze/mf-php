<?php
/**
 * Comnon Middleware class
 *
 */
class CommonMiddleware ///FIXME I can't extends from MiddleWare
{
	public function process_response()
	{
		Logger::log(MIDDLEWARE_LOG, "process response in CommonMiddleWare");
		Response::getInstance()->display();
	}	
}