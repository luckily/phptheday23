<?php

class SiteControllerTest extends WebTestCase
{
	public function test_index()
	{
		$this->driver->get('http://localhost/~joel.zhong/projects/phptheday23/app/index-test.php');
		$this->assertContains('Welcome', $this->driver->getPageSource());
	}
}
