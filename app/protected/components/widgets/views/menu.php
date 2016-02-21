<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button class="navbar-toggle btn btn-default" data-toggle="collapse" data-target="#yii_booster_collapse_yw21" id="yw22" name="yt6" type="button">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="<?= Yii::app()->createUrl('/'); ?>" class="navbar-brand">產品管理</a>
		</div>
		<div class="collapse navbar-collapse" id="yii_booster_collapse_yw21">
			<ul class="nav navbar-nav">
				<!--
					<li class="active"><a href="#">Home</a></li>
					<li><a href="#">Link</a></li>
				-->
				<?php foreach($links as $key => $value): ?>
					<?php $cssClass = ($bright == $key) ? 'dropdown active' : 'dropdown'; ?>
					<?php echo CHtml::openTag('li', array('class' => $cssClass))?>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php echo $value; ?>
							<span class="caret"></span>
						</a>

						<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
							<li role="presentation"><?php echo CHtml::link('列表', Yii::app()->createUrl("{$key}/index")); ?></li>
							<li role="presentation"><?php echo CHtml::link('建立資料', Yii::app()->createUrl("{$key}/create")); ?></li>
						</ul>
					<?php echo CHtml::closeTag('li'); ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</nav>