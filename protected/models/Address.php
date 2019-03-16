<?php

/**
 * This is the model class for table "nq_address".
 *
 * The followings are the available columns in table 'nq_address':
 * @property integer $id
 * @property integer $owner_id
 * @property string $owner_type
 * @property string $address_type
 * @property string $address
 * @property integer $country_id
 * @property integer $state_id
 * @property integer $city_id
 * @property integer $pin_code
 * @property string $Landmark
 */
class Address extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nq_address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id, state_id, city_id, pin_code', 'required'),
			array('owner_id, country_id, state_id, city_id, pin_code', 'numerical', 'integerOnly'=>true),
			array('owner_type, address_type', 'length', 'max'=>1),
			//array('address', 'length', 'max'=>64),
			array('Landmark', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, owner_id, owner_type, address_type, address, country_id, state_id, city_id, pin_code, Landmark', 'safe', 'on'=>'search'),
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
	        'Country_details'=>array(self::BELONGS_TO,'Country',array('country_id'=>'id')),
	        'State_details'=>array(self::BELONGS_TO,'State',array('state_id'=>'id')),
	        'City_details'=>array(self::BELONGS_TO,'City',array('city_id'=>'id')),
	    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'owner_id' => 'PartnerID/CustomerID',
			'owner_type' => 'Owner Type',
			'address_type' => 'Address Type',
			'address' => 'Address',
			'country_id' => 'Country',
			'state_id' => 'State',
			'city_id' => 'City',
			'pin_code' => 'Pin Code',
			'Landmark' => 'Landmark',
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
		$criteria->compare('address_type',$this->address_type,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('pin_code',$this->pin_code);
		$criteria->compare('Landmark',$this->Landmark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Address the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
