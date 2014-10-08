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
        'site/modelcodes', 'catalog'=>$sCatalog, 'cd'=>$sCd, 'catalogCode'=>$sCatalogCode, 'modelName'=>$sModelName
        ),
        $sModelCode
    );

    echo "<h2>Выбрать группу запчастей </h2>";

    for ($i=1; $i<5;$i++){
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

if (!empty($aPartGroups)){
    $groupName = Functions::getGroupName($groupNumber);
    $this->breadcrumbs = array(
        $sCatalog=>array('site/modelnames', 'catalog'=>$sCatalog),
        $sModelName=>array(
            'site/modelcodes', 'catalog'=>$sCatalog, 'cd'=>$sCd, 'catalogCode'=>$sCatalogCode, 'modelName'=>$sModelName
        ),
        $sModelCode=>array(
            'site/groups', 'catalog'=>$sCatalog, 'cd'=>$sCd, 'catalogCode'=>$sCatalogCode, 'modelName'=>$sModelName, 'modelCode'=>$sModelCode
        ),
        $groupName
    );

    echo "<h2>Выбрать подгруппу запчастей </h2>";

    foreach ($aPartGroups as $aPartGroup){
        echo CHtml::link($aPartGroup['desc_en'], array(
                'site/pncs',
                    'catalog'=>$sCatalog,
                    'cd'=>$sCd,
                    'catalogCode'=>$sCatalogCode,
                    'modelName'=>$sModelName,
                    'modelCode'=>$sModelCode,
                    'groupNumber'=>$groupNumber,
                    'partGroup'=>$aPartGroup['part_code']
                )
            ) . '<br/>';
    }
}

if (!empty($aPncs)){
    $groupName = Functions::getGroupName($groupNumber);
    $this->breadcrumbs = array(
        $sCatalog=>array('site/modelnames', 'catalog'=>$sCatalog),
        $sModelName=>array(
            'site/modelcodes', 'catalog'=>$sCatalog, 'cd'=>$sCd, 'catalogCode'=>$sCatalogCode, 'modelName'=>$sModelName
        ),
        $sModelCode=>array(
            'site/groups', 'catalog'=>$sCatalog, 'cd'=>$sCd, 'catalogCode'=>$sCatalogCode, 'modelName'=>$sModelName, 'modelCode'=>$sModelCode
        ),
        $groupName=>array(
            'site/subgroups', 'catalog'=>$sCatalog, 'cd'=>$sCd, 'catalogCode'=>$sCatalogCode, 'modelName'=>$sModelName, 'modelCode'=>$sModelCode, 'groupNumber'=>$groupNumber
        ),
        $sPartGroupDescEn
    );

    echo "<h2>Выбрать запчасть</h2>";

    foreach ($aPgPictures as $aPgPicture){
        $width = Yii::app()->params['imageWidth'];

        $size = getimagesize(Yii::app()->basePath . '/../images/' .
            $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
            '/' . $aPgPicture['pic_code'] . '.png');


            $k = $size[1]/$size[0];
            $kc = $width/$size[0];
            $height = $width * $k;


        echo CHtml::image(
            Yii::app()->request->baseUrl.'/images/' .
            $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
            '/' . $aPgPicture['pic_code'] . '.png',
            $aPgPicture['pic_code'],
            array("width"=>$width, "usemap"=>'#' . $aPgPicture['pic_code']));
        echo '<map name='. $aPgPicture['pic_code'] .'>';
            foreach($aPncs as $aPnc){
                foreach ($aPgPicture[$aPnc['pnc']] as $aPncCoords){
                    echo '<area shape="rect" coords="'.$aPncCoords['x1']*$kc.','.$aPncCoords['y1']*$kc.','.$aPncCoords['x2']*$kc.','.$aPncCoords['y2']*$kc.'"
                href="#'.$aPnc['pnc'].'">';
                }
            }
        echo '</map>';
    }

    echo '<br/>';

    foreach ($aPncs as $aPnc){
        echo '<a name=' . $aPnc['pnc'] . '></a>' . $aPnc['desc_en'] . '<br/>';
        echo '<table class="hidden">';
        echo '<thead>
                <td>Код</td>
                <td>Период выпуска</td>
                <td>Количество</td>
                <td>Применяемость</td>
              </thead><tbody>';
        foreach($aPartCatalog[$aPnc['pnc']] as $aPartCode){
            echo '<tr>';
            echo '<td><a href=' . Yii::app()->params['outUrl'] . $aPartCode['part_code'] . ' target="_blank" >' . $aPartCode['part_code']  .'</a></td>';
            echo '<td>' . Functions::prodToDate($aPartCode['start_date']) . '-' . Functions::prodToDate($aPartCode['end_date']) .'</td>';
            echo '<td>' . $aPartCode['quantity']  .'</td>';
            echo '<td>' . $aPartCode['add_desc']  .'</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }
}



