<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 05.12.14
 * Time: 14:43
 */

class FindArticul {
    private $articul;
    private $regions = array();
    private $activeRegion;
    private $activeModel;
    private $activeModificataion;
    private $activeComplectation;
    private $options;

    private $findArticulModel;

    public function __construct($articul)
    {
        $this->findArticulModel = new FindArticulModel();

        $this->articul = $articul;

    }

    public function setRegions($regions=array())
    {
        foreach($regions as $code=>$region){
            $oRegion = new Region($code);
            $oRegion->setName($region);
            $this->regions[] = $oRegion;
        }
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
    }

    public function getActiveRegion()
    {
        return $this->activeRegion;
    }

} 