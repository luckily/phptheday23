<?php

/**
* see 
* http://koda.iteye.com/blog/1134606
* http://liyongjiang.blog.51cto.com/5800344/1148041
*/

class MenuWidget extends CWidget
{
	public $bright = 'patient';
	private $_links = array();

	public function init()
	{
		// 此方法会被 CController::beginWidget() 调用

		$this->_links = array(
			'product' 	=> '產品',
		);
	}

	public function run()
	{
		// 此方法会被 CController::endWidget() 调用 
		
		$data['links'] = $this->_links;
		$data['bright'] = $this->bright;
		$this->render('menu', $data);
	}
}