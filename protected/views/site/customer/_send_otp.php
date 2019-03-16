<p class="login-box-msg">Send OTP</p>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'send_otp',
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
            <?php echo $form->textField($card, 'card_number', array('id'=>'otp_card_number','class'=>'form-control','placeholder' => '16 Digit Card Number','autocomplete'=>"off",'maxlength'=>"16",'readonly'=>true)); ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span class="validate_class"></span>
        </div>
        <div  class="form-group has-feedback" id="phone_number_hid">
            <?php echo $form->textField($card, 'phone_number_hidden', array('id'=>'otp_phone_number_hidden','class'=>'form-control','placeholder' => 'Phone Number','autocomplete'=>"off",'readonly'=>true)); ?>
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
        <div  class="form-group has-feedback" id="phone_number">
            <?php echo $form->textField($card, 'phone_number', array('id'=>'otp_phone_number','class'=>'form-control','placeholder' => 'Phone Number','autocomplete'=>"off",'readonly'=>true)); ?>
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
        <div class="button_box"id="button_box">
            <div class="row">
                <div class="col-xs-12">
                    <span id="span_msg"></span>
                    <button name="forgotform" id="send_otp_btn" type="submit" class="btn btn-block btn-flat loginbtn">Send OTP</button>
                    <a href="javascript:void(0);" style="float:right;padding:10px;" id="back_to_confirm_phone_form">Back</a>
                </div>
            </div>    
        </div>            
<?php $this->endWidget(); ?>