<?php
class BlogComponent extends mfComponent
{
	public function executeCatagory()
	{
		$this->catagories = Doctrine_Query::create()
                        ->from('Catagory c')->orderBy('c.created_at DESC')->fetchArray();
	}
}