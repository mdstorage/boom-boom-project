<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 05.12.14
 * Time: 16:24
 */

class Model implements ModelInterface{
    use CodeNameTrait;

    private $modifications;

    public function __construct()
    {
    }

    public function setModifications($modifications, ModificationInterface $modificationClass)
    {
        $this->modifications = $this->setChildrens($modifications, $modificationClass);

        return $this;
    }

    public function getModifications()
    {
        return $this->modifications;
    }
} 