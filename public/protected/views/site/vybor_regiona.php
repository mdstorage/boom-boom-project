<?php
/* @var $this SiteController */

?>





<div class="container-fluid">


<?php
$this->breadcrumbs=array(
	'',);

?>
  





<div class="table">
  <table class="table">
   <tr>
  <td class="active"><b>Запрос по VIN</b><br/> 
  <div class="row">
  
  <div class="col-xs-4">
    <input type="text" class="form-control" placeholder="Введите VIN">
  </div>
  <button type="submit" class="btn btn-default">ОК</button>
  
</div>


  </td>
  
</tr>
  </table>
</div>

<div class="table-responsive">
  <table class="table">
   <tr>
  <td class="active"><b>Запрос по FRAME</b><br/> 
  <div class="row">
  <div class="col-xs-2">
    <input type="text" class="form-control" placeholder="FRAME">
  </div>
  
  <div class="col-xs-3">
    <input type="text" class="form-control" placeholder="">
  </div>
  <button type="submit" class="btn btn-default">ОК</button>
  
</div>


  </td>
  
</tr>
  </table>
</div>
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