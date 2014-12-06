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

    private $modifications;

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
       return $this->code;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
} 