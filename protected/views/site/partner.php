<!DOCTYPE html>
<html>
    <head>
        <title>Partner Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">   
      	<link rel="icon" type="image/png" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon_fork.ico"> 
        <!-- Bootstrap -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/font-awesome.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/ionicons.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/dist/css/AdminLTE.css" rel="stylesheet" media="screen">
        <!-- bootstrap datepicker -->
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
            </div><!-- /.login-logo -->
            <div class="login-box-body">
            	<div id="login_content">
                    <?php $this->renderPartial('//site/partner/_login',array('model' => $model));?>
                </div>
                <div id="validate_username" style="display:none;">
                    <?php $this->renderPartial('//site/partner/_validate_card',array('login'=>$login));?>
                </div>
                <div id="confirm_phone_number" style="display:none;">
                    <?php $this->renderPartial('//site/partner/_confirm_phone_number',array('login'=>$login,'phone'=>$phone));?>
                </div>
                <div id="send_otp" style="display:none;">
                    <?php $this->renderPartial('//site/partner/_send_otp',array('login'=>$login,'phone'=>$phone));?>
                </div>
                <div id="submit_otp" style="display:none;">
                    <?php $this->renderPartial('//site/partner/_validate_otp',array('login'=>$login,'phone'=>$phone));?>
                </div>
                <div id="reset_content" style="display:none;">
                     <?php $this->renderPartial('//site/partner/_reset_password_partner',array('login'=>$login));?>
                </div>
			</div>
        </div>        
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jstz.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jQuery-2.1.4.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/icheck.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/select2/dist/css/select2.min.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/select2/dist/js/select2.full.min.js"></script>
<style>
.special{width:250px!important;}
.additional{width: 203px;}
.select2-container .select2-selection--single{height: 34px;}
</style>
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

// Display forgot popup and hide login 
  $('#forgot_page_display').on('click',function(){
      $('form')[0].reset();
      $('#login_content').hide();
      $('#validate_username').show().addClass('animated zoomIn');
      $('html, body').animate({scrollTop: '+=150px'}, 800);
});

// Back to login from username form
$('#validate_card_back').on('click',function(){
    $('form')[0].reset();
    $('.validate_class').html('');
    $('#validate_username').hide();
    $('#login_content').show().addClass('animated zoomIn');
});
// Back to card from confirm phone form
$('#back_to_card_form').on('click',function(){
    $('form')[0].reset();
    $('.validate_class').html('');
    $('#confirm_phone_number').hide();
    $('#validate_username').show().addClass('animated zoomIn');
    $('#Login_username').val('');
});
//Back to confirm phone form from send otp form
$('#back_to_confirm_form').on('click',function(){
    $('form')[0].reset();
    $('.validate_class').html('');
    $('#send_otp').hide();
    $('#confirm_phone_number').show().addClass('animated zoomIn');
    $('#confirm_phone_number_val').val('');
});
//Back to send otp form from confirm otp form
$('#back_to_send_otp_form').on('click',function(){
    $('form')[0].reset();
    $('.validate_class').html('');
    $('#submit_otp').hide();
    $('#send_otp').show().addClass('animated zoomIn');
});
//Back to submit otp form from reset form
$('#back_to_submit_otp_form').on('click',function(){
    $('form')[0].reset();
    $('.validate_class').html('');
    $('#reset_content').hide();
    $('#submit_otp').show().addClass('animated zoomIn');
});


/********************************** Validate Username  *********************************/
$('#validate_username_btn').on('click',function(e){
	e.preventDefault();
	var lenght = $("#Login_username").val().replace(/ /g,'').length
	if(lenght>='8'){
		username = $("#Login_username").val();
		$('#validate_username_btn').html('Validating username..!').attr('disabled',true);
		$.ajax({
            url:'<?php echo Yii::app()->request->baseUrl;?>/partner/Check_username',
            type:'POST',
            dataType:'json',
            data:{'username':username},
            success:function(data){
            	$('#validate_username_btn').html('Validate username').attr('disabled',false);
            	window.location.href="<?php echo Yii::app()->baseUrl.'/partner'?>";
                if(data.status=="false"){
                	$('.validate_class').html(data.msg).css({'color':'#B72C3D'});
                }else{
                	$('.validate_class').html('').hide();
                	$('#validate_username').hide();
                	$('#confirm_phone_number').show();
                	$('#confirm_username').val(username);
                	$('#confirm_phone_number_hidden').val(data.phone);
                }
            }
        })
	}else{
		$('.validate_class').html('Enter a valid username').css({'color':'#B72C3D'}).show();
	}
});

