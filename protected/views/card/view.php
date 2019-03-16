<?php
    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'card-form',
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="row">
      <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-header with-border"></div>
               <div class="box-body">
    				<div class="form-group">
                      <div class="form-group">
                          <?php echo $form->labelEx($model,'card_number'); ?>
                          <?php echo $form->textField($model,'card_number',array('class'=>'form-control','maxlength'=>16,'autocomplete'=>'off','data-validation'=>"required")); ?>
                          <?php echo $form->error($model,'card_number'); ?>
                          <span class="error-msg"></span>
                      </div>
                      <div class="form-group">
                          <?php echo $form->labelEx($model,'phone_number'); ?>
                          <?php echo $form->textField($model,'phone_number',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                          <?php echo $form->error($model,'phone_number'); ?>
                      </div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
<?php $this->endWidget(); ?>