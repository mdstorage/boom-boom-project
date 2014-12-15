<?php $this->pageTitle = "Выберите схему"; ?>
<?php
    $cd = $oContainer->getActiveModification()->getOption(Functions::CD);
    $regionCode = $oContainer->getActiveRegion()->getCode();
?>
<?php foreach ($oContainer->getSchemas() as $schema): ?>
    <div><?php echo $schema->getRuname(); ?></div>
    <?php if(file_exists(Yii::app()->basePath . '/../images/' .
        $regionCode . '/images_' . strtolower($regionCode) . '_' . strtolower($cd) .
        '/' . $schema->getCode() . '.png')):?>
        <?php echo CHtml::link(
            CHtml::image(
                Yii::app()->request->baseUrl . '/../images/' .
                $regionCode . '/images_' . strtolower($regionCode) . '_' . strtolower($cd) .
                '/' . $schema->getCode() . '.png',
                $schema->getCode(),
                array("width"=>300)),
            array_merge(array('findArticul/schema'), array_merge($params, array('schemaCode'=>$schema->getCode(), 'cd'=>$cd))
            )
        );?>
    <?php endif; ?>
<?php endforeach; ?>
