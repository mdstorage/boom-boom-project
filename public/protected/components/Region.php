<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 05.12.14
 * Time: 14:29
 */

class Region implements RegionInterface{
    private $code;
    private $name;
    private $runame;

    private $models = array();

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setName($name)
    {
        $this->name = $name;
        $this->setRuname();
    }

    private function setRuname()
    {
        $this->runame = Yii::t(Yii::app()->params['translateDomain'], $this->name);
    }

    public function setModels($models=array())
    {
        foreach($models as $code=>$model) {
            $oModel = new Model($code);
            $oModel->setName($model);
            $this->addModel($oModel);
        }
    }

    public function getModels()
    {
        return $this->models;
    }

    public function getRuname()
    {
        return $this->runame;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function addModel(ModelInterface $model)
    {
        $this->models[] = $model;
    }
} 