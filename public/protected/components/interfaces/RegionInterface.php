<?php
interface RegionInterface extends CodeNameInterface
{
    public function setModels($models, ModelInterface $modelClass);
    public function addModel(ModelInterface $model);
}