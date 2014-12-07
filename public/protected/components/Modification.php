<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 06.12.14
 * Time: 19:21
 */

class Modification {

    private $code;
    private $name;

    private $classifications;
    private $options;

    private $region;
    private $model;

    public function __construct($options=array())
    {
        $this->options = new Options();
        foreach($options as $name=>$value){
            $this->options->setOption($name, $value);
        }
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