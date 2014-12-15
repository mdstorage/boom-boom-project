<?php $this->pageTitle = "Запчасти для схемы"; ?>
<?php
    $regionCode = $oContainer->getActiveRegion()->getCode();
    $commonArticuls = $oContainer->getActiveSchema()->getCommonArticuls();
    $refGroups = $oContainer->getActiveSchema()->getRefGroups();

    $schemaCode = $oContainer->getActiveSchema()->getCode();
    $pncs = $oContainer->getActiveSchema()->getPncs();

?>
<div class="row">
    <div class="col-lg-3">
        <?php foreach($pncs as $pnc): ?>
            <?php echo $pnc->getRuname() ?><br/>
        <?php endforeach; ?>
        <?php if(!empty($commonArticuls)): ?>
            <h4>Общие запчасти:</h4>
            <?php foreach($commonArticuls as $commonArticul): ?>
                <?php echo $commonArticul->getRuname() ?><br/>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if(!empty($refGroups)): ?>
            <h4>Ссылки на группы:</h4>
            <?php foreach($refGroups as $refGroup): ?>
                <?php echo $refGroup->getRuname() ?><br/>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="col-lg-9">
        <?php if(file_exists(Yii::app()->basePath . '/../images/' .
            $regionCode . '/images_' . strtolower($regionCode) . '_' . strtolower($params['cd']) .
            '/' . $schemaCode . '.png')): ?>

            <?php echo CHtml::image(
            Yii::app()->request->baseUrl . '/../images/' .
            $regionCode . '/images_' . strtolower($regionCode) . '_' . strtolower($params['cd']) .
            '/' . $schemaCode . '.png',
                $schemaCode,
            array("usemap"=>'#' . $schemaCode)); ?>

            <map name= <?php echo $schemaCode; ?> >

                <?php foreach($pncs as $pnc): ?>
                    <area shape="rect" coords="<?php echo $pnc->getOption(Functions::X1).','.$pnc->getOption(Functions::Y1).','.$pnc->getOption(Functions::X2).','.$pnc->getOption(Functions::Y2); ?>"
                          href="#<?php echo $schemaCode.$pnc->getCode(); ?>" id="area<?php echo $schemaCode.$pnc->getCode() ?>" data-name="<?php echo $schemaCode.$pnc->getCode() ?>">
                <?php endforeach; ?>

                <?php if(!empty($commonArticuls)): ?>
                    <?php foreach($commonArticuls as $commonArticul): ?>
                        <area shape="rect" coords="<?php echo $commonArticul->getOption(Functions::X1).','.$commonArticul->getOption(Functions::Y1).','.$commonArticul->getOption(Functions::X2).','.$commonArticul->getOption(Functions::Y2); ?>"
                              href="#<?php echo $schemaCode.$commonArticul->getCode(); ?>" id="area<?php echo $schemaCode.$commonArticul->getCode() ?>" data-name="<?php echo $schemaCode.$commonArticul->getCode() ?>">
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if(!empty($refGroups)): ?>
                    <?php foreach($refGroups as $refGroup): ?>
                        <area shape="rect" coords="<?php echo $refGroup->getOption(Functions::X1).','.$refGroup->getOption(Functions::Y1).','.$refGroup->getOption(Functions::X2).','.$refGroup->getOption(Functions::Y2); ?>"
                              href="#<?php echo $schemaCode.$refGroup->getCode(); ?>" id="area<?php echo $schemaCode.$refGroup->getCode() ?>" data-name="<?php echo $schemaCode.$refGroup->getCode() ?>">
                    <?php endforeach; ?>
                <?php endif; ?>

            </map>
        <?php endif; ?>
    </div>
</div>

