<!DOCTYPE html>
<html>
    <head>
        <title>Customer Login</title>
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
            	<div id="login_content">
                    <?php $this->renderPartial('//site/customer/_login',array('model' => $model));?>
                </div>
    			<div id="validate_card" style="display:none;">
                    <?php $this->renderPartial('//site/customer/_validate_card',array('card'=>$card));?>
                </div>
                <div id="confirm_phone_number" style="display:none;">
                    <?php $this->renderPartial('//site/customer/_confirm_phone_number',array('card'=>$card));?>
                </div>
                <div id="send_otp" style="display:none;">
                    <?php $this->renderPartial('//site/customer/_send_otp',array('card'=>$card));?>
                </div>
                <div id="submit_otp" style="display:none;">
                    <?php $this->renderPartial('//site/customer/_validate_otp',array('card'=>$card));?>
                </div>
                <div id="password_reset" style="display:none;">
                    <?php $this->renderPartial('//site/customer/_reset_password',array('login' => $login));?>
                </div>
                <input type="hidden" id="form_redirector">
			</div>
        </div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jQuery-2.1.4.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	<?php if (Yii::app()->user->hasFlash('success_flash_msg')){?>
	setTimeout(function(){
		swal({
		  position: 'top-end',
		  type: 'success',
		  title: '<?php echo Yii::app()->user->getFlash('success_flash_msg'); ?>',
		  showConfirmButton: false,
		  timer: 4000
		})
	}, 2000);
	<?php } ?>
    <?php if (Yii::app()->user->hasFlash('error_flash_msg')){ ?>
    setTimeout(function(){
    	swal({
		  position: 'top-end',
		  type: 'error',
		  title: '<?php echo Yii::app()->user->getFlash('error_flash_msg'); ?>',
		  showConfirmButton: false,
		  timer: 4000
		})
    }, 2000);
    <?php } ?>
});


// Display card validation form from signup link
$('#validate_card_signup').on('click',function(){
      $('form')[0].reset();
      $('#login_content').hide();
      $('#validate_card').show().addClass('animated zoomIn');
      $('form')[0].reset();
      $('#form_redirector').val('1');
      $('html, body').animate({scrollTop: '+=150px'}, 800);
});

// Display card validation form from forgot link
$('#validate_card_forgot').on('click',function(){
      $('form')[0].reset();
      $('#login_content').hide();
      $('#validate_card').show().addClass('animated zoomIn');
      $('#form_redirector').val('0');
      $('html, body').animate({scrollTop: '+=150px'}, 800);
});

// Back from card validation form
$('#back_to_login_form').on('click',function(){
    $('form')[0].reset();
    $('.validate_class').html('');
    $('#validate_card').hide();
    $('#login_content').show().addClass('animated zoomIn');
});

// Back from Confirm mobile 
$('#back_to_card_form').on('click',function(){
    $('form')[0].reset();
    $('.validate_class').html('');
    $('#confirm_phone_number').hide();
    $('#validate_card').show().addClass('animated zoomIn');
});

//Back from submit OTP to send otp
$('#back_to_confirm_phone_form').on('click',function(){
    $('form')[0].reset();
    $('.validate_class').html('');
    $('#send_otp').hide();
    $('#confirm_phone_number').show().addClass('animated zoomIn');
});

// Back from send OTP
$('#back_to_otp_form').on('click',function(){
    $('form')[0].reset();
    $('.validate_class').html('');
    $('#submit_otp').hide();
    $('#send_otp').show().addClass('animated zoomIn');
});

//Back from reset password to otp validate form
  $('#back_to_submit_otp_form').on('click',function(){
      $('form')[0].reset();
      $('#password_reset').hide();
      $('#submit_otp').show().addClass('animated zoomIn');
  });

