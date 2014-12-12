<?php $this->pageTitle = "Выберите группу запчастей" ?>
<?php foreach ($oContainer->getGroups() as $group): ?>
    <a href="<?php echo Yii::app()->createUrl('findArticul/articulGroupSubGroups', array_merge($params, array('groupCode'=>$group->getCode()))); ?>"><?php echo $group->getRuname(); ?></a><br/>
<?php endforeach; ?>