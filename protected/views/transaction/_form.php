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
				  <div class="form-group has-feedback"">
                    	<?php echo $form->labelEx($model,'l_card_id'); ?>
                    	<?php 
                    	$type_list=CHtml::listData(Card::model()->findAllByAttributes(array('card_issue_status'=>'Approved')),'id','card_number');
                    	echo CHtml::activeDropDownList($model,'l_card_id',$type_list,array('class'=>'form-control select2 special','empty'=>'Select Option','data-validation'=>'required')); 
                    	?>
                  </div>
                  <div class="form-group">
                      <?php echo $form->labelEx($model,'trans_amount'); ?>
                      <?php echo $form->textField($model,'trans_amount',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off','placeholder'=>'Transaction Amount','data-validation'=>'required')); ?>
                      <?php echo $form->error($model,'trans_amount'); ?>
                  </div>
                  <div class="form-group">
                      <?php echo $form->labelEx($model,'trans_ref_no'); ?>
                      <?php echo $form->textField($model,'trans_ref_no',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off','placeholder'=>'Transaction Reference Number','data-validation'=>'required')); ?>
                      <?php echo $form->error($model,'trans_ref_no'); ?>
                  </div>
                  <div class="form-group">
                      <?php echo $form->labelEx($model,'trans_currency'); ?>
                      <?php echo $form->textField($model,'trans_currency',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off','placeholder'=>'Transaction Currency','data-validation'=>'required')); ?>
                      <?php echo $form->error($model,'trans_currency'); ?>
                  </div>
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
                      <?php echo $form->labelEx($model,'trans_currency_rate'); ?>
                      <?php echo $form->textField($model,'trans_currency_rate',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off','placeholder'=>'Transaction Currency Rate','data-validation'=>'required')); ?>
                      <?php echo $form->error($model,'trans_currency_rate'); ?>
                  </div>
                  <div class="form-group">
                        <label>Transaction Date</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <?php echo $form->textField($model, 'trans_date', array('class'=>'form-control date','placeholder' => 'Transaction Date','data-validation'=>"required",'data-validation'=>'required')); ?>
                          <?php echo $form->error($model,'trans_date',array('style'=>'color:#FF0000'));?>
                        </div>
                  </div>
                  <div class="form-group">
                      <?php echo $form->labelEx($model,'points_earned'); ?>
                      <?php echo $form->textField($model,'points_earned',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off','placeholder'=>'Points Earned','readonly'=>true)); ?>
                      <?php echo $form->error($model,'points_earned'); ?>
                  </div>
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
                        <?php echo CHtml::link('Cancel',array('transaction/index'),array('class'=>'btn btn-danger')); ?>
                     </div>
				</div> 
			</div>
		</div>
	</div>
</div>	
<?php $this->endWidget(); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form-validator.min.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
$.validate({
    //modules : 'date'
});
$('#Transaction_trans_date').datepicker({
    autoclose: true,
    format: 'yyyy/mm/dd',
})
</script>