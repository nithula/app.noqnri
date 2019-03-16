<?php

/**
 * This is the model class for table "nq_l_card".
 *
 * The followings are the available columns in table 'nq_l_card':
 * @property integer $id
 * @property string $card_number
 * @property string $phone_number
 * @property integer $otp
 * @property string $card_issue_status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Card extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $phone_number_hidden;
    public $card_avail_status;
	public function tableName()
	{
		return 'nq_l_card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('card_number', 'required'),
			array('otp, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('card_number', 'length', 'max'=>150),
			array('phone_number', 'length', 'max'=>25),
			array('card_issue_status', 'length', 'max'=>12),
			array('created_at, updated_at', 'safe'),
		    array('card_number','unique'),
		    array('phone_number','CheckUnique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, card_number, phone_number, otp, card_issue_status, created_at, updated_at, created_by, updated_by', 'safe', 'on'=>'search'),
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
			'card_number' => 'Card Number',
			'phone_number' => 'Phone Number',
			'otp' => 'Otp',
			'card_issue_status' => 'Card Issue Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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
		$criteria->compare('card_number',$this->card_number,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('otp',$this->otp);
		$criteria->compare('card_issue_status',$this->card_issue_status,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
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
	 * @return Card the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function CreatedDate($data) {
	    $date       = $data->created_at;
	    $date       = Common::getTimezone($date,'d M y - h: i a');
	    echo $date;
	}
	public function Switch_active_inactive($data){
	    $status = ($data->card_status=='Y')?'checked':'';
	    echo "<input type='checkbox' class='custom-switch' ".$status." name='$data->id'>";
	}
	public function CardNumber($data){
	    if($data->card_number){
	        $customerData = Phone::model()->findByAttributes(array('phone_number'=>$data->phone_number));
	        if(count($customerData)>0){
    	        if($data->card_issue_status!='Pending'){
    	            echo "<a href=".Yii::app()->baseUrl."/Customer/customerView?id=".$customerData->owner_id.">".$data->card_number."</a>";
    	        }else{
    	            echo $data->card_number;
    	        }
	        }else{
	            echo $data->card_number;
	        }
	    }
	}
	public function Card_availability($data){
	    if($data->card_issue_status=="Pending" && $data->phone_number!=NULL){
	        echo "Assigned";
	    }else if($data->card_issue_status=="OTP"){
	          echo "OTP confimation";  
	    }else{
	        echo $data->card_issue_status;
	    }
	}
	
	public function CheckUnique($attribute, $params){
        if($this->phone_number!=''){
            $phoneData = self::model()->findByAttributes(array('phone_number'=>$this->phone_number)); 
            if(count($phoneData)>0){
	            if($phoneData->id!=$this->id){
	                $this->addError($attribute, 'Phone number already in use');
	            }
            }
        }
	}
	
	public function ActionButton($data){
	    if($data->card_issue_status=="Pending" && $data->phone_number!=NULL){
	        echo '<a class="btn btn-success btn-xs" title="Update" style="margin-right:0px"><i class="icon-pencil icon-white"></i> Assigned</a>';
	    }else{
	        echo '<a class="btn btn-primary btn-xs" title="Update" style="margin-right:0px" data-toggle="modal" data-target="#myModal" onclick="editCard(this)" id='.$data->id.'><i class="icon-pencil icon-white"></i> Edit</a>';
	    }
	}
}