/********************************** Validate Phonenumber  *********************************/
$('#validate_phone_btn').on('click',function(e){
	e.preventDefault();
	var phone_number_length = $("#confirm_phone_number_val").val().replace(/ /g,'').length
	if(phone_number_length>='10'){
		phone_number = $("#confirm_phone_number_val").val();
		username = $("#confirm_username").val(); 
		$('#validate_phone_btn').html('Confirming phone number..!').attr('disabled',true);
		$.ajax({
            url:'<?php echo Yii::app()->request->baseUrl;?>/partner/Confirm_phone',
            type:'POST',
            dataType:'json',
            data:{'phone_number':phone_number,'username':username,'flag':'0'},
            success:function(data){
            	$('#validate_phone_btn').html('Confirm phone number').attr('disabled',false);
                if(data.status=="false"){
                	$('.phone_validate_class').html(data.msg).css({'color':'#B72C3D'}).show();
                }else{
                	$('.phone_validate_class').html('').hide();
                	$('#confirm_phone_number').hide();
                	$('#send_otp').show();
                	$("#otp_username").val(username);
                	$('#otp_phone_number_hidden').show().val(data.phone);
                	$('#otp_phone_number').val(phone_number);
                }
            }
        })
	}else{
		$('.phone_validate_class').html('Enter a valid phone number').css({'color':'#B72C3D'}).show();
	}
});

/*************************************** Send OTP *************************************/
$('#send_otp_btn').on('click',function(e){
	e.preventDefault();
	var phone_number_length = $("#otp_phone_number").val().replace(/ /g,'').length
	if(phone_number_length>='10'){
		phone_number = $("#otp_phone_number").val();
		card_number = $("#otp_card_number").val(); 
		username = $("#otp_username").val(); 
		$('#send_otp_btn').html('Sending OTP..!').attr('disabled',true);
		$.ajax({
           url:'<?php echo Yii::app()->request->baseUrl;?>/partner/Confirm_phone',
           type:'POST',
           dataType:'json',
           data:{'phone_number':phone_number,'username':username,'flag':'1'},
           success:function(data){
           	$('#send_otp_btn').html('Send OTP').attr('disabled',false);
               if(data.status=="false"){
               	$('.validate_class').html(data.msg).css({'color':'#B72C3D'}).show();
               }else{
               	$('.validate_class').html('').hide();
               	$('#send_otp').hide();
               	$('#submit_otp').show();
               	$("#validate_username_val").val(username);
               	$('#validate_phone_number_hidden').show().val(data.phone);
               	$('#validate_confirm_Phone').val(phone_number);
               }
           }
       })
	}else{
		$('.phone_validate_class').html('Enter a valid username').css({'color':'#B72C3D'}).show();
	}
});

/******************************************* Submit Otp ********************************************/
$('#submit_otp_btn').on('click',function(e){
	e.preventDefault();
	var otp_length = $("#Login_reset_code").val().replace(/ /g,'').length
	if(otp_length=='4'){
		phone_number = $("#validate_confirm_Phone").val();
		username = $("#validate_username_val").val(); 
		otp = $('#Login_reset_code').val();
		$('#submit_otp_btn').html('validating OTP').attr('disabled',true);
		$.ajax({
           url:'<?php echo Yii::app()->request->baseUrl;?>/partner/Check_otp',
           type:'POST',
           dataType:'json',
           data:{'username':username,'otp':otp},
           success:function(data){
           	$('#submit_otp_btn').html('Submit OTP').attr('disabled',false);
           	$('#Login_reset_code').val('');
               if(data.status=="false"){
               	$('.validate_class').html(data.msg).css({'color':'#B72C3D'}).show();
               }else{
               	$('.validate_class').html('').hide();
               	$('#submit_otp').hide();
           		$('#reset_content').show();
           		$('#Login_username_input').val(username);
               }
           }
       })
	}else{
		$('.validate_class').html('OTP sould be 4 digit').css({'color':'#B72C3D'}).show();
	}
});
</script>
</body>
</html>





