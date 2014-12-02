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

    echo '<table class="table">
  
  <tr><td class="active"><b>Выбор подгруппы запчастей</b></td>
  
  </tr>
  </table>';

    foreach ($aPartGroups as $aPartGroup){
        echo ' <div class="col-md-6">';
        echo CHtml::link($aPartGroup['desc_en'], array(
                    'site/pncs',
                    'catalog'=>$sCatalog,
                    'cd'=>$sCd,
                    'catalogCode'=>$sCatalogCode,
                    'modelName'=>$sModelName,
                    'modelCode'=>$sModelCode,
                    'groupNumber'=>$groupNumber,
                    'partGroup'=>$aPartGroup['part_code'],
                    'page'=>1
                )
            ) . '<br/></div>';
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

    echo '<table class="table">
  
  <tr><td class="active"><b>Выбрать запчасть</b></td>
  
  </tr>
  </table>';

    echo "Иллюстрации: ";
    for($i=1; $i<=$iCountPictures; $i++){
        $currentPage = Yii::app()->request->getParam('page');
        if ($i == $currentPage){
            echo $i . " ";
        } else {
            echo CHtml::link($i, array(
                    'site/pncs',
                    'catalog'=>$sCatalog,
                    'cd'=>$sCd,
                    'catalogCode'=>$sCatalogCode,
                    'modelName'=>$sModelName,
                    'modelCode'=>$sModelCode,
                    'groupNumber'=>$groupNumber,
                    'partGroup'=>$sPartGroup,
                    'page'=>$i
                )). " ";
        }
    }

    echo "<br/>";

    foreach ($aPgPictures as $aPgPicture){
        $width = Yii::app()->params['imageWidth'];
        if(file_exists(Yii::app()->basePath . '/../images/' .
            $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
            '/' . $aPgPicture['pic_code'] . '.png')){
            $size = getimagesize(Yii::app()->basePath . '/../images/' .
                $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
                '/' . $aPgPicture['pic_code'] . '.png');

            $k = $size[1]/$size[0];
            $kc = $width/$size[0];
            $height = $width * $k;

            echo '<div class="row">';
            echo '<div class="col-sm-7">';
            echo CHtml::image(
                Yii::app()->request->baseUrl.'/images/' .
                $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
                '/' . $aPgPicture['pic_code'] . '.png',
                $aPgPicture['pic_code'],
                array("width"=>$width, "usemap"=>'#' . $aPgPicture['pic_code']));
            echo '<map name='. $aPgPicture['pic_code'] .'>';
            foreach($aPgPicture['pncs'] as $aPncCoords){
                echo '<area shape="rect" coords="'.$aPncCoords['x1']*$kc.','.$aPncCoords['y1']*$kc.','.$aPncCoords['x2']*$kc.','.$aPncCoords['y2']*$kc.'"
                href="#'.$aPgPicture['pic_code'].$aPncCoords['label2'].'" id="area'.$aPgPicture['pic_code'].$aPncCoords['label2'].'">';
                foreach($aPgPicture['general'] as $aPncCoords){
                    echo '<area shape="rect" coords="'.$aPncCoords['x1']*$kc.','.$aPncCoords['y1']*$kc.','.$aPncCoords['x2']*$kc.','.$aPncCoords['y2']*$kc.'"
                href="#'.$aPgPicture['pic_code'].$aPncCoords['label2'].'" id="area'.$aPgPicture['pic_code'].$aPncCoords['label2'].'">';
                }
            }
            echo '</map><br/>';
        }
        echo '</div>';
        echo '<div class="col-sm-5">';
        foreach ($aPgPicture['pncs'] as $aPnc){
            if(in_array($aPnc['label2'], $aPgPicture['pnc_list'])){
                echo '<a name=' . $aPgPicture['pic_code'] . $aPnc['label2'] . '></a><div class="btn-default" id="pncs_' . $aPgPicture['pic_code'] . $aPnc['label2'] .'">' . $aPnc['label2'] . " " . $aPnc['desc_en'] . '</div><br/>';
                echo '<table id="table_'.$aPgPicture['pic_code'] . $aPnc['label2'].'" class="hidden table table-striped table-bordered">';
                echo '<thead>
                <td>Код</td>
                <td>Период выпуска</td>
                <td>Количество</td>
                <td>Применяемость</td>
              </thead><tbody>';
                foreach($aPartCatalog[$aPnc['label2']] as $aPartCode){
                    echo '<tr>';
                    echo '<td><a href=' . Yii::app()->params['outUrl'] . $aPartCode['part_code'] . ' target="_blank" >' . $aPartCode['part_code']  .'</a></td>';
                    echo '<td>' . Functions::prodToDate($aPartCode['start_date']) . ' - ' . Functions::prodToDate($aPartCode['end_date']) .'</td>';
                    echo '<td>' . $aPartCode['quantity']  .'</td>';
                    echo '<td>' .Functions::getString($aPartCode['add_desc']).'</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
                echo '
                    <script>
                        $("#pncs_'.$aPgPicture['pic_code'] . $aPnc['label2'].'").on("mouseover", function(){
                            $(this).css("cursor", "pointer");
                        });
                        $("#pncs_'.$aPgPicture['pic_code'] . $aPnc['label2'].'").on("click", function(){
                            $("#table_'.$aPgPicture['pic_code'] . $aPnc['label2'].'").toggleClass("hidden");
                            $(this).removeClass("btn-warning btn-info");
                            $(this).toggleClass("btn-success");
                        });
                        $("area#area'.$aPgPicture['pic_code'] . $aPnc['label2'].'").on("click", function(){
                            $("#pncs_'.$aPgPicture['pic_code'] . $aPnc['label2'].'").removeClass("btn-info");
                            $("#pncs_'.$aPgPicture['pic_code'] . $aPnc['label2'].'").toggleClass("btn-warning");
                        });
                        $("area#area'.$aPgPicture['pic_code'] . $aPnc['label2'].'").on("mouseover", function(){

                            $("#pncs_'.$aPgPicture['pic_code'] . $aPnc['label2'].'").addClass("btn-info");
                        });
                        $("area#area'.$aPgPicture['pic_code'] . $aPnc['label2'].'").on("mouseout", function(){
                            $("#pncs_'.$aPgPicture['pic_code'] . $aPnc['label2'].'").removeClass("btn-info");
                        });
                    </script>
                    ';
            }

            unset($aPgPicture['pnc_list'][$aPnc['label2']]);

        }
        if($aPgPicture['general']){
            echo 'Стандартные запчасти:<br/>';
            foreach($aPgPicture['general'] as $aPartCode){
                $aPartCodes[$aPartCode['label2']] = $aPartCode;
            }
            foreach($aPartCodes as $aPartCode){
                echo '<a name=' . $aPgPicture['pic_code']  . $aPartCode['label2'] . '></a>';
                echo '<a href=' . Yii::app()->params['outUrl'] . $aPartCode['label2'] . ' target="_blank" >' . $aPartCode['label2'] . $aPartCode['desc_en'] .'</a><br/>';
            }
        }

        if($aPgPicture['groups']){
            echo 'Связанные группы:<br/>';
            foreach($aPgPicture['groups'] as $aPartCode){
                echo '<a name=' . $aPgPicture['pic_code'] . $aPartCode['label2'] . '></a>';
                echo CHtml::link($aPartCode['label2'] . " " . $aPartCode['desc_en'], array(
                            'site/pncs',
                            'catalog'=>$sCatalog,
                            'cd'=>$sCd,
                            'catalogCode'=>$sCatalogCode,
                            'modelName'=>$sModelName,
                            'modelCode'=>$sModelCode,
                            'groupNumber'=>$groupNumber,
                            'partGroup'=>$aPartCode['label2'],
                            'page'=>1
                        )
                    ) . '<br/>';
            }
        }
    }
    echo '</div>';
    echo '</div>';


}
?>




