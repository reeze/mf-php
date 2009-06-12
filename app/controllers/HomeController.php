<?php
class HomeController extends Controller {
	protected function preExecute(Request $request)
	{
		if($request->getParameter('title')) $this->setTitle($request->getParameter('title'));
	}
	
	
	public function indexAction(Request $request)
	{
		$this->title = "What a test£¡";
		
		if($request->getMethod() == Request::GET)
		{
			$this->method = 'sure GET';
		}
	}
	
	public function testAction(Request $request)
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
