<p class="login-box-msg">Validate Username</p>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'validate_username',
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
            <?php echo $form->textField($login, 'username', array('class'=>'form-control','placeholder' => 'Username','autocomplete'=>"off",'maxlength'=>"16")); ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span class="validate_class"></span>
        </div>
        <div class="button_box"id="button_box">
            <div class="row">
                <div class="col-xs-12">
                    <span id="span_msg"></span>
                    <button name="validateform" id="validate_username_btn" type="submit" class="btn btn-block btn-flat loginbtn">Validate username</button>
                    <a href="javascript:void(0);" style="float:right;padding:10px;" id="validate_card_back">Back</a>
                </div>
            </div>    
        </div>            
<?php $this->endWidget(); ?>