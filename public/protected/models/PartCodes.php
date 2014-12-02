<?php

/**
 * This is the model class for table "part_codes".
 *
 * The followings are the available columns in table 'part_codes':
 * @property string $catalog
 * @property string $catalog_code
 * @property string $pnc
 * @property string $part_group
 * @property string $part_code
 */
class PartCodes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'part_codes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catalog, catalog_code, pnc, part_group', 'length', 'max'=>10),
			array('part_code', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, catalog_code, pnc, part_group, part_code', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'catalog' => 'Catalog',
			'catalog_code' => 'Catalog Code',
			'pnc' => 'Pnc',
			'part_group' => 'Part Group',
			'part_code' => 'Part Code',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('catalog',$this->catalog,true);
		$criteria->compare('catalog_code',$this->catalog_code,true);
		$criteria->compare('pnc',$this->pnc,true);
		$criteria->compare('part_group',$this->part_group,true);
		$criteria->compare('part_code',$this->part_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /*
     * Возвращает список кодов групп для каталога
     * Важно, что наименования полей в таблице part_codes не соответствует их смыслу
     *
     * pnc - это по смыслу part_catalog.part_code - номер самой мелкой детали
     * part_group - по смыслу pncs.pnc - номер детали, который отображается на картинке
     * part_code - по смыслу нужный нам part_groups.group_id - код группы деталей
     *
     * $min, $max определяет верхнюю и нижнюю границы для отнесения к более крупным группам
     */
    public function getPartGroupsByCatalogCode($catalog, $catalogCode, $min = 0, $max = 9){
        $aPartGroups = Yii::app()->db->CreateCommand()
            ->select('pc.part_code, ph.pic_code as pic_code')
            ->from('part_codes pc')
            ->leftJoin('pg_header_pics ph', 'pc.part_code = ph.part_group')
            ->where('pc.catalog = :catalog AND pc.catalog_code = :catalog_code AND pc.part_code >= (:min * 1000) AND pc.part_code <= (:max * 1000 + 999) AND ph.catalog = :catalog AND ph.catalog_code = :catalog_code', array(
                ':catalog'=>$catalog,
                ':catalog_code'=>$catalogCode,
                ':min'=>$min,
                ':max'=>$max))
            ->group('pc.part_code')
            ->queryAll();

        $oPartGroups = new PartGroups();

        foreach($aPartGroups as &$aPartGroup){
            $aPartGroup['desc_en'] =  $oPartGroups->getPartGroupDescEn($catalog,  $aPartGroup['part_code']);
            //$aPartGroup['part_code']. $aPartGroup['part_code'];
        }

        return $aPartGroups;
    }

    /*
     * Возвращает номер детали, изображаемый на рисунке, по номеру группы
     * (не забываем про несоответствие названий полей в part_codes)
     */
    public function getPncs($catalog, $catalogCode, $partGroup){
        $aPncs = Yii::app()->db->CreateCommand()
            ->select('pc.part_group AS pnc')
            ->from('part_codes pc')
            ->where('pc.catalog = :catalog AND pc.catalog_code = :catalog_code AND pc.part_code = :part_code', array(
                ':catalog'=>$catalog,
                ':catalog_code'=>$catalogCode,
                ':part_code'=>$partGroup))
            ->group('part_group')
            ->queryAll();

        $oPncs = new Pncs();

        foreach($aPncs as &$aPnc){
            $aPnc['desc_en'] = $aPnc['pnc'] . ' ' . $oPncs->getPncDescEn($catalog, $aPnc['pnc']);
        }

        return $aPncs;
    }
	
	



	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PartCodes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
