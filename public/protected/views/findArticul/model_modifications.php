<table class="table table-responsive">
<?php foreach($oModel->getModifications() as $modification): ?>
    <tr>
        <td><?php echo $modification->getCode(); ?></td>
        <td><?php echo $modification->getName(); ?></td>
    </tr>
<?php endforeach; ?>
</table>