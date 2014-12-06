<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 05.12.14
 * Time: 14:48
 */

class FindArticulModel {
    public function getRegions($articul)
    {
        $sql = "SELECT prtcds.catalog FROM part_codes prtcds WHERE prtcds.pnc = :articul GROUP BY prtcds.catalog";
        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":articul", $articul)
            ->queryAll();

        $regions = array();
        foreach($aData as $item){
            $regions[$item['catalog']] = $item['catalog'];
        }

        return $regions;
    }

    public function getActiveRegionModels($articul, $region)
    {
        $sql = "SELECT m.model_name FROM part_codes LEFT JOIN models m ON (m.catalog = part_codes.catalog AND m.catalog_code = part_codes.catalog_code) WHERE part_codes.pnc = :articul AND part_codes.catalog = :region GROUP BY m.model_name";
        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":articul", $articul)
            ->bindParam(":region", $region)
            ->queryAll();

        $models = array();
        foreach($aData as $item){
            $models[] = $item['model_name'];
        }

        return $models;
    }
} 