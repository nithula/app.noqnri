<p class="login-box-msg">please log in</p>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
    'htmlOptions' => array(
        'class' => 'separate-sections'
    )
));
?>
<?php if (Yii::app()->user->hasFlash('error')): ?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Oh Snap!</strong> <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?> 
<div  class="form-group has-feedback">
    <?php echo $form->textField($model, 'username', array('class'=>'form-control','placeholder' => 'Username')); ?>
    <?php echo $form->error($model,'username',array('style'=>'color:#FF0000'));?>
    <!--<input type="email" name="user_email" id="user_email" class="form-control" placeholder="Email or Username">-->
    <span class="glyphicon glyphicon-user form-control-feedback"></span>
</div>
<div class="form-group has-feedback">
    <?php echo $form->passwordField($model, 'password', array('class'=>'form-control','placeholder' => 'Password')); ?>
    <?php echo $form->error($model,'password',array('style'=>'color:#FF0000')); ?>
    <!--<input type="password" name="user_password" id="user_password" class="form-control" placeholder="Password">-->
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php echo CHtml::tag('button', array(
	        'name'=>'loginform',
	        'class'=>'btn btn-block btn-flat loginbtn',
	        'type'=>'submit'
	      ), '<i class="ace-icon fa fa-key"></i><span class="bigger-110"> log in</span>'); ?>
        
    </div>
    <div class="col-xs-12">
        <div class="col-sm-6">
            <a href="javascript:void(0);" style="float:left;padding-top:10px;" id="forgot_page_display">Forgot Password</a>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>