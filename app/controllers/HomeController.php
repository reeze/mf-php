<?php
class HomeController extends Controller {
	protected function preExecute(Request $request)
	{
		if($request->getParameter('title')) $this->setTitle($request->getParameter('title'));
	}
	
	
	public function indexAction(Request $request)
	{
		$this->assign('title', "Homepage");
		
		if($request->getMethod() == Request::GET)
		{
			$this->assign('method', 'sure GET');
		}
	}
	public function listAction()
	{
		$this->assign('news', array('news1', 'news2'));
	}
}
