<ul class="nav nav-pills">
    <?php foreach($oFindArticul->getRegions() as $region): ?>
        <li class="<?php echo ($region->getCode() == $oFindArticul->getActiveRegion()->getCode()) ? 'active': ''; ?>"><a href="<?php echo Yii::app()->createUrl('findArticul/articulRegions', array('articul'=>$oFindArticul->getArticul(), 'regionCode'=>$region->getCode())) ?>"><?php echo $region->getRuname(); ?><br/></a></li>
    <?php endforeach; ?>
</ul>
<?php foreach($oFindArticul->getActiveRegion()->getModels() as $model): ?>
    <div id="model_<?php echo $model->getCode(); ?>" class="model"><?php echo $model->getName(); ?></div>
    <div id="modifications_<?php echo $model->getCode(); ?>"></div>
    <script>
        $("#model_<?php echo $model->getCode(); ?>").on("mouseover", function(){
            $(this).css('cursor', 'pointer');
        });
        $("#model_<?php echo $model->getCode(); ?>").on("click", function(){
            $("#modifications_<?php echo $model->getCode(); ?>").html('<?php echo CHtml::image(Yii::app()->baseUrl.'/images/loader.gif', 'Идет поиск', array('height'=>30)); ?>');
            $.ajax({
                type:   'POST',
                async:  false,
                url:    "<?php echo Yii::app()->createUrl('findArticul/articulModelModifications') ?>",
                data:   { articul: "<?php echo $oFindArticul->getArticul(); ?>", region: "<?php echo $oFindArticul->getActiveRegion()->getCode(); ?>", model: "<?php echo $model->getName(); ?>" },
                success: function(data) {
                    $("#modifications_<?php echo $model->getCode(); ?>").html(data);
                }
            });
        });
    </script>
<?php endforeach; ?>
