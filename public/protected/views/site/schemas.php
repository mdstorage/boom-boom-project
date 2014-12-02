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
    <?php if(file_exists(Yii::app()->basePath . '/../images/' .
        $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
        '/' . $aPgPicture['pic_code'] . '.png')):?>
        <?php $size = getimagesize(Yii::app()->basePath . '/../images/' .
            $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
            '/' . $aPgPicture['pic_code'] . '.png');

        $k = $size[1]/$size[0];
        $kc = $width/$size[0];
        $height = $width * $k;?>

        <div class="col-xs-3">
        Схема <?php echo $counter; ?> из <?php echo $iCountPictures; ?>
        <?php echo CHtml::link(
            CHtml::image(
                Yii::app()->request->baseUrl.'/images/' .
                $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
                '/' . $aPgPicture['pic_code'] . '.png',
                $aPgPicture['pic_code'],
                array("width"=>$width)),
            array(
                'site/pncs',
                'catalog'=>$sCatalog,
                'cd'=>$sCd,
                'catalogCode'=>$sCatalogCode,
                'modelName'=>$sModelName,
                'modelCode'=>$sModelCode,
                'groupNumber'=>$groupNumber,
                'partGroup'=>$partGroup,
                'page'=>$counter
            )
        );?>
        </div>

    <?php endif; ?>

<?php endforeach; ?>
</div>