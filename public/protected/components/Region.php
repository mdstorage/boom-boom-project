<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 05.12.14
 * Time: 14:29
 */

class Region implements RegionInterface{
    use CodeNameTrait;

    private $models = array();


    public function setModels($models=array(), ModelInterface $modelClass)
    {
        $this->models = $this->setChildrens($models, $modelClass);

        return $this;
    }

    public function getModels()
    {
        return $this->models;
    }

    public function addModel(ModelInterface $model)
    {
        $this->models[] = $model;

        return $this;
    }
} 