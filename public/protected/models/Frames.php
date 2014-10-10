<?php

/**
 * This is the model class for table "frames".
 *
 * The followings are the available columns in table 'frames':
 * @property string $catalog
 * @property string $frame_code
 * @property string $frame_ext
 * @property string $serial_number
 * @property string $code1
 * @property string $code2
 * @property string $vdate
 * @property string $fl1
 * @property string $frame_code1
 * @property string $frame_code2
 */
class Frames extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'frames';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catalog, frame_ext, vdate, fl1', 'length', 'max'=>10),
			array('frame_code', 'length', 'max'=>50),
			array('serial_number, code1, code2, frame_code1, frame_code2', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catalog, frame_code, frame_ext, serial_number, code1, code2, vdate, fl1, frame_code1, frame_code2', 'safe', 'on'=>'search'),
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
			'frame_code' => 'Frame Code',
			'frame_ext' => 'Frame Ext',
			'serial_number' => 'Serial Number',
			'code1' => 'Code1',
			'code2' => 'Code2',
			'vdate' => 'Vdate',
			'fl1' => 'Fl1',
			'frame_code1' => 'Frame Code1',
			'frame_code2' => 'Frame Code2',
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
		$criteria->compare('frame_code',$this->frame_code,true);
		$criteria->compare('frame_ext',$this->frame_ext,true);
		$criteria->compare('serial_number',$this->serial_number,true);
		$criteria->compare('code1',$this->code1,true);
		$criteria->compare('code2',$this->code2,true);
		$criteria->compare('vdate',$this->vdate,true);
		$criteria->compare('fl1',$this->fl1,true);
		$criteria->compare('frame_code1',$this->frame_code1,true);
		$criteria->compare('frame_code2',$this->frame_code2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Frames the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getDataByFrameAndSerial($frame, $serialNumber)
    {
        $aData = Yii::app()->db->createCommand()
            ->select('CONCAT(`frame_code`,`code1`,'-',`code2`) as `model_code`, SUBSTRING(`fl1`,1,3) as `body_color`')
            ->from('frames')
            ->where('frame_code=:frame AND serial_number=:serial', array(':frame'=>$frame, ':serial'=>$serialNumber))
            ->queryAll();

        return $aData;
    }
}
