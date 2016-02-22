<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model, '請修正下列問題'); ?>

	<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<?php echo $form->dropDownListGroup(
		$model, 'category',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-5',
			),
			'widgetOptions' => array(
				'data' => $model->getCategoryOptions(),
				'htmlOptions' => array('prompt' => '未選擇'),
			)
		)
	); ?>

	<?php echo $form->textFieldGroup($model,'price',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php echo $form->dropDownListGroup(
		$model, 'status',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-5',
			),
			'widgetOptions' => array(
				'data' => $model->getStatusOptions(),
				'htmlOptions' => array('prompt' => '未選擇'),
			)
		)
	); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
				'buttonType'=>'submit',
				'context'=>'primary',
				'label'=>$model->isNewRecord ? '建立' : '修改',
			)); ?>
	</div>

<?php $this->endWidget(); ?>
