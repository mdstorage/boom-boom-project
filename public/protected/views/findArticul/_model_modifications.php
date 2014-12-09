<table class="table table-responsive">
<?php foreach($oModel->getModifications() as $modification): ?>
    <tr>
        <td><?php echo $modification->getCode(); ?></td>
        <td><?php echo $modification->getName(); ?></td>
        <?php foreach($modification->getOptions() as $name=>$value): ?>
            <td><?php echo $value; ?></td>
        <?php endforeach; ?>
    </tr>
<?php endforeach; ?>
</table>