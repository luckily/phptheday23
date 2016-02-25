<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class GitHubTest extends WebTestCase
{

    /**
     * @var Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected $url = 'https://github.com/';

    public function test_search()
    {
        $this->driver->get($this->url);
        $form = $this->driver->findElement(WebDriverBy::cssSelector('form.js-site-search-form'));
        $input = $form->findElement(WebDriverBy::cssSelector('input[type=text].js-site-search-focus'));
        $input->sendKeys('yii 1.1');
        $form->submit();

        $link = $this->driver->findElement(WebDriverBy::cssSelector('ul.repo-list li.repo-list-item h3.repo-list-name a'));
        $link->click();

        $repositoryMeta = $this->driver->findElement(WebDriverBy::cssSelector('span.repository-meta-content'))->getText();

        sleep(1);

        $this->assertContains('Yii PHP Framework 1.1', $repositoryMeta);
    }
}

