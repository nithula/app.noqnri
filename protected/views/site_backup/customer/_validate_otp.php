<p class="login-box-msg">Validate OTP</p>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'validate_otp',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true
            ),
            'htmlOptions' => array(
                'class' => 'separate-sections'
            )
        ));
        ?>
        <div class="alert alert-success" id="success_div" style="display: none;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <span id="success_msg"></span>
        </div>
        <div class="alert alert-error" id="error_div" style="display: none;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Oh Snap!</strong><span id="error_msg"></span>
        </div>
        <div  class="form-group has-feedback">
            <?php echo $form->textField($card, 'card_number', array('id'=>'validate_card_number','class'=>'form-control','placeholder' => '16 Digit Card Number','autocomplete'=>"off",'maxlength'=>"16",'readonly'=>true)); ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div  class="form-group has-feedback" id="phone_number_hid">
            <?php echo $form->textField($card, 'phone_number_hidden', array('id'=>'validate_phone_number_hidden','class'=>'form-control','placeholder' => 'Phone Number','autocomplete'=>"off",'readonly'=>true)); ?>
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
        <div  class="form-group has-feedback" id="phone_number">
            <?php echo $form->textField($card, 'phone_number', array('id'=>'validate_conform_Phone','class'=>'form-control','placeholder' => 'Phone Number','autocomplete'=>"off",'readonly'=>true)); ?>
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
        <div  class="form-group has-feedback" id="otp_confirm" style="margin-bottom: 0px;">
                <?php echo $form->passwordField($card, 'otp', array('class'=>'form-control','placeholder' => 'OTP','autocomplete'=>"off")); ?>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <span class="validate_class"></span>
        </div>
        <div  class="form-group has-feedback">
               <a href="javascript:void(0);" style="float:right;padding:10px;" id="re_request_otp">Re-request for OTP</a> 
        </div>
        <div class="button_box"id="button_box">
            <div class="row">
                <div class="col-xs-12">
                    <span id="span_msg"></span>
                    <button name="forgotform" id="submit_otp_btn" type="submit" class="btn btn-block btn-flat loginbtn">Submit OTP</button>
                    <a href="javascript:void(0);" style="float:right;padding:10px;" id="back_to_otp_form">Back</a>
                </div>
            </div>    
        </div>            
<?php $this->endWidget(); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/sweetalert2.all.min.js"></script> 
<script type="text/javascript">
$('#re_request_otp').click(function(){
	$('#submit_otp_btn').html('Re-requsting OTP').attr('disabled',true);
	$('#Card_otp').val('');
	var card_number = $('#validate_card_number').val();
	var phone_number = $('#validate_conform_Phone').val();
	form_redirector = $('#form_redirector').val();
	$.ajax({
        url:'<?php echo Yii::app()->request->baseUrl;?>/card/requestOtp',
        type:'POST',
        dataType:'json',
        data:{'value':card_number,'phone_number':phone_number,'form_redirector':form_redirector},
        success:function(data){
        	$('#submit_otp_btn').html('Submit OTP').attr('disabled',false);
            if(data.status=="false"){
            	setTimeout(function(){
                	swal({
              		  position: 'top-end',
              		  type: 'error',
              		  title: data.msg,
              		  showConfirmButton: false,
              		  timer: 2000
              		})
            	});
            }else{
            	setTimeout(function(){
                	swal({
              		  position: 'top-end',
              		  type: 'success',
              		  title: data.msg,
              		  showConfirmButton: false,
              		  timer: 2000
              		})
            	});
            }
        }
    })
});
</script>