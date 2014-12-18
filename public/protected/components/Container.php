<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 05.12.14
 * Time: 14:43
 */

class Container {
    use ChildrensTrait;

    private $regions = array();
    private $groups = array();
    private $schemas = array();
    private $options;

    private $activeRegion;
    private $activeModel;
    private $activeModificataion;
    private $activeComplectation;

    private $activeGroup;
    private $activeSchema;
    private $activePnc;
    private $activeArticul;

    public function __construct()
    {
    }

    public function setActiveArticul(ArticulInterface $articulClass)
    {
        $this->activeArticul = $articulClass;

        return $this;
    }

    public function setRegions($regions=array(), RegionInterface $regionClass)
    {
        $this->regions = $this->setChildrens($regions, $regionClass);

        return $this;
    }

    public function getActiveArticul()
    {
        return $this->activeArticul;
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

    public function setGroups($groups=array(), GroupInterface $groupClass)
    {

        $this->groups = $this->setChildrens($groups, $groupClass);

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

    public function setSchemas($schemas=array(), SchemaInterface $schemaClass)
    {
        $this->schemas = $this->setChildrens($schemas, $schemaClass);

        return $this;
    }

    public function getSchemas()
    {
        return $this->schemas;
    }

    public function setActiveSchema(SchemaInterface $oSchema)
    {
        $this->activeSchema = $oSchema;

        return $this;
    }

    public function getActiveSchema()
    {
        return $this->activeSchema;
    }

    public function setActivePnc($oPnc)
    {
        $this->activePnc = $oPnc;

        return $this;
    }

    public function getActivePnc()
    {
        return $this->activePnc;
    }
} 