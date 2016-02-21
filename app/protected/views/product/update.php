<?php
	$this->breadcrumbs=array(
		'產品'=>array('index'),
		$model->name=>array('view','id'=>$model->id),
		'修改',
	);
?>

<h1>產品ID: <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>