<?php
class CatagoryController extends mfController
{
	public function addAction(mfRequest $request)
	{
		if($request->isPost())
		{
            $c = new Catagory();
            $c->name = $request->getParameter('name');
            $c->save();
            
            $this->setFlash('notice', '成功添加分类');
            $this->redirect("blog/index");
		}
	}
}