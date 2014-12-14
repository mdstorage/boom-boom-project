<?php $this->pageTitle = "Выберите схему"; ?>
<?php foreach ($oContainer->getSchemas() as $schema): ?>
    <div><?php echo $schema->getRuname(); ?></div>
    <?php if(file_exists(Yii::app()->basePath . '/../images/' .
        $oContainer->getActiveRegion()->getCode() . '/images_' . strtolower($oContainer->getActiveRegion()->getCode()) . '_' . strtolower($oContainer->getActiveModification()->getOption(Functions::CD)) .
        '/' . $schema->getCode() . '.png')):?>
        <?php echo CHtml::link(
            CHtml::image(
                Yii::app()->request->baseUrl . '/../images/' .
                $oContainer->getActiveRegion()->getCode() . '/images_' . strtolower($oContainer->getActiveRegion()->getCode()) . '_' . strtolower($oContainer->getActiveModification()->getOption(Functions::CD)) .
                '/' . $schema->getCode() . '.png',
                $schema->getCode(),
                array("width"=>300)),
            array_merge(array('findArticul/schema'), $params
            )
        );?>
    <?php endif; ?>
<?php endforeach; ?>
