<?php

/**
 * This is the model class for table "nq_location".
 *
 * The followings are the available columns in table 'nq_location':
 * @property integer $id
 * @property string $country_name
 * @property string $country_code
 * @property string $state_name
 * @property string $state_code
 * @property string $district_name
 * @property string $city_name
 * @property string $pin_code
 * @property string $created_at
 */
class Location extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nq_location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_name, created_at', 'required'),
			array('country_name, country_code, state_name, state_code, district_name, city_name, pin_code', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, country_name, country_code, state_name, state_code, district_name, city_name, pin_code, created_at', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'country_name' => 'Country Name',
			'country_code' => 'Country Code',
			'state_name' => 'State Name',
			'state_code' => 'State Code',
			'district_name' => 'District Name',
			'city_name' => 'City Name',
			'pin_code' => 'Pin Code',
			'created_at' => 'Created At',
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
		$criteria->compare('country_name',$this->country_name,true);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('state_name',$this->state_name,true);
		$criteria->compare('state_code',$this->state_code,true);
		$criteria->compare('district_name',$this->district_name,true);
		$criteria->compare('city_name',$this->city_name,true);
		$criteria->compare('pin_code',$this->pin_code,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Location the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
