<?php

class Schema implements SchemaInterface{
    use CodeNameTrait;

    private $pncs;
    private $articuls;
    private $groups;

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