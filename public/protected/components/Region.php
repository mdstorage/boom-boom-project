<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 05.12.14
 * Time: 14:29
 */

class Region {
    private $code;
    private $name;
    private $runame;

    private $models = array();

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
        $this->runame = Yii::t("toyota", $this->name);
    }

    public function setModels($models)
    {
        $this->models = $models;
    }

    public function getModels()
    {
        return $this->models;
    }
} 