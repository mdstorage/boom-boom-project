<?php
/* @var $this SiteController */

?>





<div class="container-fluid">


<?php

$this->breadcrumbs=array(
	'',);

?>


<?php if (!empty($aCatalogs)){echo '<div class="table">
  <table class="table">
   <tr>
  <td class="active"><b>Запрос по VIN</b><br/><div class="col-md-3">'.CHtml::textField('VIN', '' , array('id'=>'vin', 'class'=>'form-control', 'placeholder'=>'VIN')).'</div> '.CHtml::ajaxButton("Искать", array("site/findbyvin"),
            array(
                'type'=>'POST',
                'data'=>array('value'=>'js:$("#vin").val()'),
                'success'=>'js:function(html){ $("#vin_result").html(html); }'
            ), array('class'=>'btn btn-default')
			); echo '';
    echo "<div id='vin_result'></div>";
    echo "
  

  </td>
</tr>
  </table>
</div><br/>";}?>









<?php echo '<div class="table">
  <table class="table">
   <tr>
  <td class="active"><b>Запрос по FRAME</b><br/><div class="col-md-2">'.CHtml::textField('FRAME', '' , array('id'=>'frame', 'class'=>'form-control', 'placeholder'=>'FRAME')).'</div><div class="col-md-3">'.CHtml::textField('SERIAL', '' , array('id'=>'serial', 'class'=>'form-control')).'</div>  '.CHtml::ajaxButton("Искать", array("site/findbyvin"),
            array(
            'type'=>'POST',
            'data'=>array('frame'=>'js:$("#frame").val()', 'serial'=>'js:$("#serial").val()'),
            'success'=>'js:function(html){ $("#frame_result").html(html); }'
        ), array('class'=>'btn btn-default')
		);
    echo "<div id='frame_result'></div>
  
  </td>
  
</tr>
  </table>
</div>";?>


<div class="table-responsive">
  <table class="table">
   
  <td class="active"><b>Выбор региона производства</b><br/><br/>
  <?php
if (!empty($aCatalogs)){
    foreach($aCatalogs as $aCatalog){
        echo CHtml::link($aCatalog, array('site/modelnames', 'catalog'=>$aCatalog)) . '<br/>';
    }
}
?>
	<br/>
 
  </td>
   


  </table>
</div>

</div>