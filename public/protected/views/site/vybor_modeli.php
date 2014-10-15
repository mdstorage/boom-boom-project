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
    $this->breadcrumbs = array($sCatalog);$i=1;
 echo '<div class="panel-group" id="accordion">';
    foreach($aModelNames as $aModelName){
        echo '<div class="col-md-4">
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							
							<div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#'.$i.'">'. $aModelName . '</a></h4>
							</div>';
        
		 echo 				'<div id="'.$i.'" class="panel-collapse collapsing">
      								<div class="panel-body">';
		foreach($aModelNameCodes[$aModelName] as $aModelNameCode){
            echo 'Период выпуска: ' . CHtml::link(Functions::prodToDate($aModelNameCode['prod_start']) . ' - ' .
                    Functions::prodToDate($aModelNameCode['prod_end']), array(
                        'site/modelcodes',
                        'catalog'=>$sCatalog,
                        'cd'=>$aModelNameCode['cd'],
                        'catalogCode'=>$aModelNameCode['catalog_code'],
                        'modelName'=>$aModelName)) . '<br/>';
            echo 'Дополнительные коды модели: '.$aModelNameCode['add_codes'] . '<br/><br/>';
        }
echo'						 		</div>			 
		      			 	</div>
	  		   			</div>
					</div>
			  </div>
			  
	';
		$i++;
    									}
	 echo '</div>';
}
?>
</div>







