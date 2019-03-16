<p class="login-box-msg">Register as new member</p>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'register-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
    'htmlOptions' => array(
        'class' => 'separate-sections',
        'enctype' => 'multipart/form-data'
    )
));
?>
<?php if (Yii::app()->user->hasFlash('success')): ?>
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Oh Snap!</strong> <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>
<div class="row">
	<div class="col-xs-12">
        <div class="col-sm-6">
            <div  class="form-group has-feedback">
            	<?php echo $form->labelEx($customer,'first_name'); ?>
                <?php echo $form->textField($customer, 'first_name', array('class'=>'form-control','placeholder' => 'First Name','data-validation'=>"required")); ?>
                <?php echo $form->error($customer,'first_name',array('style'=>'color:#FF0000'));?>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>  
             
            <div class="form-group" style="margin-bottom: -24px;">
            	<?php echo $form->labelEx($customer,'gender'); ?>
                <div class="row">
                	<div class="col-md-4">
                    <?php
                		$accountStatus = array('M'=>'Male', 'F'=>'Female');
                		echo $form->radioButtonList($customer,'gender',$accountStatus,array('class'=>'col-md-4'));
                	?>
                	</div>
                </div>
            </div>
            <div  class="form-group has-feedback" style="margin-top: 24px;">
            	<?php echo $form->labelEx($customer,'email'); ?>
                <?php echo $form->textField($customer, 'email', array('class'=>'form-control','placeholder' => 'Email','data-validation'=>"email",'onKeyup'=>'checkUnity(this,"email","Customer")')); ?>
                <?php echo $form->error($customer,'email',array('style'=>'color:#FF0000'));?>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <span id="email"></span>
            </div> 
            <div class="form-group has-feedback" style="margin-bottom: 35px;">
            	<?php echo $form->labelEx($address,'address_type'); ?>
                <?php echo $form->textField($address, 'address_type[]', array('class'=>'form-control','placeholder' => 'Address','value'=>'Permanent Address','readonly'=>true)); ?>
                <?php echo $form->error($address,'address_type',array('style'=>'color:#FF0000'));?>
          	</div>
            <div class="form-group has-feedback" style="margin-top: 35px;">
            	<?php echo $form->labelEx($address,'country_id'); ?>
                <?php echo $form->dropDownList($address, 'country_id[]', CHtml::listData(Country::model()->findAll(), 'id', 'country_name'),array('class'=>'form-control select2','empty'=>'Select Country','data-placeholder'=>"Select Country",'onChange'=>'getState(this,"1")'));?>
                <?php echo $form->error($address,'country_id'); ?>
          	</div>   
          	<div class="form-group has-feedback append_city_1" id="append_address_left">
            	<?php echo $form->labelEx($address,'city_id'); ?>
                <?php $listContent = array();?>
                <?php echo $form->dropdownlist($address,'city_id[]',$listContent,array('class'=>'form-control select2 special','data-validation'=>"required",'empty'=>'Select City')); ?>
                <?php echo $form->error($address,'city_id',array('style'=>'color:#FF0000'));?>
            </div>
          	<div class="form-group has-feedback">
          		<?php echo $form->labelEx($phone,'phone_type'); ?>
            	<?php $phoneType = array('Mobile'=>'Mobile','Office'=>'Office','Home'=>'Home')?>
                <?php echo $form->dropDownList($phone,'phone_type[]',$phoneType,array('class'=>'form-control select2 special','data-validation'=>"required"));?>
                <?php echo $form->error($phone,'phone_type'); ?>
          	</div>
          	<div class="form-group has-feedback" id="append_type_1">
          		  <?php echo $form->labelEx($phone,'country_code'); ?>
                  <?php echo $form->textField($phone, 'country_code[]', array('class'=>'form-control date country_code','placeholder'=>'Country Code','value'=>'+91','readonly'=>true)); ?>
                  <?php echo $form->error($phone,'country_code',array('style'=>'color:#FF0000'));?>
                  <span class="glyphicon glyphicon-phone form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
            	  <?php echo $form->labelEx($login,'username'); ?>
                  <?php echo $form->textField($login, 'username', array('class'=>'form-control','placeholder' => 'Username','data-validation'=>"alphanumeric",'data-validation-allowing'=>"-_.",'onKeyup'=>'checkUnity(this,"username","Login")','value'=>$PhoneData->card_number,'readonly'=>true)); ?>
                  <?php echo $form->error($login,'username',array('style'=>'color:#FF0000'));?>
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  <span id="username"></span>
            </div> 
            <div class="form-group" style="margin-top: 35px;">
            	<?php echo $form->labelEx($imageData,'image'); ?>
                <div class="input-group image-preview">
                    <input type="text" class="form-control image-preview-filename" readonly="true">
                    <span class="input-group-btn">
                        <div class="btn btn-default image-preview-input">
                            <span class="glyphicon glyphicon-folder-open"></span>
                            <span class="image-preview-input-title">Choose File</span>
                            <?php 
                            echo $form->fileField($imageData, 'image',array('id'=>'profile_image'));
                            echo $form->error($imageData, 'image');
                            ?>
                        </div>
                    </span>
                </div>
           </div> 
           <div class="form-group has-feedback"> 
				<div id="thumb-output">
				</div>
			</div>                 
        </div>
        <div class="col-sm-6">
            <div  class="form-group has-feedback">
            	<?php echo $form->labelEx($customer,'last_name'); ?>
                <?php echo $form->textField($customer, 'last_name', array('class'=>'form-control','placeholder' => 'Last Name','data-validation'=>"required")); ?>
                <?php echo $form->error($customer,'last_name',array('style'=>'color:#FF0000'));?>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>	
            <div class="form-group has-feedback">
            	  <?php echo $form->labelEx($customer,'dob'); ?>
                  <?php echo $form->textField($customer, 'dob', array('class'=>'form-control date','placeholder' => 'Date Of Birth','autocomplete'=>'off')); ?>
                  <?php echo $form->error($customer,'dob',array('style'=>'color:#FF0000'));?>
                  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
            	<?php echo $form->labelEx($customer,'profession'); ?>
				<?php echo $form->textField($customer, 'profession', array('class'=>'form-control','placeholder' => 'Profession')); ?>
                <?php echo $form->error($customer,'profession',array('style'=>'color:#FF0000'));?>
                <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
          	</div>
            <div class="form-group has-feedback">
                <div class="row">
			    	<div class="col-md-10">
			    		<?php echo $form->labelEx($address,'address'); ?>
			    		<?php echo $form->textArea($address, 'address[]', array('class'=>'form-control','placeholder' => 'Address','data-validation'=>"required")); ?>
                    	<?php echo $form->error($address,'address',array('style'=>'color:#FF0000'));?>
                    	<span class="glyphicon glyphicon-globe form-control-feedback" style="margin-right: 20px;"></span>
                    </div>
                    <div class="col-md-2" style="margin-top: 10%;">
                    	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/plus.png" alt="add_new" onClick="appendAddressBox(1)" style="cursor:pointer;" id="add_new_address">
                    </div>
                </div>
          	</div> 
            
            <div class="form-group has-feedback append_state_1">
            	<?php echo $form->labelEx($address,'state_id'); ?>
          		<?php echo $form->dropDownList($address, 'state_id[]', array(),array('class'=>'form-control select2 special','empty'=>'Select State','data-placeholder'=>"Select State"));?>
                <?php echo $form->error($address,'state_id'); ?>
          	</div>
            <div class="form-group has-feedback" id="append_address_right">
      		   <?php echo $form->labelEx($address,'pin_code'); ?>
               <?php echo $form->textField($address, 'pin_code[]', array('class'=>'form-control','placeholder'=>'Pin Code','data-validation'=>"required")); ?>
               <?php echo $form->error($address,'pin_code',array('style'=>'color:#FF0000'));?>
            </div>  
            <div class="form-group has-feedback">
                <div class="row">
			    	<div class="col-md-10">
			    		<?php echo $form->labelEx($phone,'contact_type'); ?>
			    		<?php $typeList = array('Primary'=>'Primary','Secondary'=>'Secondary');?>
                        <?php echo $form->dropDownList($phone, 'contact_type[]', $typeList,array('class'=>'form-control select2 additional','data-validation'=>"required",'readonly'=>true));?>
                        <?php echo $form->error($phone,'contact_type'); ?>
                    </div>
                    <div class="col-md-2" style="margin-top: 5%;">
                    	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/plus.png" class="img" alt="add_new" onClick="appendBox(1)" style="cursor:pointer;" id="add_new_phone">
                    </div>
                </div>
          	</div> 
          	<div class="form-group has-feedback" id="append_number_1">
          		<div class="row">
			    	<div class="col-md-12">
			    	  <?php echo $form->labelEx($phone,'phone_number'); ?>
                      <?php echo $form->textField($phone, 'phone_number[]', array('class'=>'form-control','placeholder'=>'Phone Number','data-validation'=>"length number",'data-validation-length'=>"min10",'autocomplete'=>'off','onKeyup'=>'checkUnity(this,"phone_number","Phone")','value'=>$PhoneData->phone_number,'readonly'=>true)); ?>
                      <?php echo $form->error($phone,'phone_number',array('style'=>'color:#FF0000'));?>
                      <span class="glyphicon glyphicon-phone form-control-feedback" style="right:20px;"></span>
                      <span id="phone_number"></span>
              		</div>
                </div>
            </div>
            <div class="form-group has-feedback">
            	  <?php echo $form->labelEx($login,'password'); ?>
                  <?php echo $form->passwordField($login, 'password', array('class'=>'form-control','placeholder' => 'Password','data-validation'=>"required")); ?>
                  <?php echo $form->error($login,'password',array('style'=>'color:#FF0000'));?>
                  <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                  <span id="result"></span>&nbsp&nbsp <span id="password_strength"></span>
            </div>
            <div class="form-group has-feedback">
            	  <?php echo $form->labelEx($login,'confirm_password'); ?>
                  <?php echo $form->passwordField($login, 'confirm_password', array('class'=>'form-control','placeholder' => 'Confirm Password','data-validation'=>"required")); ?>
                  <?php echo $form->error($login,'confirm_password',array('style'=>'color:#FF0000'));?>
                  <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                  <span id="result_confirm"></span>&nbsp&nbsp <span id="password_strength_confirm"></span>
            </div>
            <div class="form-group has-feedback">
            	<div class="g-recaptcha form-group" data-sitekey="6LfEx2MUAAAAAF_cI9xendqXddcG0FfiagYkBzcb" data-validation="recaptcha" data-validation-recaptcha-sitekey="6LfEx2MUAAAAAF_cI9xendqXddcG0FfiagYkBzcb"></div>
            	<span class="error" id="captcha_error" style="color:#dd4b39"></span>
            </div>	
            <div class="form-group">
            	<?php $this->widget('bootstrap.widgets.TbButton', array(
            		'buttonType'=>'submit',
            		'type'=>'primary',
            	    'htmlOptions'=>array('id'=>'submit_registration'),
            		'label'=>'Register',
            	)); ?>
                <?php
                    echo CHtml::htmlButton('Back',array(
                        "id"=>'register_content_back',
                        "class"=>'btn btn-secondary common_regist'
                    ));
                ?>
                <a href="javascript:void(0);" style="float:right;padding:10px;display:none;" class="btn btn-secondary" id="back_to_otp_submit_form">Back</a>
                <input type="hidden" id="card_id" name="card_id">
                <img id="reg_loading" src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading_second.gif" style="display:none;">
             </div>  
        </div> 
    </div>
