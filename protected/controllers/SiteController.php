<?php
class SiteController extends Controller
{
    public function actionIndex() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('/dashboard/'));
        }
        $customer = new Customer();
        $address = new Address();
        $country = new Country();
        $state  = new State();
        $city = new City();
        $phone = new Phone();
        $login = new Login();
        $card = new Card();
        $model = new CustomerLogin();
        $imageData = new ProfileImages();
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-user')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['CustomerLogin'])) {
            $model->attributes = $_POST['CustomerLogin'];
            if($model->validate() && $model->login('customer')){
                $message="Admin Logged In ";
                date_default_timezone_set('Asia/Kolkata');
                $date_last = date("Y-m-d H:i:s");
                Common::activityLog("-1", 'LOG IN', $message, $date_last);
                $this->redirect(array('/dashboard'));
            } else {
                Yii::app()->user->setFlash('error', 'Username or Password incorrect');
            }
        }
        $this->layout = false;
        $this->render('//site/customer', array('model' => $model,'customer'=>$customer,'address'=>$address,'country'=>$country,'state'=>$state,'city'=>$city,'phone'=>$phone,'login'=>$login,'card'=>$card,'imageData'=>$imageData));
        
    }
    
    public function actionCheck_card(){
        if($_POST['value']){
            $carddata = Card::model()->findByAttributes(array('card_number'=>$_POST['value']));
            if(count($carddata)>0){
                $transaction = Yii::app()->db->beginTransaction();
                if($_POST['form_redirector']==1){
                    if($carddata->card_issue_status=="Pending"){
                        $carddata->card_issue_status = "Verified";
                        if($carddata->save(false)){
                            $transaction->commit();
                            echo (json_encode(array('status'=>'true','msg'=>'success','phone'=>"XXXXXXXX".substr($carddata->phone_number, -3),'phone_number'=>'','card_issue_status'=>$carddata->card_issue_status)));
                        }else{
                            $transaction->rollBack();
                            echo (json_encode(array('status'=>'false','msg'=>'Error while save the data','phone'=>"",'phone_number'=>'','card_issue_status'=>'')));
                        }
                    }else{
                        echo (json_encode(array('status'=>'true','msg'=>'Status switch','phone'=>"XXXXXXXX".substr($carddata->phone_number, -3),'phone_number'=>$carddata->phone_number,'card_issue_status'=>$carddata->card_issue_status)));
                    }
                }else{
                    echo (json_encode(array('status'=>'true','msg'=>'Status switch','phone'=>"XXXXXXXX".substr($carddata->phone_number, -3),'phone_number'=>$carddata->phone_number,'card_issue_status'=>$carddata->card_issue_status)));
                }
            }else{
                echo (json_encode(array('status'=>'false','msg'=>'Card not found..!','phone'=>'','phone_number'=>'','card_issue_status'=>'')));
            }
        }else{
            echo (json_encode(array('status'=>'false','msg'=>'Error while checking the card','phone'=>'','phone_number'=>'','card_issue_status'=>'')));
        }
    }
    public function actionCheck_send_phone(){
        if(isset($_POST['value'])&&($_POST['card_number'])){
            $phoneData = Card::model()->findByAttributes(array('card_number'=>$_POST['card_number'],'phone_number'=>$_POST['value']));
            if(count($phoneData)>0){
                if($_POST['form_redirector']==1){
                    $transaction = Yii::app()->db->beginTransaction();
                    if($_POST['flag']=="0"){
                        $phoneData->card_issue_status = "OTP";
                        $result=1;
                        $msg = "Error ,Please try after some time";
                    }else{
                        $phoneData->otp = "1234"; // Replace the otp
                        $phoneData->card_issue_status = "OTP";
                        // OTP sent Code Here
                        $result=1; // Otp results store in this $result
                        $msg = "Error while sent the otp,Please try after some time";
                    }
                    if($result==1){
                        if($phoneData->save(false)){
                            $transaction->commit();
                            echo (json_encode(array('status'=>'true','msg'=>'success','phone'=>"XXXXXXXX".substr($phoneData->phone_number, -3),'phone_number'=>$phoneData->phone_number,'card_issue_status'=>$phoneData->card_issue_status)));
                        }else{
                            $transaction->rollBack();
                            echo (json_encode(array('status'=>'false','msg'=>'Error while save the data','phone'=>"",'phone_number'=>'','card_issue_status'=>'')));
                        }
                    }else{
                        echo (json_encode(array('status'=>'false','msg'=>$msg,'phone'=>"",'phone_number'=>'','card_issue_status'=>'')));
                    }
                }else{
                    echo (json_encode(array('status'=>'true','msg'=>'success','phone'=>"XXXXXXXX".substr($phoneData->phone_number, -3),'phone_number'=>$phoneData->phone_number,'card_issue_status'=>$phoneData->card_issue_status)));
                }
            }else{
                echo (json_encode(array('status'=>'false','msg'=>'Phone number mis-mtched, Please contact admin','phone'=>'','phone_number'=>'','card_issue_status'=>'')));
            }
        }else{
            echo (json_encode(array('status'=>'false','msg'=>'Error while confirming phone','phone'=>'','phone_number'=>'','card_issue_status'=>'')));
        }
    }
    
    public function actionCheck_otp(){
        if(isset($_POST['value'])&&($_POST['card_number'])){
            $phoneData = Card::model()->findByAttributes(array('card_number'=>$_POST['card_number'],'phone_number'=>$_POST['value'],'otp'=>$_POST['otp']));
            if(count($phoneData)>0){
                if($_POST['form_redirector']==1){
                    $transaction = Yii::app()->db->beginTransaction();
                    $phoneData->card_issue_status = "Registration";
                    if($phoneData->save(false)){
                        $transaction->commit();
                        echo (json_encode(array('status'=>'true','msg'=>'success','phone'=>"XXXXXXXX".substr($phoneData->phone_number, -3),'phone_number'=>$phoneData->phone_number,'card_issue_status'=>$phoneData->card_issue_status)));
                    }else{
                        $transaction->rollBack();
                        echo (json_encode(array('status'=>'false','msg'=>'Error while save the data','phone'=>"",'phone_number'=>'','card_issue_status'=>'')));
                    }
                }else{
                    echo (json_encode(array('status'=>'true','msg'=>'success','phone'=>"XXXXXXXX".substr($phoneData->phone_number, -3),'phone_number'=>$phoneData->phone_number,'card_issue_status'=>$phoneData->card_issue_status)));
                }
            }else{
                echo (json_encode(array('status'=>'false','msg'=>'OTP mis-match ,retry the process','phone'=>'','phone_number'=>'','card_issue_status'=>'')));
            }
        }else{
            echo (json_encode(array('status'=>'false','msg'=>'Error while confirming phone','phone'=>'','phone_number'=>'','card_issue_status'=>'')));
        }
    }
    public function actionrequestOtp(){
        if(isset($_POST['value'])&&($_POST['phone_number'])){
            $otpData = Card::model()->findByAttributes(array('card_number'=>$_POST['value'],'phone_number'=>$_POST['phone_number']));
            if(count($otpData)>0){
                $transaction = Yii::app()->db->beginTransaction();
                $otpData->otp = '1234';
                if($_POST['form_redirector']==1){
                    $otpData->card_issue_status = "OTP";
                }
                $otpData->updated_at = date('Y-m-d H:i:s');
                $otpData->updated_by = Yii::app()->user->id;
                if($otpData->save(false)){
                    $transaction->commit();
                    echo (json_encode(array('status'=>'true','msg'=>'OTP has been generated and sent successfully','phone'=>"XXXXXXXX".substr($otpData->phone_number, -3),'phone_number'=>$otpData->phone_number,'card_issue_status'=>$otpData->card_issue_status)));
                }else{
                    $transaction->rollBack();
                    echo (json_encode(array('status'=>'false','msg'=>'Error while save the data','phone'=>"",'phone_number'=>'','card_issue_status'=>'')));
                }
            }else{
                echo (json_encode(array('status'=>'false','msg'=>'Card and Phone mis-match','phone'=>'','phone_number'=>'','card_issue_status'=>'')));
            }
        }
    }
    
    public function actionError()
    {
        $this->page_title ='Error';
        $error = Yii::app()->errorHandler->error;
        $this->render('//layouts/error',array('error'=>$error));
        /*$this->renderJSON(array(
            'message' => Yii::app()->errorHandler->error['message']
        ), Yii::app()->errorHandler->error['code']);*/
    }
    
    public function actionStatesList(){
        if($_POST['value']){
            $StateDetails = State::model()->findAllByAttributes(array('country_id'=>$_POST['value']));
            if(count($StateDetails)>0){?>
            	<label for="Address_state_id">State Name</label>
	            <select id="Address_state_id" class="form-control select2" data-placeholder="Select State" name="Address[state_id]" data-validation="required" onChange="SelectCity(this);">
	            	<option value="">Select State</option>
	            <?php foreach($StateDetails as $user_data){?>
	            	<option value="<?php echo $user_data->id?>"><?php echo $user_data->state_name;?></option>
	            <?php }?>
	            </select>
	        <?php }else{
	            echo "<select class='form-control select2' multiple='multiple' data-placeholder='Select State'></select>";
	        }
	    }
    }
    
    public function actionCountryCode(){
        if($_POST['value']){
            $countryData = Country::model()->findByPk($_POST['value']);
            if(count($countryData)>0){
                echo trim(str_replace("(".$countryData->country_code.")",'',$countryData->country_phone_code));
            }
        }
    }
    
    public function actionCityList(){
        if($_POST['value']){
            $CityDetails = City::model()->findAllByAttributes(array('state_id'=>$_POST['value']));
            if(count($CityDetails)>0){?>
            	<label for="Address_city_content">City Name</label>
	            <select id="Address_city_id" class="form-control select2" data-placeholder="Select city" name="Address[city_id]" data-validation="required">
	           	<option value="">Select City</option>
	            <?php foreach($CityDetails as $user_data){?>
	            	<option value="<?php echo $user_data->id?>"><?php echo $user_data->name;?></option>
	            <?php }?>
	            	<option value="0">Other</option>
	            </select>
	        <?php }else{
	            echo "<select class='form-control select2' multiple='multiple' data-placeholder='Select city'></select>";
	        }
	    }
    }
    
    
    public function actionStatesListCust(){
        if($_POST['value']){
            $StateDetails = State::model()->findAllByAttributes(array('country_id'=>$_POST['value']));
            if(count($StateDetails)>0){?>
            	<label for="Address_state_id">State Name</label>
	            <select id="Address_state_id_<?php echo $_POST['id']?>" class="form-control select2" data-placeholder="Select State" name="Address[state_id][]" data-validation="required" onChange="SelectCity(this,'<?php echo $_POST['id']?>');">
	            	<option value="">Select State</option>
	            <?php foreach($StateDetails as $user_data){?>
	            	<option value="<?php echo $user_data->id?>"><?php echo $user_data->state_name;?></option>
	            <?php }?>
	            </select>
	        <?php }else{
	            echo "<label for='Address_state_id'>State Name</label><select class='form-control select2' multiple='multiple' data-placeholder='Select State'><option value=''>Select State</option></select>";
	        }
	    }
    }
    
    public function actionCityListCust(){
        if($_POST['value']){
            $CityDetails = City::model()->findAllByAttributes(array('state_id'=>$_POST['value']));
            if(count($CityDetails)>0){?>
            	<label for="Address_city_content">City Name</label>
	            <select id="Address_city_id_<?php echo $_POST['id']?>" class="form-control select2" data-placeholder="Select city" name="Address[city_id][]" data-validation="required">
	           	<option value="">Select City</option>
	            <?php foreach($CityDetails as $user_data){?>
	            	<option value="<?php echo $user_data->id?>"><?php echo $user_data->name;?></option>
	            <?php }?>
	            </select>
	        <?php }else{
	            echo "<label for='Address_city_content'>City Name</label><select class='form-control select2' multiple='multiple' data-placeholder='Select city'><option value=''>Select City</option></select>";
	        }
	    }
    }
    public function actionShow_customer_registration($phone){
        $PhoneData = Card::model()->findByAttributes(array('phone_number'=>$phone,'card_issue_status'=>'Registration'));
        if(count($PhoneData)>0){
            $customer = new Customer();
            $address = new Address();
            $country = new Country();
            $state  = new State();
            $city = new City();
            $phone = new Phone();
            $login = new Login();
            $card = new Card();
            $imageData = new ProfileImages();
            if(isset($_POST['Customer'])){
                $successFlag = false;
                if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
                    $secret = '6LfEx2MUAAAAANGL0B-564et8_keKzmE4Y9alRhM';
                    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                    $responseData = json_decode($verifyResponse);
                    if($responseData->success){
                        $transaction = Yii::app()->db->beginTransaction();
                        if(isset($_POST['Customer'])){
                            $login = new Login;
                            $login->role_id = 6;
                            $login->username = $PhoneData->card_number;
                            $login->password = md5($_POST['Login']['password']);
                            if($login->validate() && $login->save()){
                                $customer = new Customer;
                                $customer->attributes = $_POST['Customer'];
                                $customer->login_id = $login->id;
                                $customer->gender = $_POST['Customer']['gender'];
                                $customer->created_at = date('Y-m-d H:i:s');
                                if($customer->validate() && $customer->save()){
                                $address = $_POST['Address'];
                                $address_successCount = array();
                                for($i=0;$i<count($address['address_type']);$i++){
                                    $customer_address = new Address;
                                    $customer_address->owner_id = $customer->id;
                                    $customer_address->owner_type = "0";
                                    if($address['address_type'][$i]=="Communication Address"){
                                        $address_Type = 1;
                                    }else{
                                        $address_Type = 0;
                                    }
                                    $customer_address->address_type = $address_Type;
                                    $customer_address->address = $address['address'][$i];
                                    $customer_address->country_id = $address['country_id'][$i];
                                    $customer_address->state_id = $address['state_id'][$i];
                                    $customer_address->city_id = $address['city_id'][$i];
                                    $customer_address->pin_code = $address['pin_code'][$i];
                                    $customer_address->Landmark = '0';
                                    if($customer_address->validate() && $customer_address->save()){
                                    $successFlag=true;
                                        array_push($address_successCount,'1');
                                    }else{
                                        //echo "<pre>";print_r($customer_address->getErrors());
                                        $successFlag = false;
                                    }
                                }
                                if(count($address['address_type'])==count($address_successCount)){
                                    $phone_data=$_POST['Phone'];
                                    $successCount = array();
                                    for($i=0;$i<count($phone_data['phone_type']);$i++){
                                        $phone = new Phone;
                                        $phone->owner_id = $customer->id;
                                        $phone->owner_type = "0";
                                        $phone->phone_number = $phone_data['phone_number'][$i];
                                        $phone->country_code = $phone_data['country_code'][$i];
                                        $phone->phone_type = $phone_data['phone_type'][$i];
                                        $phone->contact_type = $phone_data['contact_type'][$i];
                                        $phone->created_time =  date('Y-m-d H:i:s');
                                        if($phone->validate() && $phone->save()){
                                        $successFlag=true;
                                            array_push($successCount,'1');
                                        }else{
                                            //echo "<pre>";print_r($phone->getErrors());
                                            $successFlag = false;
                                        }
                                    }
                                    if(count($phone_data['phone_type'])==count($successCount)){
                                        $imageData = new ProfileImages();
                                        $imageDetails=CUploadedFile::getInstance($imageData,'image');
                                        if($imageDetails!=NULL){
                                            $path = $_FILES['ProfileImages']['name']['image'];
                                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                                            $imageData->image = $customer->first_name."_".date('ymdhis').".".$ext;
                                            $imageData->owner_id = $customer->id;
                                            $imageData->owner_type = 0;
                                            $imageData->created_date = date('Y-m-d H:i:s');
                                            if($imageData->validate()) {
                                                $file_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/customer/profile_image/';
                                                if (!file_exists($file_path)){
                                                    mkdir($file_path, 0777, true);
                                                }
                                                $path= $file_path.$imageData->image;
                                                $imageDetails->saveAs($path);
                                                if($imageData->save()){
                                                    $successFlag = true;
                                                }else{
                                                    $successFlag = false;
                                                }
                                            }else{
                                                $successFlag = false;
                                            }
                                        }else{
                                            $successFlag = true;
                                        }
                                    }else{
                                        $successFlag = false;
                                    }
                                }else{
                                    $successFlag = false;
                                }
                                }else{
                                    //echo "<pre>";print_r($customer->getErrors());die;
                                    $successFlag = false;
                                }
                            }else{
                                //echo "<pr>";print_r($login->getErrors());die;
                                $successFlag = false;
                            }
                        }else{
                            $successFlag = false;
                        }
                        if($successFlag===true){
                            $cardDetails = Card::model()->findByPk($PhoneData->id);
                            $cardDetails->card_issue_status = 'Approved';
                            $cardDetails->updated_at =  date('Y-m-d H:i:s');
                            if($cardDetails->save()){
                                $transaction->commit();
                                $message = "New user ".$customer->first_name.' '.$customer->last_name." registered ";
                                Yii::app()->user->setFlash('success_flash_msg', 'Registration has been successfully completed');
                                Common::activityLog($login->id, 'REGISTRATION', $message, date('Y-m-d H:i:s'));
                                $this->redirect(array('site/index'));
                            }else{
                                $transaction->rollBack();
                                Yii::app()->user->setFlash('error_flash_msg', 'Registration has been successfully completed');
                                $this->redirect(array('site/index'));
                            }
                        }else{
                            $transaction->rollBack();
                            Yii::app()->user->setFlash('error_flash_msg', 'Registration has been faild');
                            $this->redirect(array('site/index'));
                        }
                    }else{
                        //echo(json_encode(array('status'=>'captcha','msg'=>'Failed to validate captcha')));
                        $this->render('//site/customer/registerForm',array('customer'=>$customer,'address'=>$address,'country'=>$country,'state'=>$state,'city'=>$city,'phone'=>$phone,'login'=>$login,'card'=>$card,'imageData'=>$imageData,'PhoneData'=>$PhoneData));
                    }
                }else{
                    //echo(json_encode(array('status'=>'captcha','msg'=>'Prove you are not a robot !')));
                    $this->render('//site/customer/registerForm',array('customer'=>$customer,'address'=>$address,'country'=>$country,'state'=>$state,'city'=>$city,'phone'=>$phone,'login'=>$login,'card'=>$card,'imageData'=>$imageData,'PhoneData'=>$PhoneData));
                }
            }
            $this->render('//site/customer/registerForm',array('customer'=>$customer,'address'=>$address,'country'=>$country,'state'=>$state,'city'=>$city,'phone'=>$phone,'login'=>$login,'card'=>$card,'imageData'=>$imageData,'PhoneData'=>$PhoneData));
        }else{
            throw new CHttpException(404,'Requested pagenot found');
        }
    }
    
   public function actionCheck_unity(){
       if(isset($_POST['value']) && ($_POST['key']) && ($_POST['table'])){
           if($_POST['value']!=""|| $_POST['value']!=NULL || empty($_POST['value'])){
               $contentData = $_POST['table']::model()->findByAttributes(array($_POST['key']=>$_POST['value']));
               if($contentData){
                   echo(json_encode(array('status'=>'false','msg'=>$_POST['value'] .' Already taken..!','color'=>'#FF0000')));
               }else{
                   echo(json_encode(array('status'=>'true','msg'=>$_POST['value'] .' Available..!','color'=>'#00a65a')));
               }
            }
       }
   }
    public function actionForgot(){
        $this->layout=false;
        date_default_timezone_set('Asia/Kolkata');
        if(isset($_POST['Login']))
        {
            $loginData = Login::model()->findByAttributes(array('username'=>$_POST['Login']['username_input']));
            if($loginData){
                $loginData->password = md5($_POST['Login']['password']);
                if($_POST['Login']['userType']=="1"){
                    $loginData->reset_code = '';
                }
                if($loginData->save(false)){
                    Yii::app()->user->setFlash('success_flash_msg', "Password reset successfully");
                    $this->renderJSON(array('status' => 'true', 'message' => 'Password reset successfully'));
                }else{
                    $this->renderJSON(array('status' => 'false', 'message' => 'Error while reset the password'));
                }
            }else{
                $this->renderJSON(array('status' => 'false', 'message' => 'Username not found'));
            }
        }
    }
    public function actionRegister(){
        $customer = new Customer;
        $phone = new Phone();
        $login = new Login;
        //echo "<prE>";print_r($_POST);die;
        if(isset($_POST['Login'])&&(!empty($_POST['Login'])) && isset($_POST['Phone'])&&(!empty($_POST['Phone']))&& isset($_POST['Customer'])&&(!empty($_POST['Customer']))){
            $login->attributes=$_POST['Login'];
            $login->role_id = 6;
            $login->username = $_POST['Login']['username'];
            $login->password = md5($_POST['Login']['password']);
            $customer->attributes=$_POST['Customer'];
            $customer->login_id = '0';
            $customer->dob="11-11-1991";
            $customer->created_at = date('Y-m-d H:i:s');
            $phone->attributes=$_POST['Phone'];
            $phone->owner_id = 0;
            $phone->owner_type = "0";
            $phone->phone_number = $_POST['Phone']['phone_number'];
            $phone->country_code = '+91';
            $phone->phone_type = 'Mobile';
            $phone->contact_type = 'Primary';
            $phone->created_time =  date('Y-m-d H:i:s');
            
            $valid =$login->validate();
            $valid =$customer->validate()&& $valid;
            $valid =$phone->validate()&& $valid;
            
            if($valid==true){
                $transaction = Yii::app()->db->beginTransaction();
                if($login->validate() && $login->save()){
                    $customer->login_id = $login->id;
                    if($customer->validate() && $customer->save()){
                        $phone->owner_id = $customer->id;
                        if($phone->validate() && $phone->save()){
                            $cardDetails = Card::model()->findByAttributes(array('card_number'=>$_POST['Login']['username']));
                            $cardDetails->card_issue_status = 'Approved';
                            $cardDetails->updated_at =  date('Y-m-d H:i:s');
                            if($cardDetails->save()){
                                $transaction->commit();
                                $message = "New user ".$customer->first_name.' '.$customer->last_name." registered ";
                                Yii::app()->user->setFlash('success_flash_msg', 'Registration has been successfully completed');
                                Common::activityLog($login->id, 'REGISTRATION', $message, date('Y-m-d H:i:s'));
                                $this->redirect(array('site/index'));
                            }else{
                                $transaction->rollBack();
                                //Yii::app()->user->setFlash('error_flash_msg', 'Registration has been successfully completed');
                                //$this->redirect(array('site/index'));
                            }
                        }else{
                            $transaction->rollBack();
                            //Yii::app()->user->setFlash('error_flash_msg', 'Registration has been faild');
                            //$this->redirect(array('site/index'));
                        }
                    }else{
                        $transaction->rollBack();
                    }
                }else{
                    $transaction->rollBack();
                }
            }
        }
        $this->render('//site/customer/register',array('customer'=>$customer,'phone'=>$phone,'login'=>$login));
    }
    
    public function actionGetusername(){
        if(isset($_POST['value']) && !empty($_POST['value'])){
            $cardData = Card::model()->findByAttributes(array('card_number'=>$_POST['value']));
            if($cardData){
                if($cardData->card_issue_status=="Approved"){
                    echo(json_encode(array('status'=>'error','username'=>$cardData->card_number,'msg'=>'Already registered')));
                }else{
                    echo(json_encode(array('status'=>'success','username'=>$cardData->card_number,'msg'=>'')));
                }
            }else{
                echo(json_encode(array('status'=>'error','username'=>'','msg'=>"Couldn't find any matching card number")));
            }
        }
    }
    
    public function actionLogout() {
        $userType = Yii::app()->user->userType;
        if($userType=="Admin" || $userType=="Super Admin"){
            Yii::app()->user->logout();
            $this->redirect(array('partner/index'));
        }else if($userType=="Customer"){
            Yii::app()->user->logout();
            $this->redirect(array('site/index'));
        }else{
            Yii::app()->user->logout();
            $this->redirect(array('partner/index'));
        }
    }
}