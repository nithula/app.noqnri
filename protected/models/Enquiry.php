<?php

/**
 * This is the model class for table "nq_enquiry".
 *
 * The followings are the available columns in table 'nq_enquiry':
 * @property integer $id
 * @property string $full_name
 * @property string $email_id
 * @property string $country_code
 * @property string $mobile_number
 * @property string $address
 * @property string $replay
 * @property string $created_at
 */
class Enquiry extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nq_enquiry';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('full_name, country_code, mobile_number, address, created_at, status', 'required'),
			array('full_name, email_id', 'length', 'max'=>150),
			array('country_code', 'length', 'max'=>10),
			array('mobile_number', 'length', 'max'=>15),
			array('replay', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, full_name, email_id, country_code, mobile_number, address, replay, created_at', 'safe', 'on'=>'search'),
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
			'full_name' => 'Full Name',
			'email_id' => 'Email',
			'country_code' => 'Code',
			'mobile_number' => 'Mobile Number',
			'address' => 'Comment',
			'replay' => 'Replay',
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
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('email_id',$this->email_id,true);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('mobile_number',$this->mobile_number,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('replay',$this->replay,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Enquiry the static model class
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
	public function AddressData($data){
	    if(isset($data->address) && $data->address != "" )
	        $html = strlen($data->address) > 12
	        ? CHtml::tag("span", array("title"=>$data->address,"style"=>"color:#555555"), CHtml::encode(substr($data->address, 0, 12)) . "...")
	        : CHtml::encode($data->address)
	        ;
	        else
	            $html =  "";
	            return $html;
	}
	public function ActionButton($data){
	    if($data->status == "N"){
	       echo '<a class="btn btn-primary btn-xs" title="Update" style="margin-right:0px" data-toggle="modal" data-target="#myModal" onclick="ApproveEnquiry(this)" id='.$data->id.'><i class="icon-pencil icon-white"></i> Approve</a>';
	    }else{
	        echo '<a class="btn btn-success btn-xs" title="Update" style="margin-right:0px"><i class="icon-pencil icon-white"></i> Closed</a>';
	    }
	}
}
