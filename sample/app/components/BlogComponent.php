<?php
class BlogComponent extends mfComponent
{
	public function executeCatagory()
	{
		$this->catagories = Catagory::getAll();
	}
}