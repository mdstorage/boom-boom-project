<?php

class Schema implements SchemaInterface{
    use CodeNameTrait;

    private $pncs = array();
    private $commonArticuls = array();
    private $refGroups = array();

    public function setPncs($pncs, PncInterface $pncClass)
    {
        $this->pncs = $this->setChildrens($pncs, $pncClass);

        return $this;
    }

    public function getPncs()
    {
        return $this->pncs;
    }

    public function setCommonArticuls($articuls, ArticulInterface $articulClass)
    {

        $this->commonArticuls = $this->setChildrens($articuls, $articulClass);

        return $this;
    }

    public function getCommonArticuls()
    {
        return $this->commonArticuls;
    }

    public function setRefGroups($groups, GroupInterface $groupClass)
    {
        $this->refGroups = $this->setChildrens($groups, $groupClass);

        return $this;
    }

    public function getRefGroups()
    {
        return $this->refGroups;
    }

    public function setActivePncs($code)
    {
        foreach($this->pncs as $pnc){
            if($code == $pnc->getCode()){
                $pnc->onActive();
            }
        }
    }

    public function getActivePncs(){

        $activePncs = array();

        foreach($this->pncs as $pnc){
            if($pnc->isActive()){
                $activePncs[$pnc->getCode()] = $pnc;
            }
        }

        return $activePncs;
    }
} 