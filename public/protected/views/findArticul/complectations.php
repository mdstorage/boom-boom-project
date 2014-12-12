<?php foreach($oContainer->getActiveModification()->getComplectations() as $complectation): ?>
    <a href=""><?php echo $complectation->getRuname(); ?></a><br/>
<?php endforeach; ?>