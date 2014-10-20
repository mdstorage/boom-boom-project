<?php
/* @var $this SiteController */

?>





<div class="container-fluid">


<?php

$this->breadcrumbs=array(
	'',);

?>

<?php if (!empty($aCatalogs)) : ?>
    <table class="table">

        <tr class="active">
            <td><h3>Запрос по VIN</h3></td>
            <td></td>
        </tr>
        <tr>
            <td><?php echo CHtml::textField('VIN', '' , array('id'=>'vin', 'class'=>'form-control', 'maxlength'=>17)); ?></td>
            <td><?php echo CHtml::ajaxButton("Искать по VIN", array("site/findbyvin"),
                  array(
                      'type'=>'POST',
                      'data'=>array('value'=>'js:$("#vin").val()'),
                      'success'=>'js:function(html){ $("#vin_result").html(html); }'
                  ),
                  array('class'=>'btn btn-info')
              ); ?></td>
        </tr>
        <tr>
            <td><div id='vin_result'></div></td>
            <td></td>
        </tr>

    </table>
    <table class="table">
        <tr class="active">
            <td><h3>Запрос по FRAME</h3></td>
            <td></td><td></td><td></td>
        </tr>
        <tr>
            <td><?php echo CHtml::textField('FRAME', '' , array('id'=>'frame', 'class'=>'form-control', 'maxlength'=>6, 'width'=>6)); ?></td>
            <td> - </td>
            <td><?php echo CHtml::textField('SERIAL', '' , array('id'=>'serial', 'class'=>'form-control', 'maxlength'=>7, 'width'=>7)); ?></td>
            <td><?php echo CHtml::ajaxButton("Искать по FRAME", array("site/findbyvin"),
                    array(
                        'type'=>'POST',
                        'data'=>array('frame'=>'js:$("#frame").val()', 'serial'=>'js:$("#serial").val()'),
                        'success'=>'js:function(html){ $("#frame_result").html(html); }'
                    ),
                    array('class'=>'btn btn-info')
                ); ?></td>
        </tr>
        <tr>
            <td><div id='frame_result'></div></td>
            <td></td><td></td><td></td>
        </tr>
    </table>

<?php endif; ?>

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