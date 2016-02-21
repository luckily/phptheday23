<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="<?= Yii::app()->getBaseUrl().'/images/booststrap-o.icon' ?>">
		<title>產品管理</title>
		<?php
		/**
		 * bootstrap footer
		 * @link https://getbootstrap.com/examples/sticky-footer/
		 * @link http://stackoverflow.com/questions/17966140/twitter-bootstrap-3-sticky-footer
		 */
		?>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-sticky-footer.css" />
		<style>
			.grid-view .button-column {
				width: 8%;
			}
		</style>
	</head>
	<body>

		<!-- 巡覽列 -->
		<?php $this->widget('MenuWidget', array('bright' => $this->curretMenuItem)); ?>

		<div class="container-fluid">

			<?php
				$this->widget('booster.widgets.TbBreadcrumbs', array(
					'homeLink' => CHtml::link('首頁', $this->createUrl('/')),
					'links' => $this->breadcrumbs,
				));
			?>

			<!-- <p class="text-center">置中對齊文字。 -->
			<?php if(Yii::app()->user->hasFlash('success')): ?>
				<div class="alert in fade alert-success text-center">
					<a href="#" class="close" data-dismiss="alert">×</a>
					<strong><?= Yii::app()->user->getFlash('success'); ?></strong>
				</div>
			<?php endif;?>

			<?= $content; ?>
		</div>


		<div class="footer">
			<div class="container">
				<p class="text-muted credit"></p>
			</div>
		</div>
	</body>
</html>