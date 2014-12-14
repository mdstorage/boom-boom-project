<?php foreach($oContainer->getActiveModification()->getComplectations() as $complectation): ?>
    <div class="col-lg-3">
        <a href="<?php echo Yii::app()->createUrl('findArticul/groups', array_merge($params, array('complectationCode'=>$complectation->getCode())));?>"><?php echo $complectation->getRuname(); ?></a>
        <div><?php echo Functions::PROD_START . ": " . $complectation->getOption(Functions::PROD_START) ?></div>
    </div>
<?php endforeach; ?>