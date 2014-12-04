<?php
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
        $link = '<div style="height: 50px;">'.Yii::t('toyota',$aPartGroup['desc_en']) . ' ('.$aPartGroup['part_code'] .')</div>';
        if(file_exists(Yii::app()->basePath . '/../images/' .
            $sCatalog . '/grimages/' . trim($sCatalogCode) .
            '/' . $aPartGroup['pic_code'] . '.png')){


            $link .= '<div style="height: 100px;">' . CHtml::image(
                Yii::app()->request->baseUrl.'/images/' .
                $sCatalog . '/grimages/' . trim($sCatalogCode) .
                '/' . $aPartGroup['pic_code'] . '.png',
                $aPartGroup['pic_code'],
                array()) . '</div>';

        }
        echo ' <div class="col-xs-3">';
        echo CHtml::link($link, array(
                    'site/schemas',
                    'catalog'=>$sCatalog,
                    'cd'=>$sCd,
                    'catalogCode'=>$sCatalogCode,
                    'modelName'=>$sModelName,
                    'modelCode'=>$sModelCode,
                    'groupNumber'=>$groupNumber,
                    'partGroup'=>$aPartGroup['part_code'],
                    'page'=>1
                )
            ) . '<br/>';

        echo '</div>';
    }
}