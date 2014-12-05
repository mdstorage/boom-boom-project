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

    public function __construct($articul, $region = null)
    {
        $this->articul = $articul;
        $this->setRegions();

        if (!is_null($region)){
            $this->setActiveRegion($region);
        } else {
            $this->setActiveRegion($this->regions[0]);
        }
    }

    public function setRegions()
    {
        $oModel = new FindArticulModel();
        foreach($oModel->getRegions($this->articul) as $region){
            $this->regions[] = Yii::t(Yii::app()->params['translateDomain'], $region);
        }
    }

    public function getRegions()
    {
        return $this->regions;
    }

    public function setActiveRegion($region)
    {
        $oModel = new FindArticulModel();

        $oRegion = new Region();
        $oRegion->setCode($region);
        $oRegion->setName($region);
        $oRegion->setModels($oModel->getActiveRegion($this->articul, $region));

        $this->activeRegion = $oRegion;
    }

    public function getActiveRegion()
    {
        return $this->activeRegion;
    }
} 