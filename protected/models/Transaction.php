<?php

/**
 * This is the model class for table "nq_l_card_transaction".
 *
 * The followings are the available columns in table 'nq_l_card_transaction':
 * @property integer $id
 * @property integer $l_card_id
 * @property integer $partner_id
 * @property string $trans_currency
 * @property double $trans_amount
 * @property string $trans_date
 * @property integer $trans_ref_no
 * @property integer $points_earned
 * @property integer $points_reference
 * @property double $trans_currency_rate
 * @property integer $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Transaction extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nq_l_card_transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('l_card_id,partner_id,trans_ref_no, points_reference, points_redeemed, trans_amount, trans_currency_rate, trans_currency, trans_date', 'required'),
			array('l_card_id, partner_id, trans_ref_no, points_earned, points_redeemed, points_reference, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('trans_amount, trans_currency_rate', 'numerical'),
			array('trans_currency', 'length', 'max'=>150),
			array('trans_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, l_card_id, partner_id, trans_currency, trans_amount, trans_date, trans_ref_no, points_earned, points_reference, trans_currency_rate, created_at, created_by, updated_at, updated_by', 'safe', 'on'=>'search'),
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
			'l_card_id' => 'Card',
			'partner_id' => 'Partner',
			'trans_currency' => 'Transaction Currency',
			'trans_amount' => 'Transaction Amount',
			'trans_date' => 'Transaction Date',
			'trans_ref_no' => 'Transaction Ref No',
			'points_earned' => 'Points Earned',
			'points_reference' => 'Points Reference',
			'trans_currency_rate' => 'Transaction Currency Rate',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'updated_at' => 'Updated At',
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
		$criteria->compare('l_card_id',$this->l_card_id);
		$criteria->compare('partner_id',$this->partner_id);
		$criteria->compare('trans_currency',$this->trans_currency,true);
		$criteria->compare('trans_amount',$this->trans_amount);
		$criteria->compare('trans_date',$this->trans_date,true);
		$criteria->compare('trans_ref_no',$this->trans_ref_no);
		$criteria->compare('points_earned',$this->points_earned);
		$criteria->compare('points_reference',$this->points_reference);
		$criteria->compare('trans_currency_rate',$this->trans_currency_rate);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Transaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function CardNumber($data){
	    if($data->l_card_id){
	        echo ($data->CardData)?$data->CardData->card_number:'';
	    }
	}
	public function TransactionDate($data) {
	    $date       = $data->trans_date;
	    $date       = Common::getTimezone($date,'d M y - h: i a');
	    echo $date;
	}
	public function CreatedDate($data) {
	    $date       = $data->created_at;
	    $date       = Common::getTimezone($date,'d M y - h: i a');
	    echo $date;
	}
}
