<?php

trait ActiveTrait {

    private $active;

    public function onActive()
    {
        $this->active = true;
    }

    public function offActive()
    {
        $this->active = false;
    }

    public function isActive()
    {
        return $this->active;
    }

} 