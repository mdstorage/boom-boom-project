<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php
if (!empty($aCatalogs)){
    echo "Поиск по VIN: " . CHtml::textField('VIN', '' , array('id'=>'vin')) . ' ' . CHtml::ajaxLink("Искать", array("site/findbyvin"),
            array(
                'type'=>'POST',
                'data'=>array('value'=>'js:$("#vin").val()'),
                'success'=>'js:function(html){ $("#vin_result").html(html); }'
            ));
    echo "<div id='vin_result'></div>";
    echo "<br/>";
    echo "Поиск по FRAME: " . CHtml::textField('FRAME', '' , array('id'=>'frame'))." - ".CHtml::textField('SERIAL', '' , array('id'=>'serial')) . ' ' .
        CHtml::ajaxLink("Искать", array("site/findbyvin"),
            array(
            'type'=>'POST',
            'data'=>array('frame'=>'js:$("#frame").val()', 'serial'=>'js:$("#serial").val()'),
            'success'=>'js:function(html){ $("#frame_result").html(html); }'
        ));
    echo "<div id='frame_result'></div>";
    echo "<h2>Выбрать регион </h2>";
    foreach($aCatalogs as $aCatalog){
        echo CHtml::link($aCatalog, array('site/modelnames', 'catalog'=>$aCatalog)) . '<br/>';
    }
}

if (!empty($aModelNames)){
    $this->breadcrumbs = array($sCatalog);
    echo "<h2>Выбрать наименование модели </h2>";
    foreach($aModelNames as $aModelName){
        echo '<b>' . $aModelName . '</b><br/>';
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
    }
}

if (!empty($aModelCodes)){
    $this->breadcrumbs = array($sCatalog=>array('site/modelnames', 'catalog'=>$sCatalog), $sModelName);

    echo "<h2>Выбрать модификацию модели </h2>";
    foreach($aModelCodes as $aModelCode){
        echo CHtml::link($aModelCode['model_code'], array(
                'groups',
                'catalog'=>$sCatalog,
                'cd'=>$sCd,
                'catalogCode'=>$aModelCode['catalog_code'],
                'modelName'=>$sModelName,
                'modelCode'=>$aModelCode['model_code'])) . '<br/>';
        echo $aModelCode['model_code'] . '<br/>';

        echo "Период выпуска: " . Functions::prodToDate($aModelCode['prod_start']) . ' - ' .
            Functions::prodToDate($aModelCode['prod_end']) . '<br/>';
        echo "Двигатель: " . $aModelCode['engine1'] . '<br/>';
        echo $aModelCode['body'] ? "Кузов: " . $aModelCode['body'] . '<br/>':'';
        echo "Класс модели: " . $aModelCode['grade'] . '<br/>';
        echo "Трансмиссия: " . $aModelCode['atm_mtm'] . '<br/>';
        echo "Кузов: " . $aModelCode['f1'] . '<br/>';
    }
}

if (!empty($groups)){
    $this->breadcrumbs = array(
        $sCatalog=>array('site/modelnames', 'catalog'=>$sCatalog),
        $sModelName=>array(
        'site/modelcodes', 'catalog'=>$sCatalog, 'cd'=>$sCd, 'catalogCode'=>$sCatalogCode, 'modelName'=>$sModelName
        ),
        $sModelCode
    );

    echo '<table class="table">
  
  <tr><td class="active"><b>Выбор группы запчастей</b></td>
  
  </tr>
  </table>';

    for ($i=1; $i<7;$i++){
        echo CHtml::link(Functions::getGroupName($i),
                array('site/subgroups',
                    'catalog'=>$sCatalog,
                    'cd'=>$sCd,
                    'catalogCode'=>$sCatalogCode,
                    'modelName'=>$sModelName,
                    'modelCode'=>$sModelCode,
                    'groupNumber'=>$i)) . '<br/>';
    }
}




?>




