<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property integer $id
 * @property string $name
 * @property integer $category
 * @property integer $price
 * @property integer $status
 */
class Product extends CActiveRecord
{
	const OFFLINE = 0;
	const ONLINE = 1;

	const CATEGORY_PHONE = 1;
	const CATEGORY_PAD = 2;
	const CATEGORY_NOTEBOOK = 3;

	public function tableName()
	{
		return '{{product}}';
	}

	public function rules()
	{
		return array(
			array('name, category, status, price', 'required', 'message' => '{attribute} 必填'),
			array('category, price, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, category, price, status', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '產品名稱',
			'category' => '類型',
			'price' => '價格',
			'status' => '狀態',
		);
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('category',$this->category);
		$criteria->compare('price',$this->price);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getStatusOptions()
	{
		return array(
			(string)self::OFFLINE => '已下架',
			(string)self::ONLINE  => '上架中',
		);
	}

	public function getCategoryOptions()
	{
		return array(
			(string)self::CATEGORY_PHONE 	=> '手機',
			(string)self::CATEGORY_PAD  	=> '平板',
			(string)self::CATEGORY_NOTEBOOK => '筆電',
		);
	}

	public function getStatusText()
	{
		if($this->status == self::OFFLINE)
			return '已下架';

		if($this->status == self::ONLINE)
			return '上架中';

		throw new Exception('undefined this product status.');
	}

	public function getCategoryText()
	{
		if($this->category == self::CATEGORY_PHONE)
			return '手機';

		if($this->category == self::CATEGORY_PAD)
			return '平板';

		if($this->category == self::CATEGORY_NOTEBOOK)
			return '筆電';

		throw new Exception('undefined this product category.');
	}

	/**
	 * 半價，無條件捨去
	 * @return int
	 */
	public function getHalfPrice()
	{
		return floor($this->price * 0.5);
	}
}
