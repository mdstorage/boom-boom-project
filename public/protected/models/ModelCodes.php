<?php

/**
 * This is the model class for table "model_codes".
 *
 * The followings are the available columns in table 'model_codes':
 * @property string $catalog
 * @property string $catalog_code
 * @property string $model_code
 * @property string $vin8
 * @property string $prod_start
 * @property string $prod_end
 * @property string $frame
 * @property string $engine1
 * @property string $engine2
 * @property string $body
 * @property string $grade
 * @property string $atm_mtm
 * @property string $trans
 * @property string $f1
 * @property string $f2
 * @property string $f3
 * @property string $f4
 * @property string $f5
 */
class ModelCodes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'model_codes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catalog, catalog_code, vin8, prod_start, prod_end, frame, body, grade, atm_mtm, trans, f1, f2, f3, f4, f5', 'length', 'max'=>10),
			array('model_code, engine1, engine2', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, catalog_code, model_code, vin8, prod_start, prod_end, frame, engine1, engine2, body, grade, atm_mtm, trans, f1, f2, f3, f4, f5', 'safe', 'on'=>'search'),
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
			'model_code' => 'Model Code',
			'vin8' => 'Vin8',
			'prod_start' => 'Prod Start',
			'prod_end' => 'Prod End',
			'frame' => 'Frame',
			'engine1' => 'Engine1',
			'engine2' => 'Engine2',
			'body' => 'Body',
			'grade' => 'Grade',
			'atm_mtm' => 'Atm Mtm',
			'trans' => 'Trans',
			'f1' => 'F1',
			'f2' => 'F2',
			'f3' => 'F3',
			'f4' => 'F4',
			'f5' => 'F5',
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
		$criteria->compare('model_code',$this->model_code,true);
		$criteria->compare('vin8',$this->vin8,true);
		$criteria->compare('prod_start',$this->prod_start,true);
		$criteria->compare('prod_end',$this->prod_end,true);
		$criteria->compare('frame',$this->frame,true);
		$criteria->compare('engine1',$this->engine1,true);
		$criteria->compare('engine2',$this->engine2,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('grade',$this->grade,true);
		$criteria->compare('atm_mtm',$this->atm_mtm,true);
		$criteria->compare('trans',$this->trans,true);
		$criteria->compare('f1',$this->f1,true);
		$criteria->compare('f2',$this->f2,true);
		$criteria->compare('f3',$this->f3,true);
		$criteria->compare('f4',$this->f4,true);
		$criteria->compare('f5',$this->f5,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /*
     * Возвращает массив модификаций с расшифрованными аббревиатурами
     */
    public function getModelCodes($catalog, $catalogCode)
    {
        $aModelCodes = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('model_codes')
            ->where('catalog = :catalog AND catalog_code = :catalog_code', array(':catalog'=>$catalog, ':catalog_code'=>$catalogCode))
            ->queryAll();

        $oAbbrevs = new Abbrevs();

        foreach($aModelCodes as &$aModelCode){
            $aModelCode['body'] =  $oAbbrevs->getDescEn($catalog,  $aModelCode['body']) . ' (' . $aModelCode['body'] . ')';
            $aModelCode['grade'] =  $oAbbrevs->getDescEn($catalog,  $aModelCode['grade']) . ' (' . $aModelCode['grade'] . ')';
            $aModelCode['atm_mtm'] =  $oAbbrevs->getDescEn($catalog,  $aModelCode['atm_mtm']) . ' (' . $aModelCode['atm_mtm'] . ')';
            $aModelCode['f1'] =  $oAbbrevs->getDescEn($catalog,  $aModelCode['f1']) . ' (' . $aModelCode['f1'] . ')';
        }

        return $aModelCodes;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModelCodes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
