<?php

/**
 * Created by PhpStorm.
 * User: Apple
 * Date: 16/2/22
 * Time: 上午3:34
 */
class ProductTest extends CDbTestCase
{
    public $fixtures=array(
        'products'=>'Product',
    );

    public function test_save()
    {
        // 3A
        // Arrange 建立相關測試物件。
        $product = new Product();
        $data = $this->products['sample3'];

        $expected = array(
            'name' => 'Sony Xperia Z1 C6902 3G',
            'category' => Product::CATEGORY_PHONE,
            'status' => Product::ONLINE,
        );

        // Act 實際執行待測物件的method，獲得實際值。
        $product->setAttributes($data);
        $isSave = $product->save();

        // Assert 使用PHPUnit提供的assertion，測試期望值與實際值是否相等。
        $this->assertTrue($isSave);
        $this->assertEquals($expected['status'], $product->status);
        $this->assertEquals($expected['category'], $product->category);
        $this->assertEquals($expected['name'], $product->name);
    }

    public function test_get_status_text()
    {
        // 3A
        // Arrange 建立相關測試物件。

        // Act 實際執行待測物件的method，獲得實際值。
        foreach($this->products as $currentProductData) {
            $product = new Product();
            $product->setAttributes($currentProductData);
            $product->save();
        }

        $targetProduct = Product::model()->find(array(
            'condition' => 'status = :status',
            'params' => array(
                ':status' => Product::ONLINE
            ),
        ));

        $expected = '上架中';

        // Assert 使用PHPUnit提供的assertion，測試期望值與實際值是否相等。
        $this->assertNotEmpty($targetProduct);
        $this->assertEquals($expected, $targetProduct->getStatusText());
    }

    public function test_get_category_text()
    {
        // 3A
        // Arrange 建立相關測試物件。


        // Act 實際執行待測物件的method，獲得實際值。
        foreach($this->products as $currentProductData) {
            $product = new Product();
            $product->setAttributes($currentProductData);
            $product->save();
        }

        $targetProduct = Product::model()->find(array(
            'condition' => 'category = :category',
            'params' => array(
                ':category' => Product::CATEGORY_PAD
            ),
        ));

        $expected = '平板';

        // Assert 使用PHPUnit提供的assertion，測試期望值與實際值是否相等。
        $this->assertEquals($expected, $targetProduct->getCategoryText());
    }

    public function test_get_half_price()
    {
        // 3A
        // Arrange 建立相關測試物件。
        $product = new Product();
        $data = $this->products['sample2'];

        $expected = 15503;

        // Act 實際執行待測物件的method，獲得實際值。
        $product->setAttributes($data);
        $isSave = $product->save();

        // Assert 使用PHPUnit提供的assertion，測試期望值與實際值是否相等。
        $this->assertTrue($isSave);
        $this->assertEquals($expected, $product->getHalfPrice());
    }
}