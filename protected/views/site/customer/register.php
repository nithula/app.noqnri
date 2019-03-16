<!DOCTYPE html>
<html>
    <head>
        <title>Customer Registration</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">   
      	<link rel="icon" type="image/png" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon_fork.ico"> 
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/font-awesome.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/ionicons.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/dist/css/AdminLTE.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/animate.min.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/additional_style.css">
 		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    </head>
    <body class="hold-transition login-page" id="login">
        <div class="login-box" id="partner-login-box">
        	<?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php endif; ?>
            <?php if (Yii::app()->user->hasFlash('error')): ?>
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo Yii::app()->user->getFlash('error'); ?>
                </div>
            <?php endif; ?>
            <div class="login-logo">
                <a><img src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/dist/img/site_logo.png"></a>
            </div>
            <div class="login-box-body">
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
                        <div class="form-group has-feedback">
                        	<?php echo $form->labelEx($customer,'first_name'); ?>
                            <?php echo $form->textField($customer, 'first_name', array('class'=>'form-control','placeholder' => 'First Name','autocomplete'=>'off','data-validation'=>"required")); ?>
                            <?php echo $form->error($customer,'first_name',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                        	<?php echo $form->labelEx($customer,'last_name'); ?>
                            <?php echo $form->textField($customer, 'last_name', array('class'=>'form-control','placeholder' => 'Last Name','autocomplete'=>'off','data-validation'=>"required")); ?>
                            <?php echo $form->error($customer,'last_name',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                        	<?php echo $form->labelEx($customer,'email'); ?>
                            <?php echo $form->textField($customer, 'email', array('class'=>'form-control','placeholder' => 'Email ID','autocomplete'=>'off','data-validation'=>"required")); ?>
                            <?php echo $form->error($customer,'email',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                        	<?php echo $form->labelEx($phone,'phone_number'); ?>
                            <?php echo $form->textField($phone, 'phone_number', array('class'=>'form-control','placeholder' => 'Phone Number','autocomplete'=>'off','data-validation'=>"required")); ?>
                            <?php echo $form->error($phone,'phone_number',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                        	<?php echo $form->labelEx($login,'username'); ?>
                            <?php echo $form->textField($login, 'username', array('class'=>'form-control','placeholder' => 'Username','data-validation'=>"required",'autocomplete'=>'off','onkeyup'=>'getUsrname(this)')); ?>
                            <?php echo $form->error($login,'username',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
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
            	<?php $this->endWidget(); ?>
            </div>
        </div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jQuery-2.1.4.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/bootstrap.min.js"></script>
<script type="text/javascript">
function getUsrname(param){
	$('#submit_registration').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
	var value = $(param).val();
	$.ajax({
        url:'<?php echo Yii::app()->request->baseUrl;?>/site/getusername',
        type:'POST',
        dataType:'json',
        data:{'value':value},
        success:function(data){
        	if(data.status=='error'){
                $('#Login_username_em_').html(data.msg).show().css({'color':'#ff0000'});
                //$('#Login_username').val(data.username);
            }else{
            	$('#Login_username_em_').html("Available").show().css({'color':'#48c101'});
            	//$('#Login_username').val(data.username);
            	$('#submit_registration').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
            }
        }
    })
}

$("#Login_username").bind('paste', function() {
	$('#submit_registration').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
	var value = $(this).val();
	$.ajax({
        url:'<?php echo Yii::app()->request->baseUrl;?>/site/getusername',
        type:'POST',
        dataType:'json',
        data:{'value':value},
        success:function(data){
        	if(data.status=='error'){
                $('#Login_username_em_').html(data.msg).show().css({'color':'#ff0000'});
                //$('#Login_username').val(data.username);
            }else{
            	$('#Login_username_em_').html("").show().css({'color':'#48c101'});
            	//$('#Login_username').val(data.username);
            	$('#submit_registration').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
            }
        }
    })
});

/*$('#Login_username').on('blur',function(){
	$('#submit_registration').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
	var value = $(this).val();
	$.ajax({
        url:'<?php echo Yii::app()->request->baseUrl;?>/site/getusername',
        type:'POST',
        dataType:'json',
        data:{'value':value},
        success:function(data){
        	if(data.status=='error'){
                $('#Login_username_em_').html(data.msg).show();
                //$('#Login_username').val(data.username);
            }else{
            	$('#Login_username_em_').html("").show();
            	$('#Login_username').val(data.username);
            	$('#submit_registration').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
            }
        }
    })
});*/
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