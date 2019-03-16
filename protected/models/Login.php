<?php

/**
 * This is the model class for table "nq_login_detail".
 *
 * The followings are the available columns in table 'nq_login_detail':
 * @property integer $id
 * @property integer $role_id
 * @property string $username
 * @property string $password
 * @property string $reset_code
 * @property string $login_status
 */
class Login extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $confirm_password;
    public $Login_username_input;
    public $userType;
	public function tableName()
	{
		return 'nq_login_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id, username, password', 'required'),
			array('role_id', 'numerical', 'integerOnly'=>true),
			array('username, password, reset_code', 'length', 'max'=>150),
			array('login_status', 'length', 'max'=>1),
		    array('username','unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, role_id, username, password, reset_code, login_status', 'safe', 'on'=>'search'),
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
		    'RoleData'=>array(self::BELONGS_TO,'Role',array('role_id'=>'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'role_id' => 'Role',
			'username' => 'Username',
			'password' => 'Password',
			'reset_code' => 'Reset Code',
			'login_status' => 'Y=Active,N=Inactive',
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
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('reset_code',$this->reset_code,true);
		$criteria->compare('login_status',$this->login_status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Login the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
