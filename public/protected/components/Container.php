<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 05.12.14
 * Time: 14:43
 */

class Container {
    private $articul;
    private $regions = array();
    private $activeRegion;
    private $activeModel;
    private $activeModificataion;
    private $activeComplectation;
    private $options;

    private $groups = array();
    private $activeGroup;

    public function __construct()
    {
    }

    public function setArticul($articul)
    {
        $this->articul = $articul;

        return $this;
    }

    public function setRegions($regions=array(), RegionInterface $regionClass)
    {
        $regionName = get_class($regionClass);
        foreach($regions as $code=>$data){
            $oRegion = clone $regionClass;
            $oRegion->setCode($code);
            $oRegion->setName($data['name']);

            $this->regions[] = $oRegion;
        }

        return $this;
    }

    public function getArticul()
    {
        return $this->articul;
    }

    public function getRegions()
    {
        return $this->regions;
    }

    public function setActiveRegion(RegionInterface $region)
    {
        $this->activeRegion = $region;

        return $this;
    }

    public function getActiveRegion()
    {
        return $this->activeRegion;
    }

    public function setGroups($groups=array())
    {
        foreach($groups as $code=>$data){
            $oGroup = new Group();
            $oGroup->setCode($code);
            $oGroup->setName($data['name']);
            $this->groups[] = $oGroup;
        }

        return $this;
    }

    public function getGroups()
    {
        return $this->groups;
    }

    public function setActiveGroup(GroupInterface $oGroup)
    {
        $this->activeGroup = $oGroup;

        return $this;
    }

    public function getActiveGroup()
    {
        return $this->activeGroup;
    }

    public function setActiveModification(ModificationInterface $oModification)
    {
        $this->activeModificataion = $oModification;

        return $this;
    }

    public function getActiveModification()
    {
        return $this->activeModificataion;
    }

    public function setActiveModel(ModelInterface $oModel)
    {
        $this->activeModel = $oModel;

        return $this;
    }

    public function getActiveModel()
    {
        return $this->activeModel;
    }
} 