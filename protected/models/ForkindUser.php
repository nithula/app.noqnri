<?php

/**
 * This is the model class for table "nq_partner_user".
 *
 * The followings are the available columns in table 'nq_partner_user':
 * @property integer $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $email_id
 * @property integer $login_id
 * @property integer $parent_id
 * @property integer $ext_referance_id
 * @property string $status
 * @property string $created_on
 * @property string $updated_on
 */
class ForkindUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $username;
	public function tableName()
	{
		return 'nq_partner_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, login_id, status, ext_referance_id, created_on', 'required'),
			array('login_id, parent_id, ext_referance_id', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, phone_number, email_id', 'length', 'max'=>150),
			array('middle_name', 'length', 'max'=>15),
			array('status', 'length', 'max'=>1),
		    array('email_id','email'),
		    array('email_id','unique'),
		    array('phone_number','unique'),
		    array('ext_referance_id','CheckUnique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, middle_name, last_name, phone_number, email_id, login_id, parent_id, ext_referance_id, status, created_on, updated_on', 'safe', 'on'=>'search'),
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
		    'PartnerData'=>array(self::BELONGS_TO,'Partner',array('parent_id'=>'id')),
		    'LoginData'=>array(self::BELONGS_TO,'Login',array('login_id'=>'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'last_name' => 'Last Name',
			'phone_number' => 'Phone Number',
			'email_id' => 'Email',
			'login_id' => 'Login',
			'parent_id' => 'Partner Id / Forkind Id',
			'ext_referance_id' => 'Reference Id',
			'status' => 'Status',
			'created_on' => 'Created On',
		    'updated_on' => 'Update On'
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
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('email_id',$this->email_id,true);
		$criteria->compare('login_id',$this->login_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('ext_referance_id',$this->ext_referance_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('updated_on',$this->updated_on,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ForkindUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function Switch_active_inactive($data){
	    $loginData = Login::model()->findByAttributes(array('id'=>$data->login_id));
	    if($loginData){
	        $status = ($loginData->login_status=='Y')?'checked':'';
    	    echo "<input type='checkbox' class='custom-switch' ".$status." name='$data->id'>";
	    }
	}
	public function CreatedDate($data) {
	    $date       = $data->created_on;
	    $date       = Common::getTimezone($date,'d M y - h: i a');
	    echo $date;
	}
	public function Email_address($data){
	    if(isset($data->email_id) && $data->email_id != "" )
	        $html = strlen($data->email_id) > 12
	        ? CHtml::tag("span", array("title"=>$data->email_id,"style"=>"color:#555555"), CHtml::encode(substr($data->email_id, 0, 12)) . "...")
	        : CHtml::encode($data->email_id)
	        ;
	        else
	            $html =  "";
	       return $html;
	}
	public function UsernameField($data){
	    echo $data->LoginData->username;
	}
	public function FullName($data){
	    return $data->first_name." ".$data->middle_name." ".$data->last_name;
	}
	public function Role_Data($data){
	    $role_info = "Not available";
	    if($data->LoginData){
	        if($data->LoginData->RoleData){
	            $role_info =  $data->LoginData->RoleData->role;
	        }
	    }
	    return $role_info;
	}
	public function CheckUnique($attribute,$params){
	    if(!empty($attribute)){
	        $sales = ForkindUser::model()->findByAttributes(array('parent_id'=>$this->parent_id,'ext_referance_id'=>$this->ext_referance_id));
	        if(count($sales)>0){
	            if($sales->id!=$this->id){
	               $this->addError($attribute,'Reference id already taken');
	            }
	        }
	    }
	}
}