/********************************** Validate Card  *********************************/
$('#validate_card_btn').on('click',function(e){
	e.preventDefault();
	var lenght = $("#Card_card_number").val().replace(/ /g,'').length
	if(lenght=='16'){
		value = $("#Card_card_number").val();
		form_redirector = $('#form_redirector').val();
		$('#validate_card_btn').html('Validating your card..!').attr('disabled',true);
		$.ajax({
            url:'<?php echo Yii::app()->request->baseUrl;?>/site/Check_card',
            type:'POST',
            dataType:'json',
            data:{'value':value,'form_redirector':form_redirector},
            success:function(data){
            	$('#validate_card_btn').html('Validate card').attr('disabled',false);
                if(data.status=="false"){
                	$('.validate_class').html(data.msg).css({'color':'#B72C3D'});
                }else{
                	$('.validate_class').html('').hide();
                	$('#validate_card').hide();
                	if(form_redirector=="1"){
                    	if(data.card_issue_status=='Verified'){
                        	$('#confirm_phone_back').hide(); // button hide
                        	$('#common_to_confirm').show(); // button show
                        	$('#confirm_phone_number').show();
                        	$("#conform_card_number").val(value);
                        	$('#conform_phone_number_hidden').show().val(data.phone);
                    	}else if(data.card_issue_status=='OTP'){
                    		$('#send_otp').show();
                    		$('#otp_back').hide(); // button hide
                        	$('#common_to_otp').show(); // button show
                        	$("#otp_card_number").val(value);
                        	$('#otp_phone_number_hidden').show().val(data.phone);
                        	$('#otp_phone_number').val(data.phone_number);
                        }else if(data.card_issue_status=='Registration'){	
                        	/*$('.login-box').css({'width': '700px'});
                        	$('#register_content').show();
                        	$('#register_content_back').hide(); // button hide
                        	$('#common_to_regi').show(); // button show
                        	$('#Login_username').val(value).attr('readonly',true);
                        	$('#Phone_phone_number').val(data.phone_number).attr('readonly',true);
                        	$('#card_id').val(value);
                        	$('html, body').animate({scrollTop: '+=200px'}, 800);*/
                        	$('.login-box-body').html('<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading_second.gif">').css({'text-align': 'center'});
                        	window.location.href="<?php echo Yii::app()->request->baseUrl;?>/site/show_customer_registration/phone/"+data.phone_number;
                        }else if(data.card_issue_status=='Approved'){
                        	$('#validate_card').show();
    						$('.validate_class').html('Card number already registered').show().css({'color':'#006400'});
    						$('#validate_card_btn').html('Already registered').attr('disabled',false);
                        }
                	}else{
                		if(data.card_issue_status=='Verified'||data.card_issue_status=='OTP'||data.card_issue_status=='Registration'){
                			$('#validate_card').show();
    						$('.validate_class').html('Card not resgistered..!').show().css({'color':'#B72C3D'});
    						$('#validate_card_btn').html('Submit').attr('disabled',false);
                    	}else{
                        	$('#confirm_phone_back').hide(); // button hide
                        	$('#common_to_confirm').show(); // button show
                        	$('#Login_username_input').val(value);
                        	$('#confirm_phone_number').show();
                        	$("#conform_card_number").val(value);
                        	$('#conform_phone_number_hidden').show().val(data.phone);
                        }                		
                    }
                }
            }
        })
	}else{
		$('.validate_class').html('Card number should be 16 digit').css({'color':'#B72C3D'}).show();
	}
});


