<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php
if (!empty($aCatalogs)){
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
                'catalogCode'=>$aModelCode['catalog_code'],
                'modelName'=>$sModelName,
                'modelCode'=>$aModelCode['model_code'])) . '<br/>';
        echo $aModelCode['model_code'] . '<br/>';

        echo "Период выпуска: " . Functions::prodToDate($aModelCode['prod_start']) . ' - ' .
            Functions::prodToDate($aModelCode['prod_end']) . '<br/>';
        echo "Двигатель: " . $aModelCode['engine1'] . '<br/>';
        echo "Кузов: " . $aModelCode['body'] . '<br/>';
        echo "Класс модели: " . $aModelCode['grade'] . '<br/>';
        echo "Трансмиссия: " . $aModelCode['atm_mtm'] . '<br/>';
        echo "Кузов: " . $aModelCode['f1'] . '<br/>';
    }
}

if (!empty($groups)){
    $this->breadcrumbs = array(
        $sCatalog=>array('site/modelnames', 'catalog'=>$sCatalog),
        $sModelName=>array(
        'site/modelcodes', 'catalog'=>$sCatalog, 'catalogCode'=>$sCatalogCode, 'modelName'=>$sModelName
        ),
        $sModelCode
    );

    echo CHtml::link("Двигатель/Топливная система/Принадлежности",
            array('site/subgroups',
                'catalog'=>$sCatalog,
                'catalogCode'=>$sCatalogCode,
                'modelName'=>$sModelName,
                'modelCode'=>$sModelCode,
                'groupNumber'=>1)) . '<br/>';
    echo CHtml::link("Трансмиссия/Подвеска") . '<br/>';
    echo CHtml::link("Кузов") . '<br/>';
    echo CHtml::link("Электрика") . '<br/>';
}



