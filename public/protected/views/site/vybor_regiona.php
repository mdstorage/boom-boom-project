<?php
/* @var $this SiteController */

?>





<div class="container-fluid">


<?php

$this->breadcrumbs=array(
	'',);
$this->pageTitle=Yii::app()->name;
?>


<?php if (!empty($aCatalogs)){echo '<div class="container"><div class="row">
  <b>Запрос по VIN</b><br/><br/><div class="col-md-3">'.CHtml::textField('VIN', '' , array('id'=>'vin', 'class'=>'form-control', 'placeholder'=>'VIN')).'</div> '.CHtml::ajaxButton("Искать", array("site/findbyvin"),
            array(
                'type'=>'POST',
                'data'=>array('value'=>'js:$("#vin").val()'),
                'success'=>'js:function(html){ $("#vin_result").html(html); }'
            ), array('class'=>'btn btn-default')
			); echo '';
    echo "<div id='vin_result'></div>";
    echo "
  

</div></div><br/> <hr>";}?>



<?php echo '
  <div class="container"><div class="row"><b>Запрос по FRAME</b><br/><br/><div class="col-md-2">'.CHtml::textField('FRAME', '' , array('id'=>'frame', 'class'=>'form-control', 'placeholder'=>'FRAME')).'</div><div class="col-md-3">'.CHtml::textField('SERIAL', '' , array('id'=>'serial', 'class'=>'form-control')).'</div>  '.CHtml::ajaxButton("Искать", array("site/findbyvin"),
            array(
            'type'=>'POST',
            'data'=>array('frame'=>'js:$("#frame").val()', 'serial'=>'js:$("#serial").val()'),
            'success'=>'js:function(html){ $("#frame_result").html(html); }'
        ), array('class'=>'btn btn-default')
		);
    echo "<div id='frame_result'></div></div></div><br/> <hr>
  
";?>


<div class="container">
<div class="row">
<b>Выбор региона производства</b><br/><br/>
  <?php
if (!empty($aCatalogs)){
    foreach($aCatalogs as $aCatalog){
        echo CHtml::link($aCatalog, array('site/modelnames', 'catalog'=>$aCatalog)) . '<br/>';
    }
}
?>
	<br/>
 
</div>

</div>
</div>