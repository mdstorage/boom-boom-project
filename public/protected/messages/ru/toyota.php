<?php

use Symfony\Component\Yaml\Yaml;
Yii::setPathOfAlias('Symfony',Yii::getPathOfAlias('application.vendor.Symfony'));

$array = Yaml::parse(file_get_contents(__DIR__.'/toyota.yml'));
//VarExport::getExport($array);

//return array(
//    //стандартные инструменты
//    'STANDARD TOOL'=>'СТАНДАРТНЫЕ ИНСТРУМЕНТЫ',
//
//    //двигатель
//    'STARTER'=>'СТАРТЕР',
//
//    'EU'=>'Европа',
//    'GR'=>'Общий',
//    'US'=>'США',
//    'JP'=>'Япония'
//);

return $array;