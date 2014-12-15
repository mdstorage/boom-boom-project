<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 15.12.14
 * Time: 11:06
 */

class Pnc implements PncInterface{
    use CodeNameTrait;

    private $articuls=array();

    public function setArticuls($articuls, ArticulInterface $articulClass)
    {
        $this->articuls = $this->setChildrens($articuls, $articulClass);

        return $this;
    }

    public function getArticuls()
    {
        return $this->articuls;
    }
} 