<?php

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use Facebook\WebDriver\WebDriverExpectedCondition;

/**
 * Class ProductControllerTest
 * @link http://codeception.com/11-12-2013/working-with-phpunit-and-selenium-webdriver.html#.VstVVnR94fE
 */
class ProductControllerTest extends WebTestCase
{
    public $fixtures=array(
        'products'=>'Product',
    );

    public function test_index()
    {
        $this->driver->get('http://localhost/~joel.zhong/projects/phptheday23/app/index-test.php?r=product/index');

        $h1Text = $this->driver->findElement(WebDriverBy::cssSelector('h1'))->getText();
        $items  = $this->driver->findElements(WebDriverBy::cssSelector('#product-grid table tbody tr'));

        $this->assertEquals('產品列表', $h1Text);
        $this->assertCount(3, $items);
    }

    /**
     * 測試首頁搜尋
     */
    public function test_search()
    {
        $this->driver->get('http://localhost/~joel.zhong/projects/phptheday23/app/index-test.php?r=product/index');

        $searchTextBox = $this->driver->findElement(WebDriverBy::id('Product_name'));
        $searchTextBox->click();

        $this->driver->getKeyboard()->sendKeys('Sony')->pressKey(WebDriverKeys::ENTER);

        /**
         * 等ajax一下
         */
        $this->waitForAjax($this->driver);

        $items  = $this->driver->findElements(WebDriverBy::cssSelector('#product-grid table tbody tr'));
        $html = $items[0]->getText().'|'.$items[1]->getText();

        // 搜尋Sony的東西之後不能出現ASUS的東西
        $this->assertCount(2, $items);
        $this->assertNotContains('ASUS', $html);

    }

    /**
     * 測試建立產品
     */
    public function test_create()
    {
        $this->driver->get('http://localhost/~joel.zhong/projects/phptheday23/app/index-test.php?r=product/create');

        $submitButton = $this->driver->findElement(WebDriverBy::cssSelector('#yw0'));
        $submitButton->click();

        $errorSummary = $this->driver->findElement(WebDriverBy::cssSelector('#product-form div.alert-danger'))->getText();
        $this->assertContains('產品名稱 必填', $errorSummary);
        $this->assertContains('類型 必填', $errorSummary);
        $this->assertContains('狀態 必填', $errorSummary);
        $this->assertContains('價格 必填', $errorSummary);


        $nameTextBox = $this->driver->findElement(WebDriverBy::id('Product_name'));
        $nameTextBox->sendKeys('Apple iPhone 6S Plus 64GB');

        $priceTextBox = $this->driver->findElement(WebDriverBy::id('Product_price'));
        $priceTextBox->sendKeys('29899');

        /**
         * @link http://stackoverflow.com/questions/4672658/how-do-i-set-an-option-as-selected-using-selenium-webdriver-selenium-2-0-clien
         * @link http://stackoverflow.com/questions/5278281/how-to-using-webdriver-selenium-for-selecting-an-option-in-c
         */
        $this->driver->findElement(WebDriverBy::xpath("//select[@id='Product_category']/option[text()='手機']"))->click();
        $this->driver->findElement(WebDriverBy::xpath("//select[@id='Product_status']/option[text()='上架中']"))->click();

        /**
         * 只要有document的切換，都要重新抓取元素
         */
        $submitButton = $this->driver->findElement(WebDriverBy::cssSelector('#yw0'));
        $submitButton->click();

        $successSummary = $this->driver->findElement(WebDriverBy::cssSelector('div.alert-success'))->getText();
        $this->assertContains('建立成功.', $successSummary);

        /**
         * 只要有document的切換，都要重新抓取元素
         */
        $nameTextBox = $this->driver->findElement(WebDriverBy::id('Product_name'));
        $priceTextBox = $this->driver->findElement(WebDriverBy::id('Product_price'));

        $this->assertEquals('Apple iPhone 6S Plus 64GB', $nameTextBox->getAttribute('value'));
        $this->assertEquals('29899', $priceTextBox->getAttribute('value'));
        $this->assertTrue($this->driver->findElement(WebDriverBy::xpath("//select[@id='Product_category']/option[text()='手機']"))->isSelected());
        $this->assertTrue($this->driver->findElement(WebDriverBy::xpath("//select[@id='Product_status']/option[text()='上架中']"))->isSelected());
    }

    /**
     * 選取ASUS的產品並刪除之
     */
    public function test_delete()
    {
        $this->driver->get('http://localhost/~joel.zhong/projects/phptheday23/app/index-test.php?r=product/index');

        $deleteTarget = $this->driver->findElement(WebDriverBy::xpath("//table/tbody/tr[2]/td[@class='button-column']/a[@class='delete']"));
        $deleteTarget->click();

        $this->driver->wait()->until(WebDriverExpectedCondition::alertIsPresent(), '等待確認的alert...');
        $this->driver->switchTo()->alert()->accept();

        /**
         * 等ajax一下
         */
        $this->waitForAjax($this->driver);

        $items  = $this->driver->findElements(WebDriverBy::cssSelector('#product-grid table tbody tr'));
        $html = $items[0]->getText().'|'.$items[1]->getText();

        // 刪除ASUS的東西之後，不能又出現ASUS的東西
        $this->assertCount(2, $items);
        $this->assertNotContains('ASUS', $html);
    }
}