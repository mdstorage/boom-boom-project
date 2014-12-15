<?php
interface SchemaInterface extends CodeNameInterface
{
    public function setPncs($pncs, PncInterface $pncClass);
    public function getPncs();

    public function setCommonArticuls($articuls, ArticulInterface $articulClass);
    public function getCommonArticuls();

    public function setRefGroups($groups, GroupInterface $groupClass);
    public function getRefGroups();
}