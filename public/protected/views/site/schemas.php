<?php
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

  <tr><td class="active"><b>Выбор схемы</b></td>

  </tr>
  </table>';
?>
<div class="row">
<?php $counter = 0; ?>
<?php foreach ($aPgPictures as $aPgPicture) :?>
    <?php $counter++; ?>
    <?php $width = (Yii::app()->params['imageWidth'])/3;?>
    <?php $link = "Схема " . $counter . " из " . $iCountPictures; ?>
    <?php if(file_exists(Yii::app()->basePath . '/../images/' .
        $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
        '/' . $aPgPicture['pic_code'] . '.png')):?>
        <?php $size = getimagesize(Yii::app()->basePath . '/../images/' .
            $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
            '/' . $aPgPicture['pic_code'] . '.png');

        $k = $size[1]/$size[0];
        $kc = $width/$size[0];
        $height = $width * $k;

        $link .= CHtml::image(
            Yii::app()->request->baseUrl.'/images/' .
            $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
            '/' . $aPgPicture['pic_code'] . '.png',
            $aPgPicture['pic_code'],
            array("width"=>$width));

        ?>
    <?php endif; ?>

    <div class="col-xs-3">

        <?php echo CHtml::link(
            $link,
            array(
                'site/pncs',
                'catalog'=>$sCatalog,
                'cd'=>$sCd,
                'catalogCode'=>$sCatalogCode,
                'modelName'=>$sModelName,
                'modelCode'=>$sModelCode,
                'groupNumber'=>$groupNumber,
                'partGroup'=>$partGroup,
                'prodDate'=>$prodDate,
                'page'=>$counter
            )
        );?>
    </div>

<?php endforeach; ?>
</div>