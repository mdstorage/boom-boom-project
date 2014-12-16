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
            $regions[$item['catalog']] = array(Functions::NAME=>$item['catalog'], Functions::OPTIONS=>array());
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
            $modifications[$item['catalog_code']] = array('name'=>$item['add_codes'], 'options'=>array(
                Functions::PROD_START   =>$item['prod_start'],
                Functions::PROD_END     =>$item['prod_end']));
        }

        return $modifications;
    }

    public static function getModification($regionCode, $modificationCode)
    {
        $sql = "
        SELECT m.cd
        FROM models m
        WHERE m.catalog = :regionCode AND m.catalog_code = :modificationCode
        LIMIT 1
        ";

        $sData = Yii::app()->db->createCommand($sql)
            ->bindParam(":regionCode", $regionCode)
            ->bindParam(":modificationCode", $modificationCode)
            ->queryScalar();

        $modification = array();
        $modification[$modificationCode] = array('name'=>$modificationCode, 'options'=>array(Functions::CD => $sData));

        return $modification;
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
                Functions::PROD_START   =>$item['prod_start'],
                Functions::PROD_END     =>$item['prod_end'],
                'engine'                =>$item['engine1']
            ));
        }

        return $complectations;
    }

    public static function getGroups($articul, $modificationCode, $regionCode)
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

    public static function getComplectationDates($regionCode, $modificationCode, $complectationCode)
    {
        $sql = "
            SELECT c.prod_start, c.prod_end
            FROM complectations c
            WHERE c.catalog = :regionCode AND c.catalog_code = :modificationCode AND c.complectation_code = :complectationCode
            LIMIT 1
        ";

        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":complectationCode", $complectationCode)
            ->bindParam(":regionCode", $regionCode)
            ->bindParam(":modificationCode", $modificationCode)
            ->queryRow();

        return $aData;
    }

    public static function getSchemas($regionCode, $modificationCode, $subGroupCode, $complectationCode)
    {
        $aData = self::getComplectationDates($regionCode, $modificationCode, $complectationCode);

        $prod_start = $aData['prod_start'];
        $prod_end   = $aData['prod_end'];

        $sql = "
            SELECT pp.pic_code, pd.desc_en
            FROM pg_pictures pp
            LEFT JOIN pic_desc pd ON pp.pic_desc_code = pd.pic_num
            WHERE pp.catalog = :regionCode
                AND pp.catalog_code = :modificationCode
                AND pp.part_group = :subGroupCode
                AND (pp.start_date <= " . $prod_end . "
                OR pp.end_date >= " . $prod_start . ")
                AND pd.catalog = :regionCode
                AND pd.catalog_code = :modificationCode
        ";

        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":complectationCode", $complectationCode)
            ->bindParam(":regionCode", $regionCode)
            ->bindParam(":modificationCode", $modificationCode)
            ->bindParam(":subGroupCode", $subGroupCode)
            ->queryAll();

        $schemas = array();
        foreach($aData as $item){
            $schemas[$item['pic_code']] = array('name'=>$item['desc_en'], 'options'=>array());
        }

        return $schemas;
    }

    public static function getPnc($articul, $regionCode, $modificationCode, $subGroupCode)
    {
        $sql = "
            SELECT pc.part_group as pnc
            FROM part_codes pc
            WHERE pc.catalog = :regionCode AND pc.catalog_code = :modificationCode AND pc.pnc = :articul AND pc.part_code = :subGroupCode
            LIMIT 1
        ";

        $sPnc = Yii::app()->db->createCommand($sql)
            ->bindParam(":articul", $articul)
            ->bindParam(":regionCode", $regionCode)
            ->bindParam(":modificationCode", $modificationCode)
            ->bindParam(":subGroupCode", $subGroupCode)
            ->queryScalar();

        return $sPnc;
    }

    public static function getPncs($schemaCode, $regionCode, $modificationCode, $subGroupCode, $cd)
    {
         /*
         * Выбрать pnc, которые имеют отношение к конкретной модификации
         */

        $sql1 = "
            SELECT pc.part_group as pnc
            FROM part_codes pc
            WHERE pc.catalog = :regionCode AND pc.catalog_code = :modificationCode AND pc.part_code = :subGroupCode
            GROUP BY pc.part_group
        ";

        /*
         * Выбрать все метки pnc, изображенные на схеме и имеющие отношение к конкретной модификации
         */
        $sql = "
            SELECT i.label2, i.x1, i.y1, i.x2, i.y2, p.desc_en
            FROM images i
            LEFT JOIN pncs p ON i.label2 = p.pnc
            WHERE i.catalog = :regionCode AND i.pic_code = :schemaCode AND i.cd = :cd AND p.catalog = :regionCode
            AND i.label1 IN (13061, 13062)
            AND i.label2 IN (".$sql1.")
        ";

        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":subGroupCode", $subGroupCode)
            ->bindParam(":schemaCode", $schemaCode)
            ->bindParam(":regionCode", $regionCode)
            ->bindParam(":modificationCode", $modificationCode)
            ->bindParam(":cd", $cd)
            ->queryAll();

        $pncs = array();
        foreach($aData as $item){
            $pncs[$item['label2']] = array(
                Functions::NAME=>$item['desc_en'],
                Functions::OPTIONS=>array(
                    Functions::X1=>$item['x1'],
                    Functions::X2=>$item['x2'],
                    Functions::Y1=>$item['y1'],
                    Functions::Y2=>$item['y2']
            ));
        }

        return $pncs;
    }

    public static function getCommonArticuls($schemaCode, $regionCode, $cd)
    {
        /*
         * Выбрать все метки общих артикулов, изображенные на схеме
         */
        $sql = "
            SELECT i.label2, i.x1, i.y1, i.x2, i.y2
            FROM images i
            WHERE i.catalog = :regionCode AND i.pic_code = :schemaCode AND i.cd = :cd
            AND i.label1 IN (13322)
        ";

        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":schemaCode", $schemaCode)
            ->bindParam(":regionCode", $regionCode)
            ->bindParam(":cd", $cd)
            ->queryAll();

        $commonArticuls = array();
        foreach($aData as $item){
            $commonArticuls[$item['label2']] = array(
                Functions::NAME=>$item['label2'],
                Functions::OPTIONS=>array(
                    Functions::X1=>$item['x1'],
                    Functions::X2=>$item['x2'],
                    Functions::Y1=>$item['y1'],
                    Functions::Y2=>$item['y2']
            ));
        }

        return $commonArticuls;
    }

    public static function getRefGroups($schemaCode, $regionCode, $cd)
    {
         /*
         * Выбрать все метки ссылок на другие группы, изображенные на схеме
         */
        $sql = "
            SELECT i.label2, i.x1, i.y1, i.x2, i.y2
            FROM images i
            WHERE i.catalog = :regionCode AND i.pic_code = :schemaCode AND i.cd = :cd
            AND i.label1 IN (12548)
        ";

        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":schemaCode", $schemaCode)
            ->bindParam(":regionCode", $regionCode)
            ->bindParam(":cd", $cd)
            ->queryAll();

        $refGroups = array();
        foreach($aData as $item){
            $refGroups[$item['label2']] = array(
                Functions::NAME=>$item['label2'],
                Functions::OPTIONS=>array(
                    Functions::X1=>$item['x1'],
                    Functions::X2=>$item['x2'],
                    Functions::Y1=>$item['y1'],
                    Functions::Y2=>$item['y2']
                ));
        }

        return $refGroups;
    }

    public static function getArticuls($regionCode, $modificationCode, $pncCode, $complectationCode)
    {
        $aData = self::getComplectationDates($regionCode, $modificationCode, $complectationCode);

        $prod_start = $aData['prod_start'];
        $prod_end   = $aData['prod_end'];

        $sql = "
            SELECT pc.part_code, pc.quantity, pc.start_date, pc.end_date, pc.add_desc
            FROM part_catalog pc
            WHERE pc.catalog = :regionCode AND pc.catalog_code = :modificationCode AND pnc = :pncCode
            AND (pc.start_date <= " . $prod_end . "
            OR pc.end_date >= " . $prod_start . ")
        ";

        $aData = Yii::app()->db->createCommand($sql)
            ->bindParam(":pncCode", $pncCode)
            ->bindParam(":regionCode", $regionCode)
            ->bindParam(":modificationCode", $modificationCode)
            ->queryAll();

        $articuls = array();
        foreach($aData as $item){
            $articuls[$item['part_code']] = array(
                Functions::NAME=>$item['add_desc'],
                Functions::OPTIONS=>array(
                    Functions::QUANTITY => $item['quantity'],
                    Functions::PROD_START => $item['start_date'],
                    Functions::PROD_END => $item['end_date']
            ));
        }

        return $articuls;
    }
} 