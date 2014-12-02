<?php

/**
 * This is the model class for table "pg_header_pics".
 *
 * The followings are the available columns in table 'pg_header_pics':
 * @property string $catalog
 * @property string $catalog_code
 * @property string $part_group
 * @property string $compl_code
 * @property string $pic_code
 */
class PgHeaderPics extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pg_header_pics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catalog, catalog_code, part_group, compl_code', 'length', 'max'=>50),
			array('pic_code', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, catalog_code, part_group, compl_code, pic_code', 'safe', 'on'=>'search'),
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
			'compl_code' => 'Compl Code',
			'pic_code' => 'Pic Code',
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
		$criteria->compare('compl_code',$this->compl_code,true);
		$criteria->compare('pic_code',$this->pic_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PgHeaderPics the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
