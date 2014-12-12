<table class="table table-responsive">
<?php foreach($oContainer->getActiveModel()->getModifications() as $modification): ?>

    <tr>
        <td><a href="<?php echo Yii::app()->createUrl('findArticul/complectations', array('regionCode'=>$oContainer->getActiveRegion()->getCode(), 'articul'=>$oContainer->getArticul(), 'modificationCode'=>$modification->getCode())); ?>"><?php echo $modification->getCode(); ?></a></td>
        <td><?php echo $modification->getRuname(); ?></td>
        <?php foreach($modification->getOptions() as $name=>$value): ?>
            <td><?php echo $value; ?></td>
        <?php endforeach; ?>
    </tr>

<?php endforeach; ?>
</table>