<?php

class Group implements GroupInterface{
    use CodeNameTrait;

    private $parent;
    private $subgroups;

    public function setSubGroups($subgroups=array())
    {
        foreach($subgroups as $code=>$data){
            $oGroup = new Group();
            $oGroup->setCode($code);
            $oGroup->setName($data['name']);
            $oGroup->setOptions($data['options']);
            $this->subgroups[] = $oGroup;
        }
    }

    public function getSubGroups()
    {
        return $this->subgroups;
    }


} 