/********************************** Confirming Phone Number  *********************************/
$('#validate_phone_btn').on('click',function(e){
	e.preventDefault();
	var lenght = $("#conform_phone_number").val().replace(/ /g,'').length
	if(lenght>='10'){
		value = $("#conform_phone_number").val();
		card_number = $("#conform_card_number").val(); 
		form_redirector = $('#form_redirector').val();
		$('#validate_phone_btn').html('Confirming phone number..!').attr('disabled',true);
		$.ajax({
            url:'<?php echo Yii::app()->request->baseUrl;?>/site/Check_send_phone',
            type:'POST',
            dataType:'json',
            data:{'value':value,'card_number':card_number,'flag':'0','form_redirector':form_redirector},
            success:function(data){
            	$('#validate_phone_btn').html('Confirm phone number').attr('disabled',false);
                if(data.status=="false"){
                	$('.phone_validate_class').html(data.msg).css({'color':'#B72C3D'}).show();
                }else{
                	$('.phone_validate_class').html('').hide();
                	$('#confirm_phone_number').hide();
                	$('#send_otp').show();
                	$("#otp_card_number").val(card_number);
                	$('#otp_phone_number_hidden').show().val(data.phone);
                	$('#otp_phone_number').val(value);
                }
            }
        })
	}else{
		$('.validate_class').html('Card number should be 16 digit').css({'color':'#B72C3D'}).show();
	}
});


/*************************************** Send OTP *************************************/
 $('#send_otp_btn').on('click',function(e){
	e.preventDefault();
	var lenght = $("#otp_phone_number").val().replace(/ /g,'').length
	if(lenght>='10'){
		value = $("#otp_phone_number").val();
		card_number = $("#otp_card_number").val(); 
		form_redirector = $('#form_redirector').val();
		$('#send_otp_btn').html('Sending OTP..!').attr('disabled',true);
		$.ajax({
            url:'<?php echo Yii::app()->request->baseUrl;?>/site/Check_send_phone',
            type:'POST',
            dataType:'json',
            data:{'value':value,'card_number':card_number,'flag':'1','form_redirector':form_redirector},
            success:function(data){
            	$('#send_otp_btn').html('Send OTP').attr('disabled',false);
                if(data.status=="false"){
                	$('.validate_class').html(data.msg).css({'color':'#B72C3D'}).show();
                }else{
                	$('.validate_class').html('').hide();
                	$('#send_otp').hide();
                	$('#submit_otp').show();
                	$("#validate_card_number").val(card_number);
                	$('#validate_phone_number_hidden').show().val(data.phone);
                	$('#validate_conform_Phone').val(value);
                }
            }
        })
	}else{
		$('.validate_class').html('Card number should be 16 digit').css({'color':'#B72C3D'}).show();
	}
});

/******************************************* Submit Otp ********************************************/
 $('#submit_otp_btn').on('click',function(e){
	e.preventDefault();
	var lenght = $("#Card_otp").val().replace(/ /g,'').length
	if(lenght>='4'){
		value = $("#validate_conform_Phone").val();
		card_number = $("#validate_card_number").val(); 
		form_redirector = $('#form_redirector').val();
		otp = $('#Card_otp').val();
		form_redirector = $('#form_redirector').val();
		$('#submit_otp_btn').html('validating OTP').attr('disabled',true);
		$.ajax({
            url:'<?php echo Yii::app()->request->baseUrl;?>/site/Check_otp',
            type:'POST',
            dataType:'json',
            data:{'value':value,'card_number':card_number,'otp':otp,'form_redirector':form_redirector},
            success:function(data){
            	$('#submit_otp_btn').html('Submit OTP').attr('disabled',false);
            	$('#Card_otp').val('');
                if(data.status=="false"){
                	$('.validate_class').html(data.msg).css({'color':'#B72C3D'}).show();
                }else{
                	$('.validate_class').html('').hide();
                	$('#submit_otp').hide();
                	if(form_redirector=="1"){
                		window.location.href="<?php echo Yii::app()->request->baseUrl;?>/site/show_customer_registration/phone/"+value;
                	}else{
                		$('#Login_username_input').val(card_number);
                		$('#password_reset').show();
                    }
                	$('#Login_username').val(card_number).attr('readonly',true);
                	$('#Phone_phone_number').val(value).attr('readonly',true);
                	$('#card_id').val(card_number);
                }
            }
        })
	}else{
		$('.validate_class').html('OTP should be 4 digit').css({'color':'#B72C3D'}).show();
	}
});
</script>
</body>
</html>





