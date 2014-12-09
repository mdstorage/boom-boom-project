<?php

class Schema implements SchemaInterface{

    private $name;
    private $picture;
    private $pncs;
    private $articuls;
    private $groups;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPncs($pncs)
    {
        $this->pncs = $pncs;
    }

    public function getPncs()
    {
        return $this->pncs;
    }

    public function setArticuls($articuls)
    {
        $this->articuls = $articuls;
    }

    public function getArticuls()
    {
        return $this->articuls;
    }

    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    public function getGroups()
    {
        return $this->groups;
    }
} 