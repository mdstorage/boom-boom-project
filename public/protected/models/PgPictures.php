<?php

/**
 * This is the model class for table "pg_pictures".
 *
 * The followings are the available columns in table 'pg_pictures':
 * @property string $catalog
 * @property string $catalog_code
 * @property string $part_group
 * @property string $pic_code
 * @property string $start_date
 * @property string $end_date
 * @property string $pic_desc_code
 * @property string $ipic_code
 */
class PgPictures extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pg_pictures';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catalog, catalog_code, part_group, pic_code, start_date, end_date, pic_desc_code', 'length', 'max'=>50),
			array('ipic_code', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, catalog_code, part_group, pic_code, start_date, end_date, pic_desc_code, ipic_code', 'safe', 'on'=>'search'),
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
			'part_group' => 'Part Group',
			'pic_code' => 'Pic Code',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'pic_desc_code' => 'Pic Desc Code',
			'ipic_code' => 'Ipic Code',
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
		$criteria->compare('part_group',$this->part_group,true);
		$criteria->compare('pic_code',$this->pic_code,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('pic_desc_code',$this->pic_desc_code,true);
		$criteria->compare('ipic_code',$this->ipic_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PgPictures the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getPgPictures($catalog, $catalog_code, $part_group, $offset){
        $aPgPictures = Yii::app()->db->CreateCommand()
            ->select('pic_code')
            ->from('pg_pictures')
            ->where('catalog = :catalog AND catalog_code = :catalog_code AND part_group = :part_group', array(
                    ':catalog_code'=>$catalog_code,
                    ':catalog'=>$catalog,
                    ':part_group'=>$part_group
                )
            )
            ->limit(1, $offset)
            ->group('pic_code')
            ->queryAll();

        return $aPgPictures;
    }

    public function getCountPgPictures($catalog, $catalog_code, $part_group){

        $iCountPictures = Yii::app()->db->CreateCommand()
            ->select('COUNT(*)')
            ->from('(SELECT pic_code FROM pg_pictures WHERE catalog = :catalog AND catalog_code = :catalog_code AND part_group = :part_group GROUP BY pic_code) p')
            ->queryScalar(array(
                ':catalog_code'=>$catalog_code,
                ':catalog'=>$catalog,
                ':part_group'=>$part_group));

        return $iCountPictures;
    }
}
