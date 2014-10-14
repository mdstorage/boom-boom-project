<?php

/**
 * This is the model class for table "complectations".
 *
 * The followings are the available columns in table 'complectations':
 * @property string $catalog
 * @property string $catalog_code
 * @property string $vin8
 * @property string $model_code
 * @property string $prod_start
 * @property string $prod_end
 * @property string $frame
 * @property string $f6
 * @property string $complectation_code
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
class Complectations extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'complectations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catalog, catalog_code, vin8, prod_start, prod_end, frame, complectation_code, body, grade, atm_mtm, trans', 'length', 'max'=>10),
			array('model_code, f6, engine1, engine2', 'length', 'max'=>20),
			array('f1, f2, f3, f4, f5', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, catalog_code, vin8, model_code, prod_start, prod_end, frame, f6, complectation_code, engine1, engine2, body, grade, atm_mtm, trans, f1, f2, f3, f4, f5', 'safe', 'on'=>'search'),
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
			'vin8' => 'Vin8',
			'model_code' => 'Model Code',
			'prod_start' => 'Prod Start',
			'prod_end' => 'Prod End',
			'frame' => 'Frame',
			'f6' => 'F6',
			'complectation_code' => 'Complectation Code',
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
		$criteria->compare('vin8',$this->vin8,true);
		$criteria->compare('model_code',$this->model_code,true);
		$criteria->compare('prod_start',$this->prod_start,true);
		$criteria->compare('prod_end',$this->prod_end,true);
		$criteria->compare('frame',$this->frame,true);
		$criteria->compare('f6',$this->f6,true);
		$criteria->compare('complectation_code',$this->complectation_code,true);
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Complectations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getComplectations($catalog, $catalogCode)
    {
        $aComplectations = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('complectations')
            ->where('catalog = :catalog AND catalog_code = :catalog_code', array(':catalog'=>$catalog, ':catalog_code'=>$catalogCode))
            ->queryAll();

        $aComplectations = $this->getAbbrevs($aComplectations);

        return $aComplectations;
    }

    public function getFrameByVin8($vin8)
    {
        $frame = Yii::app()->db->CreateCommand()
            ->select('frame')
            ->from('complectations')
            ->where(array('like', 'vin8', '%'.$vin8.'%'))
            ->group('frame')
            ->queryScalar();

        return $frame;
    }

    public function getComplectationByModelCode($modelCode)
    {
        $aComplectation = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('complectations')
            ->where('model_code = :model_code', array(':model_code'=>$modelCode))
            ->queryRow();

        $aComplectations = $this->getAbbrevs(array($aComplectation));

        return $aComplectations[0];
    }

    private function getAbbrevs($aComplectations)
    {
        $oAbbrevs = new Abbrevs();

        foreach($aComplectations as &$aComplectation){
            $catalog = $aComplectation['catalog'];
            $aComplectation['body'] =  $aComplectation['body'] ? $oAbbrevs->getDescEn($catalog,  $aComplectation['body']) . ' (' . $aComplectation['body'] . ')':null;
            $aComplectation['grade'] = $oAbbrevs->getDescEn($catalog,  $aComplectation['grade']) . ' (' . $aComplectation['grade'] . ')';
            $aComplectation['atm_mtm'] =  $oAbbrevs->getDescEn($catalog,  $aComplectation['atm_mtm']) . ' (' . $aComplectation['atm_mtm'] . ')';
            $aComplectation['f1'] =  $oAbbrevs->getDescEn($catalog,  $aComplectation['f1']) . ' (' . $aComplectation['f1'] . ')';
            $aComplectation['engine1'] =  $oAbbrevs->getDescEn($catalog,  $aComplectation['engine1']) . ' (' . $aComplectation['engine1'] . ')';
        }

        return $aComplectations;
    }
}
