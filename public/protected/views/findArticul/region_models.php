<?php foreach($oFindArticul->getRegions() as $region): ?>
    <?php echo $region; ?><br/>
<?php endforeach; ?>

<?php foreach($oFindArticul->getActiveRegion()->getModels() as $model): ?>
    <?php echo $model; ?>
<?php endforeach; ?>