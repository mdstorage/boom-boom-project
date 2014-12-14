<?php

trait ChildrensTrait {
    private function setChildrens($childrens, $class)
    {
        $property = array();
        foreach($childrens as $code=>$data){
            $oObject = clone $class;
            if($code){
                $oObject->setCode($code);
            }
            if(isset($data['name'])){
                $oObject->setName($data['name']);
            }
            if(isset($data['options'])){
                $oObject->setOptions($data['options']);
            }
            $property[] = $oObject;
        }

        return $property;
    }
} 