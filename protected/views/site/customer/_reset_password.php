<p class="login-box-msg">Forgot Password</p>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'forgot-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true
            ),
            'htmlOptions' => array(
                'class' => 'separate-sections'
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
        <div  class="form-group has-feedback">
            <?php echo $form->PasswordField($login, 'password', array('id'=>'Login_password_reset','class'=>'form-control','placeholder' => 'Password','autocomplete'=>"off",'data-validation'=>"required")); ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span id="result_password"></span>&nbsp&nbsp <span id="password_strength_reset"></span>
        </div>
        <div  class="form-group has-feedback">
            <?php echo $form->PasswordField($login, 'confirm_password', array('id'=>'Login_confirm_password_reset','class'=>'form-control','placeholder' => 'Confirm Password','autocomplete'=>"off",'data-validation'=>"required")); ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span id="result_confirm_password"></span>&nbsp&nbsp <span id="password_strength_reset_confirm"></span>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <span id="span_msg"></span>
                <input type="hidden" name="Login[username_input]" id="Login_username_input">
                <input type="hidden" name="Login[userType]" value="0"/>
                <button name="forgotform" id="forgot_pass_btn" type="submit" class="btn btn-block btn-flat loginbtn">Submit</button>
                <a href="javascript:void(0);" style="float:right;padding:10px;" id="back_to_submit_otp_form">Back</a>
            </div>
        </div>         
<?php $this->endWidget(); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/sweetalert2.all.min.js"></script>
<style>
#password_strength_reset{font-size:12px;}
#password_strength_reset_confirm {
    font-size: 12px;
}
.short{
font-weight:bold;
color:#FF0000;
padding-right: 100px;
background-color: #FF0000;
font-size:4px;
height:100%;
}
.weak{
font-weight:bold;
color:orange;
padding-right: 100px;
background-color: orange;
font-size:4px;
height:100%;
}
.good{
font-weight:bold;
color:#2D98F3;
padding-right: 100px;
background-color: #2D98F3;
font-size:4px;
height:100%;
}
.strong{
font-weight:bold;
color: limegreen;
padding-right: 100px;
background-color: limegreen;
font-size:4px;
height:100%;
}
.strongest{
font-weight:bold;
color: #00a65a;
padding-right: 100px;
background-color: #00a65a;
font-size:4px;
height:100%;
}
</style>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form-validator.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#Login_password_reset').keyup(function() {
		$('#result_password').html(checkStrength($('#Login_password_reset').val()))
	})
	$('#Login_confirm_password_reset').keyup(function() {
		$('#result_confirm_password').html(checkStrength_confirm($('#Login_confirm_password_reset').val(),$('#Login_password_reset').val()))
	})
	function checkStrength_confirm(confirm_password,password){
		var strength = 0;
		if(confirm_password.length == 0){
			$('#result_confirm_password').removeClass()
        	//$('#result').addClass('short')
        	$('#password_strength_reset_confirm').html(' ');
			//$('#password_strength_reset_confirm').html("Password mis-match").css({'color':'#FF0000'});
        	$('#submit_reg').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
		}else if(confirm_password!=password){
			$('#result_confirm_password').removeClass()
			$('#result_confirm_password').addClass('short')
			$('#password_strength_reset_confirm').html("Password mis-match").css({'color':'#FF0000'});
			$('#submit_reg').html('Register').css({'cursor':'pointer'}).attr('disabled',true);
		}else{
			$('#result_confirm_password').removeClass()
			var class_name = $('#result_password').attr('class');
        	$('#result_confirm_password').addClass(class_name);
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
        	$('#password_strength_reset_confirm').html('Matched').css({'color':style_name});
        	$('#submit_reg').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
		}
	}
	function checkStrength(password) {
    	var strength = 0
    	if(password.length == 0){
    		$('#result_password').removeClass()
        	//$('#result').addClass('short')
        	$('#password_strength_reset').html(' ');
        	$('#submit_reg').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
    	}else if (password.length < 8) {
        	$('#result_password').removeClass()
        	$('#result_password').addClass('short')
        	$('#password_strength_reset').html('Too short').css({'color':'#FF0000'});
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
        		$('#result_password').removeClass();
        		$('#password_strength_reset').html('');
            	$('#submit_reg').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
            }else if (strength < 2) {
            	$('#result_password').removeClass()
            	$('#result_password').addClass('weak')
            	$('#password_strength_reset').html('Weak').css({'color':'orange'});
            	$('#submit_reg').html('Register').css({'cursor':'not-allowed'}).attr('disabled',true);
        	} else if (strength == 2) {
            	$('#result_password').removeClass()
            	$('#result_password').addClass('good')
            	$('#password_strength_reset').html('Good').css({'color':'#2D98F3'});
            	$('#submit_reg').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
        	} else if(strength == 3){
            	$('#result_password').removeClass()
            	$('#result_password').addClass('strong')
            	$('#password_strength_reset').html('Strong').css({'color':'limegreen'});
            	$('#submit_reg').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
        	} else {
        		$('#result_password').removeClass()
            	$('#result_password').addClass('strongest')
            	$('#password_strength_reset').html('Strongest').css({'color':'#00a65a'});
            	$('#submit_reg').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
            }
    	}
	}
});

$('form#forgot-form').submit(function(event){
	$('#forgot_pass_btn').html('loading...').css({'cursor':'not-allowed'}).attr('disabled',true);
    event.preventDefault();
    $.ajax({
        url:'<?php echo Yii::app()->request->baseUrl;?>/site/Forgot',
        type:'POST',
        dataType:'json',
        data:$('form#forgot-form').serialize(),
        success:function(data){
        	$('#forgot_pass_btn').html('Submit').css({'cursor':'pointer'}).attr('disabled',false);
            if(data.status=="false"){
            	swal({
            		  position: 'top-end',
            		  type: 'error',
            		  title: data.message,
            		  showConfirmButton: false,
            		  timer: 2000
            	})
            }else{
            	window.location.href="<?php echo Yii::app()->baseUrl?>";
            }
        }
    })
});
</script>