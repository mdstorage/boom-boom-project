<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

  <table class="table">
  
  <tr><td class="active"><b>Выбор модели</b></td>
  
  </tr>
  </table>

   	
  
  
  
  



<div class="row">
<?php
if (!empty($aModelNames))
{
    $this->breadcrumbs = array($sCatalog);
 echo '<div class="btn-group-justified">';
    foreach($aModelNames as $aModelName){
        echo ' <div class="col-md-4"><button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" style="width: 100%; text-align: left">'. $aModelName .'
 </button>';
        
		 echo 				'<ul class="dropdown-menu"><span>';
		foreach($aModelNameCodes[$aModelName] as $aModelNameCode){
            echo '<li>Период выпуска: ' . CHtml::link(Functions::prodToDate($aModelNameCode['prod_start']) . ' - ' .
                    Functions::prodToDate($aModelNameCode['prod_end']), array(
                        'site/modelcodes',
                        'catalog'=>$sCatalog,
                        'cd'=>$aModelNameCode['cd'],
                        'catalogCode'=>$aModelNameCode['catalog_code'],
                        'modelName'=>$aModelName)) . '</li>';
            echo '<li>Дополнительные коды модели: '.$aModelNameCode['add_codes'] . '<br/><br/></li>';
        }
echo'						 		</ul></span></div>
	';
    									}
	 echo '<br/></div>';
}
?>
</div>








