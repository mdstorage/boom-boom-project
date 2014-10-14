<?php

/**
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property string $catalog
 * @property string $cd
 * @property string $pic_code
 * @property integer $x1
 * @property integer $y1
 * @property integer $x2
 * @property integer $y2
 * @property string $label1
 * @property string $label2
 */
class Images extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'images';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('x1, y1, x2, y2', 'numerical', 'integerOnly'=>true),
			array('catalog, pic_code, label1, label2', 'length', 'max'=>50),
			array('cd', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, cd, pic_code, x1, y1, x2, y2, label1, label2', 'safe', 'on'=>'search'),
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
			'cd' => 'Cd',
			'pic_code' => 'Pic Code',
			'x1' => 'X1',
			'y1' => 'Y1',
			'x2' => 'X2',
			'y2' => 'Y2',
			'label1' => 'Label1',
			'label2' => 'Label2',
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
		$criteria->compare('cd',$this->cd,true);
		$criteria->compare('pic_code',$this->pic_code,true);
		$criteria->compare('x1',$this->x1);
		$criteria->compare('y1',$this->y1);
		$criteria->compare('x2',$this->x2);
		$criteria->compare('y2',$this->y2);
		$criteria->compare('label1',$this->label1,true);
		$criteria->compare('label2',$this->label2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Images the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getCoords($catalog, $cd, $picCode){

        $query = Yii::app()->db->createCommand()
            ->select('x1, y1, x2, y2, label2')
            ->from('images')
            ->where('catalog = :catalog AND cd = :cd AND pic_code = :pic_code', array(
                ':catalog'=>$catalog,
                ':cd'=>$cd,
                ':pic_code'=>$picCode
                ))
            ->order('label2');

        $aCoords = $query->queryAll();

        $oPncs = new Pncs();
        $oPartGroups = new PartGroups();
        foreach($aCoords as &$aCoord){
            if(strlen($aCoord['label2'])>4){
                $aCoord['desc_en'] = $oPncs->getPncDescEn($catalog, $aCoord['label2']);
            } else {
                $aCoord['desc_en'] = $oPartGroups->getPartGroupDescEn($catalog, $aCoord['label2']);
            }
        }

        return $aCoords;
    }
}
