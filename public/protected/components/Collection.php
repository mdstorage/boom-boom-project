<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 07.12.14
 * Time: 12:34
 */

class Collection {
    use ChildrensTrait;
    private $collection;

    public function setCollection($collection, CodeNameInterface $object)
    {
        $this->collection = $this->setChildrens($collection, $object);
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function getCollectionCodes()
    {
        $codes = array();
        foreach($this->collection as $item){
            $codes[] = $item->getCode();
        }

        return $codes;
    }

    public function getCollectionItem($code)
    {
        foreach($this->collection as $item){
            if($code === $item->getCode()){
                return $item;
            }
        }
    }
} 