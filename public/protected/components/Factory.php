<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 12.12.14
 * Time: 12:29
 */

class Factory {

    public static function createContainer($articul=null)
    {
        $oContainer = new Container();
        if($articul){
            $oContainer->setArticul($articul);
        }

        return $oContainer;
    }

    public static function createRegion($code=null, $name=null, $models=array())
    {
        $oRegion = new Region();
        self::setCodeName($oRegion, $code, $name);
        if(!empty($models)){
            $oRegion->setModels($models, self::createModel());
        }

        return $oRegion;
    }

    public static function createModel($code=null, $name=null, $modifications=array())
    {
        $oModel = new Model();
        self::setCodeName($oModel, $code, $name);
        if(!empty($modifications)){
            $oModel->setModifications($modifications, self::createModification());
        }

        return $oModel;
    }

    public static function createModification($code=null, $name=null, $complectations=array())
    {
        $oModification = new Modification();

        self::setCodeName($oModification, $code, $name);
        if(!empty($complectations)){
            $oModification->setComplectations($complectations, self::createComplectation());
        }

        return $oModification;
    }

    public static function createComplectation($code=null, $name=null)
    {
        $oComplectation = new Complectation();
        self::setCodeName($oComplectation, $code, $name);

        return $oComplectation;
    }

    public static function createGroup($code=null, $name=null)
    {
        $oGroup = new Group();
        self::setCodeName($oGroup, $code, $name);

        return $oGroup;
    }

    public static function createSchema($code=null, $name=null)
    {
        $oSchema = new Schema();
        self::setCodeName($oSchema, $code, $name);

        return $oSchema;
    }

    public static function createPnc($code=null, $name=null)
    {
        $oPnc = new Pnc();
        self::setCodeName($oPnc, $code, $name);

        return $oPnc;
    }

    public static function createArticul($code=null, $name=null)
    {
        $oArticul = new Articul();
        self::setCodeName($oArticul, $code, $name);

        return $oArticul;
    }

    private function setCodeName(CodeNameInterface $object, $code=null, $name=null)
    {
        if($code){
            $object->setCode($code);
        }
        if($name){
            $object->setName($name);
        }
    }
} 