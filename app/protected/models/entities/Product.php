<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property integer $price
 * @property integer $status
 */
class Product extends CActiveRecord
{
	const OFFLINE = 0;
	const ONLINE = 1;

	const TYPE_PHONE = 1;
	const TYPE_PAD = 2;
	const TYPE_NOTEBOOK = 3;

	public function tableName()
	{
		return 'products';
	}

	public function rules()
	{
		return array(
			array('name, type, status, price', 'required', 'message' => '{attribute} 必填'),
			array('type, price, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, type, price, status', 'safe', 'on'=>'search'),
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
			'type' => '類型',
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
		$criteria->compare('type',$this->type);
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

	public function getTypeOptions()
	{
		return array(
			(string)self::TYPE_PHONE 	=> '手機',
			(string)self::TYPE_PAD  	=> '平板',
			(string)self::TYPE_NOTEBOOK => '筆電',
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

	public function getTypeText()
	{
		if($this->status == self::TYPE_PHONE)
			return '手機';

		if($this->status == self::TYPE_PAD)
			return '平板';

		if($this->status == self::TYPE_NOTEBOOK)
			return '筆電';

		throw new Exception('undefined this product type.');
	}
}
