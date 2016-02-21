<?php
	$this->breadcrumbs=array(
		'產品'=>array('index'),
		'建立',
	);
?>
<h1>建立產品</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>