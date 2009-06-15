<?php

class ToolBarMiddleware
{
	public function process_request()
	{
		// add jquery files
		mfResponse::getInstance()->addJavascript('jquery', 'mf_toolbar');
		mfResponse::getInstance()->addStylesheet('mf_toolbar');	
	}
	
	public function process_response()
	{
		if(!mfConfig::get('enable_toolbar', false)) return ;
		
		$params = array(
			'logs' => mfLogger::getLogs()
		);
		
		$params = array_merge($params, mfController::getMagicViewVars());
		
		
		$toolbar = new mfView(MF_CORE_DIR . DS . 'default' . DS . 'toolbar.php', $params);
		
		$response = mfResponse::getInstance();
		
		$new_body = str_replace('</body>', 
								$toolbar->getOutput() . '</body>', 
								$response->getBody());
		$response->setBody($new_body);
		
	}
}