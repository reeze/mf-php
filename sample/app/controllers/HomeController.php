<?php
class HomeController extends mfController {
	protected function preExecute(mfRequest $request)
	{
		if($request->getParameter('title')) $this->setTitle($request->getParameter('title'));
	}
	
	
	public function indexAction(mfRequest $request)
	{
		$this->title = "What a test£¡";
		
		if($request->getMethod() == mfRequest::GET)
		{
			$this->method = 'sure GET';
		}
	}
	
	public function testAction(mfRequest $request)
	{
		$this->setFlash('notice', 'Its a notice Flash message');
		$this->redirect('/blog');
//		$this->name = $request->getParameter('test');
	}
	
	public function listAction()
	{
		$this->news = array('news1', 'news2');
	}
}
