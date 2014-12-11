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
        $this->options = new Options();
        foreach($options as $name=>$value){
            $this->options->setOption($name, $value);
        }
    }

    public function getOptions()
    {
        return $this->options;
    }
} 