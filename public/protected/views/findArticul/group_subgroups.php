<div class="row">
    <?php foreach($oFindArticul->getActiveGroup()->getSubgroups() as $subgroup): ?>
        <?php
        $link = '<div style="height: 50px;">' . $subgroup->getRuname() . '</div>';
        if(file_exists(Yii::app()->basePath . '/../images/' .
            $oFindArticul->getActiveRegion()->getCode() . '/grimages/' . $oFindArticul->getActiveModification()->getCode() .
            '/' . $subgroup->getOptions()->getOption('picture') . '.png')){

            $link .= '<div style="height: 100px;">' . CHtml::image(
                    Yii::app()->request->baseUrl.'/images/' .
                    $oFindArticul->getActiveRegion()->getCode() . '/grimages/' . $oFindArticul->getActiveModification()->getCode() .
                    '/' . $subgroup->getOptions()->getOption('picture') . '.png',
                    $subgroup->getOptions()->getOption('picture'),
                    array()) . '</div>';
        }?>

        <div class="col-lg-2">
            <a href="<?php echo Yii::app()->createUrl('findArticul/articulSubgroupSchemas', $params) ?>"><?php echo $link; ?></a>
        </div>


    <?php endforeach; ?>
</div>