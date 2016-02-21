<?php
$this->breadcrumbs=array(
	'產品管理'=>array('index'),
	'列表',
);

Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
			$.fn.yiiGridView.update('product-grid', {
				data: $(this).serialize()
			});
			return false;
		});
	");
?>

<h1>Products</h1>

<div class="btn-group-vertical pull-right">
	<a class="btn btn-primary" style="color:#FFFFFF;" href="<?= $this->createUrl('/product/create/'); ?>">
		<?= "建立產品" ?>
	</a>
</div>

<p></p>

<?php
	$this->widget('booster.widgets.TbGridView',array(
		'id'=>'product-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
			'id',
			'name',
			'price',
			array(
				'class'=>'booster.widgets.TbButtonColumn',
			),
		),
	));
?>