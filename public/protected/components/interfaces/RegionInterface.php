<?php
interface RegionInterface
{
    public function setCode($code);
    public function getCode();

    public function setName($name);
    public function getRuname();

    public function setModels($models);
    public function addModel(ModelInterface $model);
}