</div>
<?php $this->endWidget(); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form-validator.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#profile_image').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#thumb-output').html(''); //clear html of output element
            var data = $(this)[0].files; //this file data
            $.each(data, function(index, file){ //loop though each file
                if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element
                        $('#thumb-output').append(img); //append image to output element
                    };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
           
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
    });
});
$.validate({
	reCaptchaSiteKey: '6LfEx2MUAAAAAF_cI9xendqXddcG0FfiagYkBzcb',
	reCaptchaTheme: 'light'
});

function checkUnity(param,key,table){
	var value=$(param).val();
	if(value!=null || value!=""){
    	$('#submit_reg').html('Loading').css({'cursor':'not-allowed'}).attr('disabled',true);
    	$.ajax({
            url:'<?php echo Yii::app()->request->baseUrl;?>/site/check_unity',
            type:'POST',
            dataType:'json',
            data:{'value':value,'key':key,'table':table},
            success:function(data){
                if(data.status=="false"){
    				$('#'+key).html(data.msg).css({'color':data.color});
                }else{
                	$('#submit_reg').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
                	$('#'+key).html("");
                }
            }
        })
	}
}

$(document).ready(function() {
	$('#Login_password').keyup(function() {
		$('#result').html(checkStrength($('#Login_password').val()))
	})
	$('#Login_confirm_password').keyup(function() {
		$('#result_confirm').html(checkStrength_confirm($('#Login_confirm_password').val(),$('#Login_password').val()))
	})
	function checkStrength_confirm(confirm_password,password){
		var strength = 0;
		if(confirm_password.length == 0){
			$('#result_confirm').removeClass()
        	$('#password_strength_confirm').html(' ');
        	$('#submit_reg').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
		}else if(confirm_password!=password){
			$('#result_confirm').removeClass()
			$('#result_confirm').addClass('short')
			$('#password_strength_confirm').html("Password mis-match").css({'color':'#FF0000'});
			$('#submit_reg').html('Register').css({'cursor':'pointer'}).attr('disabled',true);
		}else{
			$('#result_confirm').removeClass()
			var class_name = $('#result').attr('class');
        	$('#result_confirm').addClass(class_name);
        	if(class_name=="short"){
        		style_name = '#FF0000';
        	}else if(class_name=="weak"){
        		style_name = 'orange';
            }else if(class_name=="good"){
            	style_name = '#2D98F3';
            }else if(class_name=="strong"){
            	style_name = 'limegreen';
            }else if(class_name=="strongest"){
            	style_name = '#00a65a';
            }
        	$('#password_strength_confirm').html('Matched').css({'color':style_name});
        	$('#submit_reg').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
		}
	}
	function checkStrength(password) {
    	var strength = 0
    	if(password.length == 0){
    		$('#result').removeClass()
        	//$('#result').addClass('short')
        	$('#password_strength').html(' ');
        	$('#submit_reg').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
    	}else if (password.length < 8) {
        	$('#result').removeClass()
        	$('#result').addClass('short')
        	$('#password_strength').html('Too short').css({'color':'#FF0000'});
        	$('#submit_reg').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
    	}else{
        	if (password.length >= 8) strength += 1
        	// If password contains both lower and uppercase characters, increase strength value.
        	if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
        	// If it has numbers and characters, increase strength value.
        	if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
        	// If it has one special character, increase strength value.
        	if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
        	// If it has two special characters, increase strength value.
        	if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
        	// Calculated strength value, we can return messages
        	// If value is less than 2
        	//alert(strength);
        	if(strength==0){
        		$('#result').removeClass();
        		$('#password_strength').html('');
            	$('#submit_reg').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
            }else if (strength < 2) {
            	$('#result').removeClass()
            	$('#result').addClass('weak')
            	$('#password_strength').html('Weak').css({'color':'orange'});
            	$('#submit_reg').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
        	} else if (strength == 2) {
            	$('#result').removeClass()
            	$('#result').addClass('good')
            	$('#password_strength').html('Good').css({'color':'#2D98F3'});
            	$('#submit_reg').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
        	} else if(strength == 3){
            	$('#result').removeClass()
            	$('#result').addClass('strong')
            	$('#password_strength').html('Strong').css({'color':'limegreen'});
            	$('#submit_reg').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
        	} else {
        		$('#result').removeClass()
            	$('#result').addClass('strongest')
            	$('#password_strength').html('Strongest').css({'color':'#00a65a'});
            	$('#submit_reg').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
            }
    	}
	}
});
</script>