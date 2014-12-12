<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 06.12.14
 * Time: 19:21
 */

class Modification implements ModificationInterface{
    use CodeNameTrait;

    private $complectations;

    public function __construct()
    {
    }

    public function setComplectations($complectations, ComplectationInterface $complectationClass)
    {
        $this->setChildrens($complectations, $complectationClass, $this->complectations);
        return $this;
    }

    public function getModifications()
    {
        return $this->complectations;
    }
} 