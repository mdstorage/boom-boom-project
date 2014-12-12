<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 10.12.14
 * Time: 15:35
 */

trait CodeNameTrait {
    private $code;
    private $name;
    private $runame;

    private $options;

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setName($name)
    {
        $this->name = $name;
        $this->setRuname();
    }

    private function setRuname()
    {
        $this->runame = Yii::t(Yii::app()->params['translateDomain'], $this->name);
    }

    public function getRuname()
    {
        return $this->runame;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setOptions($options=array())
    {
        foreach($options as $name=>$value){
            $this->addOption($name, $value);
        }
    }

    public function addOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function hasOption($name)
    {
        if($this->options[$name]){
            return true;
        } else {
            return false;
        }
    }

    public function getOption($name)
    {
        if($this->hasOption($name)){
            return $this->options[$name];
        }
    }

    public function getOptions()
    {
        return $this->options;
    }

    protected function setChildrens($childrens, $class)
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