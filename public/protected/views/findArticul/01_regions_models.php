<?php $this->pageTitle = "Данная запчасть используется в следующих моделях и их модификациях" ?>
<ul class="nav nav-pills">
    <?php foreach($oContainer->getRegions() as $region): ?>
        <li class="<?php echo ($region->getCode() == $oContainer->getActiveRegion()->getCode()) ? 'active': ''; ?>"><a href="<?php echo Yii::app()->createUrl('findArticul/articulRegions', array('articul'=>$oContainer->getActiveArticul()->getCode(), 'regionCode'=>$region->getCode())) ?>"><?php echo $region->getRuname(); ?><br/></a></li>
    <?php endforeach; ?>
</ul>
<?php foreach($oContainer->getActiveRegion()->getModels() as $model): ?>
    <div id="model_<?php echo $model->getCode(); ?>" class="model"><?php echo $model->getRuname(); ?></div>
    <div id="modifications_<?php echo $model->getCode(); ?>"></div>
    <script>
        $("#model_<?php echo $model->getCode(); ?>").on("mouseover", function(){
            $(this).css('cursor', 'pointer');
        });
        $("#model_<?php echo $model->getCode(); ?>").on("click", function(){
            $("#modifications_<?php echo $model->getCode(); ?>").html('<?php echo CHtml::image(Yii::app()->baseUrl.'/images/loader.gif', 'Идет поиск', array('height'=>10)); ?>');
            $.ajax({
                type:   'POST',
                async:  false,
                url:    "<?php echo Yii::app()->createUrl('findArticul/articulModelModifications') ?>",
                data:   { articul: "<?php echo $oContainer->getActiveArticul()->getCode(); ?>", region: "<?php echo $oContainer->getActiveRegion()->getCode(); ?>", model: "<?php echo $model->getRuname(); ?>" },
                success: function(data) {
                    $("#modifications_<?php echo $model->getCode(); ?>").html(data);
                }
            });
        });
    </script>
<?php endforeach; ?>
