<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

  <table class="table">
  
  <tr><td class="active"><b>Выбор модификации модели</b></td>
  
  </tr>
  </table>
  
  
  

   	
  
  
  
  



<div class="row">
<?php if (!empty($aModelCodes)){
    $this->breadcrumbs = array($sCatalog=>array('site/modelnames', 'catalog'=>$sCatalog), $sModelName);

    foreach($aModelCodes as $aModelCode){
       
 echo ' <div class="col-md-4" style="align: left">';
 	    echo CHtml::link($aModelCode['model_code'], array(
                'groups',
                'catalog'=>$sCatalog,
                'cd'=>$sCd,
                'catalogCode'=>$aModelCode['catalog_code'],
                'modelName'=>$sModelName,
                'modelCode'=>$aModelCode['model_code'])) . '<br/>';
       

        echo "Период выпуска: " . Functions::prodToDate($aModelCode['prod_start']) . ' - ' .
            Functions::prodToDate($aModelCode['prod_end']) . '<br/>';
        echo "Двигатель: " . $aModelCode['engine1'] . '<br/>';
        echo $aModelCode['body'] ? "Кузов: " . $aModelCode['body'] . '<br/>':'';
        echo "Класс модели: " . $aModelCode['grade'] . '<br/>';
        echo "Трансмиссия: " . $aModelCode['atm_mtm'] . '<br/>';
        echo "Кузов: " . $aModelCode['f1'] . '<br/>';
    echo ' <br/></div>'; }
}?>

</div>








