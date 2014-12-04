<?php
/* @var $this FindArticulController */

$this->breadcrumbs=array(
	'Поиск запчасти по артикулу',
);
$this->pageTitle = "Поиск запчасти по артикулу";
?>
<div class="col-md-3">
        <?php echo CHtml::textField('articul', '' , array('id'=>'articul', 'class'=>'form-control', 'placeholder'=>'Введите артикул запчасти')).'</div> '.CHtml::ajaxButton("Искать", array("site/findbyvin"),
    array(
    'type'=>'POST',
    'data'=>array('value'=>'js:$("#articul").val()'),
    'success'=>'js:function(html){ $("#articul_result").html(html); }'
    ), array('class'=>'btn btn-default')
    ); ?>
</div>
<div id='articul_result'></div>
