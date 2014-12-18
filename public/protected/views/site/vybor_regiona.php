<?php
/* @var $this SiteController */

?>








<?php

$this->breadcrumbs=array(
	'',);
$this->pageTitle=Yii::app()->name;
?>


<?php if (!empty($aCatalogs)): ?>

<div class="row">
    <div class="col-md-6">
        <h5>Запрос по VIN</h5>
        <div class="row">
            <div class="col-lg-8">
                <?php echo CHtml::textField('VIN', '' , array('id'=>'vin', 'class'=>'form-control', 'placeholder'=>'VIN')); ?>
            </div>
            <div class="col-lg-4">
                <?php echo CHtml::ajaxButton("Искать", array("site/findbyvin"),
                    array(
                        'type'=>'POST',
                        'data'=>array('value'=>'js:$("#vin").val()'),
                        'success'=>'js:function(html){ $("#vin_result").html(html); }'
                    ), array('class'=>'btn btn-default')
                ); ?>
            </div>
        </div>
        <div id='vin_result'></div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h5>Запрос по FRAME</h5>
        <div class="row">
            <div class="col-lg-4">
                <?php echo CHtml::textField('FRAME', '' , array('id'=>'frame', 'class'=>'form-control', 'placeholder'=>'FRAME')); ?>
            </div>
            <div class="col-lg-4">
                <?php echo CHtml::textField('SERIAL', '' , array('id'=>'serial', 'class'=>'form-control')); ?>
            </div>
            <div class="col-lg-4">
                <?php echo CHtml::ajaxButton("Искать", array("site/findbyvin"),
                    array(
                        'type'=>'POST',
                        'data'=>array('frame'=>'js:$("#frame").val()', 'serial'=>'js:$("#serial").val()'),
                        'success'=>'js:function(html){ $("#frame_result").html(html); }'
                    ), array('class'=>'btn btn-default')
                ); ?>
            </div>
        </div>
        <div id='frame_result'></div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
<h5>Выбор региона производства</h5>

    <?php foreach($aCatalogs as $aCatalog): ?>
        <?php echo CHtml::link($aCatalog, array('site/modelnames', 'catalog'=>$aCatalog));?>
    <?php endforeach; ?>

 
</div>

</div>
<?php endif; ?>