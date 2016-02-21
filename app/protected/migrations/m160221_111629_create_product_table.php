<?php

class m160221_111629_create_product_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('products', array(
			'id'		=>	'pk',
			'name'		=>	'varchar(255)',
			'type'		=>	'integer',
			'price'		=> 	'integer',
			'status'	=> 	'integer',
		));
	}

	public function down()
	{
		$this->dropTable('products');
	}
}