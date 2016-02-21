<?php

class Controller extends CController
{

	public $layout='//layouts/bootstrap';

	public $menu=array();

	public $breadcrumbs=array();

	public $curretMenuItem = '';

	protected function beforeRender($view)
	{
		$this->curretMenuItem = $this->uniqueId;

		return true;
	}
}