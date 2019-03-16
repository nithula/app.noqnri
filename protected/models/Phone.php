<?php

/**
 * This is the model class for table "nq_phone".
 *
 * The followings are the available columns in table 'nq_phone':
 * @property integer $id
 * @property integer $owner_id
 * @property string $owner_type
 * @property string $phone_number
 * @property string $country_code
 * @property string $phone_type
 * @property string $contact_type
 * @property string $created_time
 * @property string $updated_time
 * @property integer $created_by
 * @property integer $updated_by
 */
class Phone extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $phone_number_hidden;
	public function tableName()
	{
		return 'nq_phone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('owner_id, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('owner_type', 'length', 'max'=>1),
			array('phone_number, country_code', 'length', 'max'=>45),
			array('phone_type', 'length', 'max'=>6),
			array('contact_type', 'length', 'max'=>9),
			array('created_time, updated_time', 'safe'),
		    array('phone_number','unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, owner_id, owner_type, phone_number, country_code, phone_type, contact_type, created_time, updated_time, created_by, updated_by', 'safe', 'on'=>'search'),
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
		    'Owner_data'=>array(self::BELONGS_TO,'Customer',array('owner_id'=>'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'owner_id' => 'Owner',
			'owner_type' => '0=Customer,1=Partner',
			'phone_number' => 'Phone Number',
			'country_code' => 'Country Code',
			'phone_type' => 'Phone Type',
			'contact_type' => 'Primary/Secondary',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'created_by' => 'Created By',
			'updated_by' => 'Updated By',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('owner_type',$this->owner_type,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('phone_type',$this->phone_type,true);
		$criteria->compare('contact_type',$this->contact_type,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Phone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
