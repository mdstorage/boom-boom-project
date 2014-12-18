<?php $this->pageTitle = "Запчасти для схемы"; ?>
<?php
    $regionCode = $oContainer->getActiveRegion()->getCode();
    $commonArticuls = $oContainer->getActiveSchema()->getCommonArticuls();
    $refGroups = $oContainer->getActiveSchema()->getRefGroups();

    $schemaCode = $oContainer->getActiveSchema()->getCode();
    $pncs = $oContainer->getActiveSchema()->getPncs();

?>
<div class="row">
    <div class="col-lg-4">
        <?php foreach($pncs as $pnc): ?>
            <div id="pnc_<?php echo $pnc->getCode(); ?>"><?php echo $pnc->getCode()." ".$pnc->getRuname() ?></div>

            <?php if(in_array($pnc->getCode(), $oContainer->getActivePnc()->getCollectionCodes())): ?>
            <div id="articuls_<?php echo $pnc->getCode(); ?>">
                    <table class="table" id="<?php echo $pnc->getCode(); ?>">
                        <?php foreach($oContainer->getActivePnc()->getCollectionItem($pnc->getCode())->getArticuls() as $articul): ?>
                            <tr>
                                <?php if($articul->getCode() == $oContainer->getActiveArticul()->getCode()): ?>
                                    <td><strong><?php echo $articul->getCode(); ?></strong></td>
                                <?php else: ?>
                                    <td><?php echo $articul->getCode(); ?></td>
                                <?php endif; ?>
                                <?php foreach($articul->getOptions() as $name=>$value): ?>
                                    <td><?php echo $value; ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
            </div>
            <?php else: ?>
            <div id="articuls_<?php echo $pnc->getCode(); ?>" class="hidden"></div>
            <?php endif; ?>

            <script>
                $("#pnc_<?php echo $pnc->getCode(); ?>").on('mouseover', function(){
                    $(this).css('cursor', 'pointer');
                });
                $("#pnc_<?php echo $pnc->getCode(); ?>").on('click', function(){
                    if(!$("#articuls_<?php echo $pnc->getCode(); ?>").text()){
                        $.ajax({
                            type:   'POST',
                            async:  false,
                            url:    "<?php echo Yii::app()->createUrl('findArticul/pncArticuls') ?>",
                            data:   { regionCode: "<?php echo $params['regionCode']; ?>", modificationCode: "<?php echo $params['modificationCode']; ?>", pncCode: "<?php echo $pnc->getCode(); ?>", complectationCode: "<?php echo (string) $params['complectationCode']; ?>" },
                            success: function(data) {
                                $("#articuls_<?php echo $pnc->getCode(); ?>").html(data);
                            }
                        });
                    }
                    $("#articuls_<?php echo $pnc->getCode(); ?>").toggleClass('hidden');
                });
            </script>
        <?php endforeach; ?>
        <?php if(!empty($commonArticuls)): ?>
            <h4>Общие запчасти:</h4>
            <?php foreach($commonArticuls as $commonArticul): ?>
                <?php if($commonArticul->getCode() == $oContainer->getActiveArticul()->getCode()): ?>
                    <strong><?php echo $commonArticul->getRuname(); ?></strong><br/>
                <?php else: ?>
                    <?php echo $commonArticul->getRuname(); ?><br/>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if(!empty($refGroups)): ?>
            <h4>Ссылки на группы:</h4>
            <?php foreach($refGroups as $refGroup): ?>
                <?php echo $refGroup->getRuname() ?><br/>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="col-lg-8">
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
                          href="#<?php echo $schemaCode.$pnc->getCode(); ?>" id="area<?php echo $schemaCode.$pnc->getCode() ?>" data-name="<?php echo $pnc->getCode() ?>">
                <?php endforeach; ?>

                <?php if(!empty($commonArticuls)): ?>
                    <?php foreach($commonArticuls as $commonArticul): ?>
                        <area shape="rect" coords="<?php echo $commonArticul->getOption(Functions::X1).','.$commonArticul->getOption(Functions::Y1).','.$commonArticul->getOption(Functions::X2).','.$commonArticul->getOption(Functions::Y2); ?>"
                              href="#<?php echo $schemaCode.$commonArticul->getCode(); ?>" id="area<?php echo $schemaCode.$commonArticul->getCode() ?>" data-name="<?php echo $commonArticul->getCode() ?>">
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if(!empty($refGroups)): ?>
                    <?php foreach($refGroups as $refGroup): ?>
                        <area shape="rect" coords="<?php echo $refGroup->getOption(Functions::X1).','.$refGroup->getOption(Functions::Y1).','.$refGroup->getOption(Functions::X2).','.$refGroup->getOption(Functions::Y2); ?>"
                              href="#<?php echo $schemaCode.$refGroup->getCode(); ?>" id="area<?php echo $schemaCode.$refGroup->getCode() ?>" data-name="<?php echo $refGroup->getCode() ?>">
                    <?php endforeach; ?>
                <?php endif; ?>

            </map>
        <?php endif; ?>
    </div>
</div>
<script>
    $('img').mapster({
        fillColor: '70daf1',
        fillOpacity: 0.3,
        mapKey: 'data-name',
        clickNavigate: true
    }).mapster('set', true, '<?php echo implode(", ", $oContainer->getActivePnc()->getCollectionCodes()); ?>');
</script>



