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
    public $options;

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

    public function setModifications()
    {
        $oFindArticulModel = new FindArticulModel();

        if($this->options->hasOption('articul') && $this->options->hasOption('region') && $this->options->hasOption('model')){
            $modifications = $oFindArticulModel->getActiveModelModifications($this->options->getOption('articul'), $this->options->getOption('region'), $this->options->getOption('model'));
            foreach($modifications as $code=>$name){
                $oModification = new Modification();
                $oModification->setCode($code);
                $oModification->setName($name);
                $this->modifications[] = $oModification;
            }
        }
    }

    public function getModifications()
    {
        return $this->modifications;
    }
} 