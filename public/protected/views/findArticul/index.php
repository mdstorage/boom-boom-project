<?php
/* @var $this FindArticulController */

$this->breadcrumbs=array(
	'Поиск запчасти по артикулу',
);
$this->pageTitle = "Поиск запчасти по артикулу";
?>
<div>
    <form class="form-inline" name="findArticul" action="<?php echo Yii::app()->createUrl('findArticul/articulRegions'); ?>">
        <?php echo CHtml::textField('articul', '' , array('id'=>'articul', 'class'=>'col-xs-8 form-control', 'placeholder'=>'Введите артикул запчасти')); ?>
        <button id="articul_submit" type="submit" class="btn btn-default">Искать</button>
    </form>
</div>
<script>
    $("#articul_submit").on("click", function(){
        if($("#articul").val() == ""){
            alert("Артикул не может быть пустым.");
            return false;
        }
    });
</script>
<!--<div class="col-md-3">-->
<!--        --><?php //echo CHtml::textField('articul', '' , array('id'=>'articul', 'class'=>'form-control', 'placeholder'=>'Введите артикул запчасти')).CHtml::ajaxButton("Искать", array("site/findbyvin"),
//    array(
//    'type'=>'POST',
//    'data'=>array('value'=>'js:$("#articul").val()'),
//    'success'=>'js:function(html){ $("#articul_result").html(html); }'
//    ), array('class'=>'btn btn-default')
//    ); ?>
<!--</div>-->
<!--<div id='articul_result'></div>-->
