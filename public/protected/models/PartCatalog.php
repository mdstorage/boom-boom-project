<?php

/**
 * This is the model class for table "part_catalog".
 *
 * The followings are the available columns in table 'part_catalog':
 * @property string $catalog
 * @property string $catalog_code
 * @property string $pnc
 * @property string $part_code
 * @property string $sysopt
 * @property string $quantity
 * @property string $start_date
 * @property string $end_date
 * @property string $field_type
 * @property string $code1
 * @property string $add_desc
 * @property string $field12
 */
class PartCatalog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'part_catalog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catalog, catalog_code, pnc, sysopt, quantity, start_date, end_date, field_type, code1', 'length', 'max'=>50),
			array('part_code', 'length', 'max'=>20),
			array('add_desc', 'length', 'max'=>100),
			array('field12', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, catalog_code, pnc, part_code, sysopt, quantity, start_date, end_date, field_type, code1, add_desc, field12', 'safe', 'on'=>'search'),
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
			'part_code' => 'Part Code',
			'sysopt' => 'Sysopt',
			'quantity' => 'Quantity',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'field_type' => 'Field Type',
			'code1' => 'Code1',
			'add_desc' => 'Add Desc',
			'field12' => 'Field12',
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
		$criteria->compare('part_code',$this->part_code,true);
		$criteria->compare('sysopt',$this->sysopt,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('field_type',$this->field_type,true);
		$criteria->compare('code1',$this->code1,true);
		$criteria->compare('add_desc',$this->add_desc,true);
		$criteria->compare('field12',$this->field12,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PartCatalog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getPartCodesByPnc($catalog, $catalogCode, $pnc, $prodDate=""){

        $parameters = array(
            ':catalog'=>$catalog,
            ':catalog_code'=>$catalogCode,
            ':pnc'=>$pnc
        );

        if ($prodDate !== ""){
            $prodDateString = 'AND (end_date >= :prodDate OR end_date = "")';
            $parameters[':prodDate'] = $prodDate;
        } else {
            $prodDateString = "";
        }

        $aPartCodesQuery = Yii::app()->db->CreateCommand()
            ->select('part_code, quantity, start_date, end_date, add_desc')
            ->from('part_catalog')
            ->where('catalog = :catalog AND catalog_code = :catalog_code AND pnc = :pnc AND field_type = 2 AND code1=101 ' .$prodDateString, $parameters);

        $aParamsQuery = Yii::app()->db->CreateCommand()
            ->select('part_code, add_desc')
            ->from('part_catalog')
            ->where('catalog = :catalog AND catalog_code = :catalog_code AND pnc = :pnc AND field_type = 2 AND code1=201 ' .$prodDateString, $parameters);

        $aParams = $aParamsQuery->queryAll();
        $aPartCodes = $aPartCodesQuery->queryAll();
        foreach($aPartCodes as &$aPartCode){
            foreach($aParams as $aParam){
                if($aPartCode['part_code'] == $aParam['part_code']){
                    $aPartCode['add_desc'] = $aPartCode['add_desc'] . " " . $aParam['add_desc'];
                }
            }
        }

        return $aPartCodes;
    }
}
