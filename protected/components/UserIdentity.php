<?php
//require_once(Yii::getPathOfAlias('vendor').'/password.php');
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    private $_id;
    public function authenticate()
    {
        //$record=Login::model()->find("username='".$this->username."'");
        $record=Login::model()->findByAttributes(array('username'=>$this->username,'login_status'=>'Y'));
        if($record->RoleData->role=="Customer"){
            if($record===null){
                $this->_id='user Null';
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            }
            else if($record->password!==md5($this->password)){
                $this->_id=$this->username;
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }else{
                $this->username=$record->username;
                $this->setState('userType', $record->RoleData->role);
                $userDetails = Customer::model()->findByAttributes(array('login_id'=>$record->id));
                $this->setState('partner', '');
                $this->setState('fullname', $userDetails->first_name);
                $this->_id=$userDetails->id;
                $this->setState('username', $this->username);
                $this->errorCode=self::ERROR_NONE;
            }
        }else{
            $this->_id='user Null';
            $this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
        }
        return $this->errorCode==self::ERROR_NONE;
    }
    
    public function authenticate_forkind_user()
    {
        $record=Login::model()->findByAttributes(array('username'=>$this->username,'login_status'=>'Y'));
        if($record->RoleData->role!="Customer"){
            if($record===null)
            {
                $this->_id='user Null';
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            }
            
            else if($record->password!==md5($this->password))            // here I compare db password with passwod field
            {
                $this->_id=$this->username;
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }else{
                $this->username=$record->username;
                $this->setState('userType', $record->RoleData->role);
                $userDetails = ForkindUser::model()->findByAttributes(array('login_id'=>$record->id));
                $this->setState('partner', $userDetails->parent_id);
                $this->setState('fullname', $userDetails->last_name);
                $this->_id=$userDetails->id;
                $this->setState('username', $this->username);
                $this->errorCode=self::ERROR_NONE;
            }
        }else{
            $this->_id='user Null';
            $this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
        }
        return $this->errorCode==self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->_id;
    }
}