<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 05.12.14
 * Time: 14:48
 */

class FindArticulModel {
    public static function getRegions($articul)
    {
        $sql = "SELECT prtcds.catalog FROM part_codes prtcds WHERE prtcds.pnc = :articul GROUP BY prtcds.catalog";
        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":articul", $articul)
            ->queryAll();

        $regions = array();
        foreach($aData as $item){
            $regions[$item['catalog']] = array('name'=>$item['catalog'], 'options'=>array());
        }

        return $regions;
    }

    public static function getActiveRegionModels($articul, $region)
    {
        $sql = "SELECT m.model_name FROM part_codes LEFT JOIN models m ON (m.catalog = part_codes.catalog AND m.catalog_code = part_codes.catalog_code) WHERE part_codes.pnc = :articul AND part_codes.catalog = :region GROUP BY m.model_name";
        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":articul", $articul)
            ->bindParam(":region", $region)
            ->queryAll();

        $models = array();
        foreach($aData as $item){
            $models[] = array('name'=>$item['model_name'], 'options'=>array());
        }

        return $models;
    }

    public static function getActiveModelModifications($articul, $region, $model)
    {
        $sql = "SELECT m.add_codes, m.catalog_code, m.prod_start, m.prod_end FROM part_codes LEFT JOIN models m ON (m.catalog = part_codes.catalog AND m.catalog_code = part_codes.catalog_code) WHERE part_codes.pnc = :articul AND part_codes.catalog = :region AND m.model_name = :model";
        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":articul", $articul)
            ->bindParam(":region", $region)
            ->bindParam(":model", $model)
            ->queryAll();

        $modifications = array();
        foreach($aData as $item){
            $modifications[$item['catalog_code']] = array('name'=>$item['add_codes'], 'options'=>array('prod_start'=>$item['prod_start'], 'prod_end'=>$item['prod_end']));
        }

        return $modifications;
    }

    public static function getComplectations($modificationCode, $regionCode)
    {
        $sql = "SELECT c.model_code, c.prod_start, c.prod_end, c.complectation_code, c.engine1
                FROM complectations c
                WHERE c.catalog = :regionCode AND c.catalog_code = :modificationCode
        ";

        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":regionCode", $regionCode)
            ->bindParam(":modificationCode", $modificationCode)
            ->queryAll();

        $complectations = array();
        foreach($aData as $item){
            $complectations[$item['complectation_code']] = array('name'=>$item['model_code'], 'options'=>array(
                'prod_start'=>$item['prod_start'],
                'prod_end'  =>$item['prod_end'],
                'engine'    =>$item['engine1']
            ));
        }

        return $complectations;
    }

    public static function getArticulModificationGroups($articul, $modificationCode, $regionCode)
    {
        $sql = "SELECT prtcds.part_code as part_group
                FROM part_codes prtcds
                WHERE prtcds.pnc = :articul AND prtcds.catalog_code = :modificationCode AND prtcds.catalog = :regionCode";

        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":articul", $articul)
            ->bindParam(":regionCode", $regionCode)
            ->bindParam(":modificationCode", $modificationCode)
            ->queryAll();

        $groups = array();
        foreach($aData as $item){
            $groups[Functions::getGroupNumberBySubGroup($item['part_group'])] = array('name'=>Functions::getGroupName(Functions::getGroupNumberBySubGroup($item['part_group'])), 'options'=>array());
        }

        return $groups;
    }

    public static function getArticulModificationSubGroups($articul, $modificationCode, $regionCode, $groupNumber)
    {
        $sql = "SELECT prtcds.part_code as part_group, part_groups.desc_en, pg_header_pics.pic_code
                FROM part_codes prtcds
                LEFT JOIN part_groups ON part_groups.group_id = prtcds.part_code
                LEFT JOIN pg_header_pics ON prtcds.part_code = pg_header_pics.part_group AND prtcds.catalog = pg_header_pics.catalog AND prtcds.catalog_code = pg_header_pics.catalog_code
                WHERE prtcds.pnc = :articul AND prtcds.catalog_code = :modificationCode AND SUBSTRING(prtcds.part_code, 1, 1) IN ". Functions::getSubGroupsByGroupNumber($groupNumber) ." AND part_groups.catalog = :regionCode";

        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":articul", $articul)
            ->bindParam(":regionCode", $regionCode)
            ->bindParam(":modificationCode", $modificationCode)
            ->queryAll();

        $groups = array();
        foreach($aData as $item){
            $groups[$item['part_group']] = array('name'=>$item['desc_en'], 'options'=>array('picture'=>$item['pic_code']));
        }

        return $groups;
    }
} 