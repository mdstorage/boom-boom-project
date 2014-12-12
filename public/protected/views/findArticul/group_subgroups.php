<div class="row">
    <?php foreach($oContainer->getActiveGroup()->getSubgroups() as $subgroup): ?>
        <?php
        $link = '<div style="height: 50px;">' . $subgroup->getRuname() . '</div>';
        if(file_exists(Yii::app()->basePath . '/../images/' .
            $oContainer->getActiveRegion()->getCode() . '/grimages/' . $oContainer->getActiveModification()->getCode() .
            '/' . $subgroup->getOption('picture') . '.png')){

            $link .= '<div style="height: 100px;">' . CHtml::image(
                    Yii::app()->request->baseUrl.'/images/' .
                    $oContainer->getActiveRegion()->getCode() . '/grimages/' . $oContainer->getActiveModification()->getCode() .
                    '/' . $subgroup->getOption('picture') . '.png',
                    $subgroup->getOption('picture'),
                    array()) . '</div>';
        }?>

        <div class="col-lg-2">
            <a href="<?php echo Yii::app()->createUrl('findArticul/articulSubgroupSchemas', $params) ?>"><?php echo $link; ?></a>
        </div>


    <?php endforeach; ?>
</div>