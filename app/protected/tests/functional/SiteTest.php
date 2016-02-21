<?php

class SiteTest extends WebTestCase
{
	public function testIndex()
	{
		// http://localhost/~joel.zhong/projects/phptheday23/app/index-test.php
		$this->open('http://localhost/~joel.zhong/projects/phptheday23/app/index-test.php/site/contact');
		$this->assertTextPresent('Welcome');
	}
}
