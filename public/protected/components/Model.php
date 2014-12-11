<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 05.12.14
 * Time: 16:24
 */

class Model implements ModelInterface{
    use CodeNameTrait;

    private $region;
    private $modifications;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function setRegion(Region $region)
    {
        $this->region = $region;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setModifications($modifications)
    {
        foreach($modifications as $code=>$data){
            $oModification = new Modification();
            $oModification->setCode($code);
            $oModification->setName($data['name']);
            $oModification->setOptions($data['options']);
            $this->modifications[] = $oModification;
        }
    }

    public function getModifications()
    {
        return $this->modifications;
    }
} 