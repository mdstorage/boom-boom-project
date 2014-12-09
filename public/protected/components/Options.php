<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 07.12.14
 * Time: 12:34
 */

class Options {
    private $options;

    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function hasOption($name)
    {
        if($this->options[$name]){
            return true;
        } else {
            return false;
        }
    }

    public function getOption($name)
    {
        return $this->options[$name];
    }

    public function getOptions()
    {
        return $this->options;
    }
} 