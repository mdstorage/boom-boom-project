<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" />
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-2.1.1.min.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap.min.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.imagemapster.min.js'); ?>

	<title><?php echo 'Каталог TOYOTA'; ?></title>
	<!--<title><?php echo CHtml::encode($this->pageTitle); ?></title>-->
</head>

<body>


<div class="container-fluid" id="page">

<ol class="breadcrumb">
  <li><?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?></li>
</ol>

	<!-- breadcrumbs -->
	<?php endif?>
<div class="row">
    <div class="col-xs-2"></div>
    <div class="col-xs-10">
        <h1><?php echo $this->pageTitle; ?></h1>
    </div>
    <div class="col-xs-2">
        <ul class="nav nav-pills nav-stacked">
            <li class="<?php echo Yii::app()->controller->id == 'site' ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl("site") ?>">Каталог</a></li>
            <li class="<?php echo Yii::app()->controller->id == 'findArticul' ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl("findArticul") ?>">Поиск по артикулу</a></li>
        </ul>

    </div>
    <div class="col-xs-10">
        <?php echo $content; ?>
    </div>
</div>


	<div class="clear"></div>

</div><!-- page -->

</body>
</html>
