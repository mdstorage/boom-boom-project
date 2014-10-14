<?php

/**
 * This is the model class for table "models".
 *
 * The followings are the available columns in table 'models':
 * @property string $catalog
 * @property string $model_name
 * @property string $catalog_code
 * @property string $add_codes
 * @property string $prod_start
 * @property string $prod_end
 * @property string $cd
 */
class Models extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'models';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catalog, catalog_code', 'length', 'max'=>10),
			array('model_name, add_codes, prod_start, prod_end', 'length', 'max'=>50),
			array('cd', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, model_name, catalog_code, add_codes, prod_start, prod_end, cd', 'safe', 'on'=>'search'),
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
			'catalog' => 'Регион',
			'model_name' => 'Наименование модели',
			'catalog_code' => 'Номер каталога',
			'add_codes' => 'Код модели',
			'prod_start' => 'Дата начала производства',
			'prod_end' => 'Дата снятия с производства',
			'cd' => 'Cd',
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
		$criteria->compare('model_name',$this->model_name,true);
		$criteria->compare('catalog_code',$this->catalog_code,true);
		$criteria->compare('add_codes',$this->add_codes,true);
		$criteria->compare('prod_start',$this->prod_start,true);
		$criteria->compare('prod_end',$this->prod_end,true);
		$criteria->compare('cd',$this->cd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /*
     * Возвращает список регионов (каталогов)
     */
    public function getCatalogs(){

        $aCatalogs = Yii::app()->db->CreateCommand()
            ->select('catalog')
            ->from('models')
            ->group('catalog')
            ->queryAll();

        return $aCatalogs;
    }

    /*
     * Возвращает список наименований моделей для выбранного региона
     */
    public function getModelNames($catalog){

        $aModelNames = Yii::app()->db->CreateCommand()
            ->select('model_name')
            ->from('models')
            ->where('catalog = :catalog', array(':catalog'=>$catalog))
            ->group('model_name')
            ->queryAll();

        return $aModelNames;
    }

    /*
     * Возвращает набор кодов по каждой модели (по годам выпуска)
     */
    public function getModelNameCodes($modelName, $catalog)
    {
        $aModelNameCodes = Yii::app()->db->CreateCommand()
            ->select('add_codes, prod_start, prod_end, catalog_code, cd')
            ->from('models')
            ->where('catalog = :catalog AND model_name = :model_name', array(':model_name'=>$modelName, 'catalog'=>$catalog))
            ->queryAll();

        return $aModelNameCodes;
    }

    /*
     * Возвращает название модели по региону и коду каталога
     */
    public function getModelNameByCodes($catalog, $catalogCode)
    {
        $aModelName = Yii::app()->db->CreateCommand()
            ->select('model_name, cd')
            ->from('models')
            ->where('catalog = :catalog AND catalog_code = :catalog_code', array(':catalog_code'=>$catalogCode, 'catalog'=>$catalog))
            ->queryRow();

        return $aModelName;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Models the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
