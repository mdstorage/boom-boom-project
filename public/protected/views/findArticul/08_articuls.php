<table class="table" id="<?php echo $oContainer->getActivePnc()->getCode(); ?>">
<?php foreach($oContainer->getActivePnc()->getArticuls() as $articul): ?>
    <tr>
        <td><?php echo $articul->getCode(); ?></td>
        <?php foreach($articul->getOptions() as $name=>$value): ?>
            <td><?php echo $value; ?></td>
        <?php endforeach; ?>
    </tr>
<?php endforeach; ?>
</table>
