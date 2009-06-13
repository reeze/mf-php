<?php

class BlogController extends Controller 
{
	public function indexAction()
	{
		$this->setTitle('Blog Index');
		//$this->redirect("/home");
	}
	
	public function archiveAction($request)
	{
		
	}
	
	public function showAction(Request $request)
	{
		$post = array('title' => "hello World!", 'body' => "What a day!");
		$this->post = $post;
		$this->slug = $request->getParameter('slug');
	}
	
}