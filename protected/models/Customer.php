<?php

/**
 * This is the model class for table "nq_customer".
 *
 * The followings are the available columns in table 'nq_customer':
 * @property integer $id
 * @property integer $login_id
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $dob
 * @property string $profession
 * @property string $email
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Customer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $username;
	public function tableName()
	{
		return 'nq_customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login_id, first_name, last_name, dob, email, created_at', 'required'),
			array('login_id, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, dob, email', 'length', 'max'=>45),
			array('gender, status', 'length', 'max'=>1),
			array('profession', 'length', 'max'=>150),
			array('updated_at', 'safe'),
		    array('email','email'),
		    array('email','unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, login_id, first_name, last_name, gender, dob, profession, email, status, created_at, updated_at, created_by, updated_by', 'safe', 'on'=>'search'),
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
			'login_id' => 'Login',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'gender' => 'Gender',
			'dob' => 'Dob',
			'profession' => 'Profession',
			'email' => 'Email',
			'status' => 'Y=Active,N=Suspended',
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
		$criteria->compare('login_id',$this->login_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('status',$this->status,true);
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
	 * @return Customer the static model class
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
	
	public function FullName($data){
	    $first_name = $data->first_name;
	    $last_name = $data->last_name;
	    $full_name = $first_name." ".$last_name;
	    echo  $full_name;
	}
	public function Gender($data){
	    $gender = $data->gender;
	    if($gender=='M'){
	        echo "Male";
	    }else{
	        echo "Female";
	    }
	}
	public function UsernameData($data){
	    return $data->LoginData->username;
	}
	public function Switch_active_inactive($data){
	    $loginData = Login::model()->findByAttributes(array('id'=>$data->login_id));
	    if($loginData){
	        $status = ($loginData->login_status=='Y')?'checked':'';
	        echo "<input type='checkbox' class='custom-switch' ".$status." name='$data->id'>";
	    }
	    
	}
	public function Email_address($data){
	    if(isset($data->email) && $data->email != "" )
	        $html = strlen($data->email) > 12
	        ? CHtml::tag("span", array("title"=>$data->email,"style"=>"color:#555555"), CHtml::encode(substr($data->email, 0, 12)) . "...")
	        : CHtml::encode($data->email)
	        ;
	        else
	            $html =  "";
	            return $html;
	}
}
