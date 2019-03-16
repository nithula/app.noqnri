<?php

/**
 * This is the model class for table "nq_l_card_details".
 *
 * The followings are the available columns in table 'nq_l_card_details':
 * @property integer $id
 * @property integer $l_card_id
 * @property string $card_activation_date
 * @property string $card_validity_days
 * @property string $card_expiry_date
 * @property string $card_status
 * @property string $created_at
 */
class CardDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $card_number;
	public function tableName()
	{
		return 'nq_l_card_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('l_card_id, card_activation_date, card_validity_days, card_expiry_date, created_at', 'required'),
			array('l_card_id', 'numerical', 'integerOnly'=>true),
			array('card_status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, l_card_id, card_activation_date, card_validity_days, card_expiry_date, card_status, created_at', 'safe', 'on'=>'search'),
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
		    'CardData'=>array(self::BELONGS_TO,'Card',array('l_card_id'=>'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'l_card_id' => 'L Card',
			'card_activation_date' => 'Card Activation Date',
			'card_validity_days' => 'Card Validity Days',
			'card_expiry_date' => 'Card Expiry Date',
			'card_status' => 'Card Status',
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
		$criteria->compare('l_card_id',$this->l_card_id);
		$criteria->compare('card_activation_date',$this->card_activation_date,true);
		$criteria->compare('card_validity_days',$this->card_validity_days,true);
		$criteria->compare('card_expiry_date',$this->card_expiry_date,true);
		$criteria->compare('card_status',$this->card_status,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
		echo "<prE>";print_r($criteria);die;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CardDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
