<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 05.12.14
 * Time: 16:24
 */

class Model {
    private $code;
    private $name;
    private $region;

    private $modifications;
    public $options;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function setOptions($options=array())
    {
        $this->options = new Options();
        foreach($options as $name=>$value){
            $this->options->setOption($name, $value);
        }
    }

    public function getCode()
    {
       return $this->code;
    }

    public function setRegion(Region $region)
    {
        $this->region = $region;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setModifications()
    {
        $oFindArticulModel = new FindArticulModel();

        if($this->options->hasOption('articul') && $this->getRegion()->getCode() && $this->getCode()){
            $modifications = $oFindArticulModel->getActiveModelModifications($this->options->getOption('articul'), $this->getRegion()->getCode(), $this->getCode());
            foreach($modifications as $code=>$name){
                $oModification = new Modification();
                $oModification->setCode($code);
                $oModification->setName($name);
                $this->modifications[] = $oModification;
            }
        }
    }

    public function getModifications()
    {
        return $this->modifications;
    }
} 