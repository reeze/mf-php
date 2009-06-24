<?php
class DocumentController extends mfController 
{
	public function showAction(mfRequest $request)
	{
		mfResponse::getInstance()->setViewClass('mfMarkdownView');
		$this->setTemplateDir(MF_CORE_DIR . DS . '..' . DS . 'doc' . DS . 'book');
		
		$page = $request->getParameter('page');
//		if(!file_exists($this->getTemplateDir() . DS . $page)) throw new mfException404("Page: $page not found");
		
		$this->setTemplate($page);			
	}
}