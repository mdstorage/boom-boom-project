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

    public function __construct($articul, $region = null)
    {
        $this->articul = $articul;
        $this->setRegions();

        if (!is_null($region)){
            $this->setActiveRegion($region);
        } elseif($this->regions) {
            $this->setActiveRegion($this->regions[0]->getCode());
        }
    }

    public function setRegions()
    {
        $oModel = new FindArticulModel();
        $regions = $oModel->getRegions($this->articul);
        if(empty($regions)){
            throw new CHttpException("Запчасть с артикулом " .$this->articul. " отсутствует в каталоге.");
        } else {
            foreach($regions as $code=>$region){
                $oRegion = new Region();
                $oRegion->setCode($code);
                $oRegion->setName($region);
                $this->regions[] = $oRegion;
            }
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

    public function setActiveRegion($region)
    {
        $oModel = new FindArticulModel();

        $oRegion = new Region();
        $oRegion->setCode($region);
        $oRegion->setName($region);

        $models = $oModel->getActiveRegionModels($this->articul, $region);

        if(empty($models)){
            throw new CHttpException("Ошибка в выборе моделей для региона: " . $oRegion->getRuname());
        } else {
            foreach($models as $code=>$model) {
                $oModel = new Model();
                $oModel->setCode($code);
                $oModel->setName($model);
                $oRegion->addModel($oModel);
            }
        }


        $this->activeRegion = $oRegion;
    }

    public function getActiveRegion()
    {
        return $this->activeRegion;
    }

    public function setActiveModel()
    {

    }
} 