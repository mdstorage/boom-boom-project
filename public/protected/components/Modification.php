<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 06.12.14
 * Time: 19:21
 */

class Modification implements ModificationInterface{

    private $code;
    private $name;

    private $classifications;
    private $options;

    public function __construct()
    {
        $this->options = new Options();
    }

    public function setOptions($options=array())
    {
        foreach($options as $name=>$value){
            $this->options->setOption($name, $value);
        }
    }

    public function addOption($name, $value)
    {
        $this->options->setOption($name, $value);
    }

    public function getOptions()
    {
        return $this->options->getOptions();
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }

} 