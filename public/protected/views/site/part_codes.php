<?php if (!empty($aPncs)) :?>
    <?php $groupName = Functions::getGroupName($groupNumber);
    $this->breadcrumbs = array(
        $sCatalog=>array('site/modelnames', 'catalog'=>$sCatalog),
        $sModelName=>array(
            'site/modelcodes', 'catalog'=>$sCatalog, 'cd'=>$sCd, 'catalogCode'=>$sCatalogCode, 'modelName'=>$sModelName
        ),
        $sModelCode=>array(
            'site/groups', 'catalog'=>$sCatalog, 'cd'=>$sCd, 'catalogCode'=>$sCatalogCode, 'modelName'=>$sModelName, 'modelCode'=>$sModelCode
        ),
        $groupName=>array(
            'site/subgroups', 'catalog'=>$sCatalog, 'cd'=>$sCd, 'catalogCode'=>$sCatalogCode, 'modelName'=>$sModelName, 'modelCode'=>$sModelCode, 'groupNumber'=>$groupNumber
        ),
        $sPartGroupDescEn
    );?>

    <table class="table">
        <tr>
            <td class="active"><b>Выбрать запчасть</b></td>
        </tr>
    </table>

    <?php foreach ($aPgPictures as $aPgPicture): ?>

        <?php $width = Yii::app()->params['imageWidth']; ?>
        <div class="row">
        <?php if(file_exists(Yii::app()->basePath . '/../images/' .
            $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
            '/' . $aPgPicture['pic_code'] . '.png')): ?>
            <?php $size = getimagesize(Yii::app()->basePath . '/../images/' .
                $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
                '/' . $aPgPicture['pic_code'] . '.png');

            $k = $size[1]/$size[0];
 /*
 * коэффициент $kc нужен, если не используется imagemapster
  * $kc = $width/$size[0];
 */
            $kc=1;
            $height = $width * $k; ?>


                <div class="col-sm-7">
                    <?php echo CHtml::image(
                        Yii::app()->request->baseUrl.'/images/' .
                        $sCatalog . '/images_' . strtolower($sCatalog) . '_' . strtolower($sCd) .
                        '/' . $aPgPicture['pic_code'] . '.png',
                        $aPgPicture['pic_code'],
                        array("width"=>$width, "usemap"=>'#' . $aPgPicture['pic_code'])); ?>

                    <map name= <?php echo $aPgPicture['pic_code']; ?> >

                    <?php foreach($aPgPicture['pncs'] as $aPncCoords): ?>
                        <area shape="rect" coords="<?php echo $aPncCoords['x1']*$kc.','.$aPncCoords['y1']*$kc.','.$aPncCoords['x2']*$kc.','.$aPncCoords['y2']*$kc; ?>"
                        href="#<?php echo $aPgPicture['pic_code'].$aPncCoords['label2']; ?>" id="area<?php echo $aPgPicture['pic_code'].$aPncCoords['label2'] ?>" data-name="<?php echo $aPgPicture['pic_code'].$aPncCoords['label2'] ?>">

                    <?php endforeach; ?>

                    <?php foreach($aPgPicture['general'] as $aPncCoords): ?>
                        <area shape="rect" coords="<?php echo $aPncCoords['x1']*$kc.','.$aPncCoords['y1']*$kc.','.$aPncCoords['x2']*$kc.','.$aPncCoords['y2']*$kc; ?>"
                              href="#<?php echo $aPgPicture['pic_code'].$aPncCoords['label2']; ?>" id="area<?php echo $aPgPicture['pic_code'].$aPncCoords['label2'] ?>" data-name="<?php echo $aPgPicture['pic_code'].$aPncCoords['label2'] ?>">
                    <?php endforeach; ?>

                    <?php foreach($aPgPicture['groups'] as $aPncCoords): ?>
                        <area shape="rect" coords="<?php echo $aPncCoords['x1']*$kc.','.$aPncCoords['y1']*$kc.','.$aPncCoords['x2']*$kc.','.$aPncCoords['y2']*$kc; ?>"
                              href="<?php echo Yii::app()->createUrl('site/schemas', array(
                                  'site/schemas',
                                  'catalog'=>$sCatalog,
                                  'cd'=>$sCd,
                                  'catalogCode'=>$sCatalogCode,
                                  'modelName'=>$sModelName,
                                  'modelCode'=>$sModelCode,
                                  'groupNumber'=>$groupNumber,
                                  'partGroup'=>$aPncCoords['label2']
                              )); ?>" id="area<?php echo $aPncCoords['x1'].$aPgPicture['pic_code'].$aPncCoords['label2'] ?> " data-name="<?php echo $aPgPicture['pic_code'].$aPncCoords['label2'] ?>">
                    <?php endforeach; ?>

                    </map><br/>

                </div>
        <?php endif; ?>

       <div class="col-sm-5">
        <?php foreach ($aPgPicture['pncs'] as $aPnc): ?>
            <?php if(in_array($aPnc['label2'], $aPgPicture['pnc_list'])): ?>
                <a name=<?php echo $aPgPicture['pic_code'] . $aPnc['label2']; ?>></a><div class="btn-default" id="pncs_<?php echo $aPgPicture['pic_code'] . $aPnc['label2']; ?>"><?php echo $aPnc['label2'] . " " . $aPnc['desc_en']; ?></div><br/>
                <table id="table_<?php echo $aPgPicture['pic_code'] . $aPnc['label2']; ?>" class="hidden table table-striped table-bordered">
                <thead>
                <td>Код</td>
                <td>Период выпуска</td>
                <td>Количество</td>
                <td>Применяемость</td>
              </thead><tbody>
                <?php foreach($aPartCatalog[$aPnc['label2']] as $aPartCode): ?>
                    <tr>
                    <td><a href=<?php echo Yii::app()->params['outUrl'] . $aPartCode['part_code'] . ' target="_blank" >' . $aPartCode['part_code']; ?></a></td>
                    <td><?php echo Functions::prodToDate($aPartCode['start_date']) . ' - ' . Functions::prodToDate($aPartCode['end_date']); ?></td>
                    <td><?php echo $aPartCode['quantity']; ?></td>
                    <td><?php echo Functions::getString($aPartCode['add_desc']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody></table>

                    <script>
                        $("#pncs_<?php echo $aPgPicture['pic_code'] . $aPnc['label2']; ?>").on("mouseover", function(){
                            $(this).css("cursor", "pointer");
                        });
                        $("#pncs_<?php echo $aPgPicture['pic_code'] . $aPnc['label2']; ?>").on("click", function(){
                            $("#table_<?php echo $aPgPicture['pic_code'] . $aPnc['label2']; ?>").toggleClass("hidden");
                            $(this).removeClass("btn-warning btn-info");
                            $(this).toggleClass("btn-success");
                        });
                        $("area#area<?php echo $aPgPicture['pic_code'] . $aPnc['label2']; ?>").on("click", function(){
                            $("#pncs_<?php echo $aPgPicture['pic_code'] . $aPnc['label2']; ?>").removeClass("btn-info");
                            $("#pncs_<?php echo $aPgPicture['pic_code'] . $aPnc['label2']; ?>").toggleClass("btn-warning");
                        });
                        $("area#area<?php echo $aPgPicture['pic_code'] . $aPnc['label2']; ?>").on("mouseover", function(){

                            $("#pncs_<?php echo $aPgPicture['pic_code'] . $aPnc['label2']; ?>").addClass("btn-info");
                        });
                        $("area#area<?php echo $aPgPicture['pic_code'] . $aPnc['label2']; ?>").on("mouseout", function(){
                            $("#pncs_<?php echo $aPgPicture['pic_code'] . $aPnc['label2']; ?>").removeClass("btn-info");
                        });
                    </script>
            <?php endif; ?>

            <?php unset($aPgPicture['pnc_list'][$aPnc['label2']]); ?>

        <?php endforeach; ?>
        <?php if($aPgPicture['general']): ?>
            Стандартные запчасти:<br/>
            <?php foreach($aPgPicture['general'] as $aPartCode): ?>
                <?php $aPartCodes[$aPartCode['label2']] = $aPartCode; ?>
            <?php endforeach; ?>
            <?php foreach($aPartCodes as $aPartCode): ?>
                <a name=<?php echo $aPgPicture['pic_code']  . $aPartCode['label2']; ?>></a>
                <a href=<?php echo Yii::app()->params['outUrl'] . $aPartCode['label2']; ?> target="_blank" ><?php echo $aPartCode['label2'] . $aPartCode['desc_en'] ; ?></a><br/>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if($aPgPicture['groups_list']): ?>
            Связанные группы:<br/>
            <?php foreach($aPgPicture['groups_list'] as $aPartCode): ?>
                <a name=<?php echo $aPgPicture['pic_code'] . $aPartCode['label2']; ?>></a>
                <?php echo CHtml::link($aPartCode['label2'] . " " . $aPartCode['desc_en'], array(
                            'site/schemas',
                            'catalog'=>$sCatalog,
                            'cd'=>$sCd,
                            'catalogCode'=>$sCatalogCode,
                            'modelName'=>$sModelName,
                            'modelCode'=>$sModelCode,
                            'groupNumber'=>$groupNumber,
                            'partGroup'=>$aPartCode['label2']
                        )
                    ); ?><br/>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    </div>
    </div>

    <script>
        $('img').mapster({
            fillColor: '70daf1',
            fillOpacity: 0.3,
            mapKey: 'data-name',
            clickNavigate: true,
            scaleMap: true, //автоподстройка координат меток в зависимости от размеров изображения (по умолчанию true)
            staticState: true //подсвечивает все метки при загрузке
        });
    </script>
<?php endif; ?>