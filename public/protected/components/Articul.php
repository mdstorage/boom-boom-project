<?php

class Articul implements ArticulInterface{
    use CodeNameTrait;

    private $pncs;

    public function setPncs($pncs, PncInterface $pncClass)
    {
        $this->pncs -> $this->setChildrens($pncs, $pncClass);

        return $this;
    }

    public function getPncs()
    {
        return $this->pncs;
    }
} 