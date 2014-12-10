<table class="table table-responsive">
<?php foreach($oModel->getModifications() as $modification): ?>

    <tr>
        <td><a href="<?php echo Yii::app()->createUrl('findArticul/articulModificationGroups', array('regionCode'=>$oModel->getRegion()->getCode(), 'articul'=>$articul, 'modificationCode'=>$modification->getCode())); ?>"><?php echo $modification->getCode(); ?></a></td>
        <td><?php echo $modification->getName(); ?></td>
        <?php foreach($modification->getOptions() as $name=>$value): ?>
            <td><?php echo $value; ?></td>
        <?php endforeach; ?>
    </tr>

<?php endforeach; ?>
</table>