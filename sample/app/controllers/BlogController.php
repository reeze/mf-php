<?php

class BlogController extends mfController 
{
	public function indexAction()
	{
		$this->setTitle('Blog Index');
		
		$this->posts = Doctrine_Query::create()
    					->from('Post p')->orderBy('p.created_at DESC')->fetchArray();

    	// respond formats
		$this->respond(
			array(
				'rss' => array('layout' => false)
			));
	}

	
	public function newAction(mfRequest $request)
	{
		if($request->getMethod() == mfRequest::POST)
		{
			$post = new Post();
			$post->title = $request->getParameter('title');
			$post->content = $request->getParameter('content');
			if($post->isValid())
			{
				$post->save();
				$this->setFlash('notice', '成功发布博文:)');
				$this->redirect('/blog/index');
			}
		}
	}
	
	public function archiveAction()
	{
		$this->posts = Doctrine_Query::create()
    					->from('Post p')->fetchArray();
	}
	
	public function showAction(mfRequest $request)
	{
		$this->post = Post::findBySlug($request->getParameter('slug'));
	}
}
