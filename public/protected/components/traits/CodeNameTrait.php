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
} 