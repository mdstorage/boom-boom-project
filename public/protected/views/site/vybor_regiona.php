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
  <td class="active"><b>Запрос по VIN</b><br/> 
  <div class="row">
  
  <div class="col-xs-4">
    <input type="text" class="form-control" placeholder="Введите VIN">';
	CHtml::textField('VIN', '' , array('id'=>'vin')); echo '</div> <button type="submit" class="btn btn-default">'.CHtml::ajaxLink("OK", array("site/findbyvin"),
            array(
                'type'=>'POST',
                'data'=>array('value'=>'js:$("#vin").val()'),
                'success'=>'js:function(html){ $("#vin_result").html(html); }'
            ));
    echo "<div id='vin_result'></div>";
    echo "</button>
  
</div>
  </td>
  
</tr>
  </table>
</div><br/>";}?>









<?php echo '<div class="table-responsive">
  <table class="table">
   <tr>
  <td class="active"><b>Запрос по FRAME</b><br/> 
  <div class="row">
  <div class="col-xs-2">
    <input type="text" class="form-control" placeholder="FRAME">'; CHtml::textField('FRAME', '' , array('id'=>'frame')); echo '</div><div class="col-xs-3">
    <input type="text" class="form-control" placeholder="">';CHtml::textField('SERIAL', '' , array('id'=>'serial'));  echo '</div>
  <button type="submit" class="btn btn-default"> '.CHtml::ajaxLink("OK", array("site/findbyvin"),
            array(
            'type'=>'POST',
            'data'=>array('frame'=>'js:$("#frame").val()', 'serial'=>'js:$("#serial").val()'),
            'success'=>'js:function(html){ $("#frame_result").html(html); }'
        ));
    echo "<div id='frame_result'></div></button>
  
</div>


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