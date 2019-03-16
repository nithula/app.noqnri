<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'admin-form',
    'enableAjaxValidation'=>true,
)); ?>  
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
<p class="help-block">Fields with <span class="required">*</span> are required.</p>
<div class="row">
  <div class="col-md-6">
     <div class="box box-primary">
        <div class="box-header with-border"></div>
           <div class="box-body">
				<div class="form-group">
                  <div class="form-group">
                      <?php echo $form->labelEx($model,'first_name'); ?>
                      <?php echo $form->textField($model,'first_name',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                      <?php echo $form->error($model,'first_name'); ?>
                  </div>
                  <div class="form-group">
                      <?php echo $form->labelEx($model,'address'); ?>
                      <?php echo $form->textArea($model,'address',array('class'=>'form-control','maxlength'=>500,'autocomplete'=>'off')); ?>
                      <?php echo $form->error($model,'address'); ?>
                  </div>
                  <div class="form-group">
                    <div class="row">
                    	<div class="col-md-4">
                    	<?php echo $form->labelEx($model,'gender'); ?>
                        <?php
                    		$accountStatus = array('M'=>'Male', 'F'=>'Female');
                    		echo $form->radioButtonList($model,'gender',$accountStatus,array('class'=>'col-md-4'));
                    	?>
                    	<?php echo $form->error($model,'gender'); ?>
                    	</div>
                    </div>
                  </div> 
                  <?php if($model->id){?>
                      <div class="form-group">
                          <?php echo $form->labelEx($model,'username'); ?>
                          <?php echo $form->textField($model,'username',array('class'=>'form-control','maxlength'=>150,'readonly'=>true,'disabled'=>'disabled')); ?>
                          <?php echo $form->error($model,'username'); ?>
                      </div> 
                  <?php }else{?>
                  	  <div class="form-group">
                          <?php echo $form->labelEx($model,'username'); ?>
                          <?php echo $form->textField($model,'username',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                          <?php echo $form->error($model,'username'); ?>
                      </div>
                  <?php }?>                
				</div> 
			</div>
		</div>
	</div>
	<div class="col-md-6">
     <div class="box box-danger">
        <div class="box-header with-border"></div>
           <div class="box-body">
				<div class="form-group">
					<div class="form-group">
                      <?php echo $form->labelEx($model,'last_name'); ?>
                      <?php echo $form->textField($model,'last_name',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                      <?php echo $form->error($model,'last_name'); ?>
                  	</div>
                  	<div class="form-group">
                      <?php echo $form->labelEx($model,'phone'); ?>
                      <?php echo $form->textField($model,'phone',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                      <?php echo $form->error($model,'phone'); ?>
                  	</div>
                  	<div class="form-group">
                      <?php echo $form->labelEx($model,'email_id'); ?>
                      <?php echo $form->textField($model,'email_id',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                      <?php echo $form->error($model,'email_id'); ?>
                  	</div>
                  	<div class="form-group">
              		  <?php echo $form->labelEx($model,'dob'); ?>
                      <?php echo $form->textField($model, 'dob', array('class'=>'form-control date','placeholder' => 'Date Of Birth','autocomplete'=>'off')); ?>
                      <?php echo $form->error($model,'dob',array('style'=>'color:#FF0000'));?>
                    </div>
                    <?php if(!$model->id){?>
                        <div class="form-group">
                  		  <?php echo $form->labelEx($model,'password_filed'); ?>
                          <?php echo $form->PasswordField($model, 'password_filed', array('class'=>'form-control','placeholder' => 'Password','autocomplete'=>'off')); ?>
                          <?php echo $form->error($model,'password_filed',array('style'=>'color:#FF0000'));?>
                          <span id="result"></span>&nbsp&nbsp <span id="password_strength"></span>
                        </div>
                    <?php }?>
                  <div class="form-group">
                	<?php $this->widget('bootstrap.widgets.TbButton', array(
                		'buttonType'=>'submit',
                		'type'=>'primary',
                	    'htmlOptions'=>array('id'=>'submit_reg'),
                		'label'=>$model->isNewRecord ? 'Save' : 'Update',
                	)); ?>
                	<?php if(!$model->id){?>
                	<?php
                        echo CHtml::htmlButton('Reset',array(
                            "id"=>'chtmlbutton',
                            "class"=>'btn btn-secondary'
                            
                        ));
                    ?>
                    <?php }?>
                 </div>
				</div>
			</div>
		</div>
	</div>			
</div>
<?php $this->endWidget(); ?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script> -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form-validator.min.js"></script>
<script type="text/javascript">
$('#Admin_dob').datepicker({
    autoclose: true
})
$.validate({
    //modules : 'date'
	reCaptchaSiteKey: '6LfEx2MUAAAAAF_cI9xendqXddcG0FfiagYkBzcb',
	reCaptchaTheme: 'light'
});
$(document).ready(function() {
	$('#Admin_password_filed').keyup(function() {
		$('#result').html(checkStrength($('#Admin_password_filed').val()))
	})
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
<style>
#password_strength{font-size:12px;}
#admin-form .short{
font-weight:bold;
color:#FF0000;
padding-right: 100px;
background-color: #FF0000;
font-size:4px;
height:100%;
}
#admin-form .weak{
font-weight:bold;
color:orange;
padding-right: 100px;
background-color: orange;
font-size:4px;
height:100%;
}
#admin-form .good{
font-weight:bold;
color:#2D98F3;
padding-right: 100px;
background-color: #2D98F3;
font-size:4px;
height:100%;
}
#admin-form .strong{
font-weight:bold;
color: limegreen;
padding-right: 100px;
background-color: limegreen;
font-size:4px;
height:100%;
}
#admin-form .strongest{
font-weight:bold;
color: #00a65a;
padding-right: 100px;
background-color: #00a65a;
font-size:4px;
height:100%;
}
</style>