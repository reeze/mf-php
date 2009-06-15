<?php

class BlogController extends mfController 
{
	public function indexAction()
	{
		$this->setTitle('Blog Index');
		//$this->redirect("/home");
	}
	
	public function archiveAction($request)
	{
	    $this->posts = Post::getAll();
	}
	
	public function showAction(mfRequest $request)
	{
		$post = array('title' => "hello World!", 'body' => "What a day!");
		$this->post = $post;
		$this->slug = $request->getParameter('slug');
	}
	
}