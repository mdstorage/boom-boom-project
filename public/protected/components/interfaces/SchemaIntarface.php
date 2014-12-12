<?php
interface SchemaInterface extends CodeNameInterface
{
    public function setPicture($picture);
    public function getPicture();

    public function setPncs($pncs);
    public function getPncs();

    public function setArticuls($articuls);
    public function getArticuls();

    public function setGroups($groups);
    public function getGroups();
}