<?php

class ToolBarMiddleware
{
	public function process_response()
	{
		if(!Config::get('enable_toolbar', false)) return ;
		
		$params = array(
			'logs' => Logger::getLogs()
		);
		
		$params = array_merge($params, Controller::getMagicViewVars());
		
		$toolbar = new View(MF_CORE_DIR . DS . 'default' . DS . 'toolbar.php', $params);
		
		$response = Response::getInstance();
		
		$new_body = str_replace('</body>', 
								$toolbar->getOutput() . '</body>', 
								$response->getBody());
		$response->setBody($new_body);
	}
}