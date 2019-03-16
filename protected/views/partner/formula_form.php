<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'create-new-form',
    'enableAjaxValidation'=>true,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
));
?>
<div class="row">
 	<div class="col-md-12">
     <div class="box box-primary">
           <div class="box-body">
				<div class="form-group">
                  <div class="form-group">
                      <?php echo $form->labelEx($model,'formula'); ?>
                      <?php echo $form->textField($model,'formula',array('class'=>'form-control','maxlength'=>16,'placeholder' => 'Formula','autocomplete'=>'off','data-validation'=>"required")); ?>
                      <?php echo $form->error($model,'formula'); ?>
                      <span id="formula_error"></span>
                  </div>
                  <div class="form-group">
                     <?php echo $form->labelEx($model,'description'); ?>
		    		 <?php echo $form->textArea($model, 'description', array('class'=>'form-control','placeholder' => 'Description','data-validation'=>"required")); ?>
                	 <?php echo $form->error($model,'description',array('style'=>'color:#FF0000'));?>
                      <span id="description_error"></span>
                  </div>
                  
                  <div class="form-group" style="float: right;">
                    	<img id="loading_img" src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading_second.gif" style="display: none;">
                        <?php $this->widget('bootstrap.widgets.TbButton', array(
                    		'buttonType'=>'submit',
                    		'type'=>'primary',
                    	    'htmlOptions'=>array('id'=>'formula_submit'),
                    	    'label'=>'Save',
                    	)); ?>
                    	<input type="hidden" name="Formula[partner_id]" id="Formula_partner_id" value="<?php echo ($partner_id)?$partner_id:'0';?>">
                	  	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            	 	</div>
				</div> 
			</div>
		</div>
	</div>
</div>
<?php $this->endWidget();?> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form-validator.min.js"></script>
<style>
.select2-container .select2-selection--single{height:35px;}
</style>
<script type="text/javascript">
$.validate({
});
$('form#create-new-form').submit(function(event){
	$('#formula_submit').html('loading...').css({'cursor':'not-allowed'}).attr('disabled',true);
	$('#loading_img').show();
    event.preventDefault();
    $.ajax({
        url:'<?php echo Yii::app()->request->baseUrl;?>/partner/submitFormula',
        type:'POST',
        data:$('form#create-new-form').serialize(),
        success:function(data){
        	$('#formula_submit').html('Submit').css({'cursor':'pointer'}).attr('disabled',false);
        	$('#loading_img').hide();
            if(data==0){
            	swal({
            		  position: 'top-end',
            		  type: 'error',
            		  title: 'Error while submit form',
            		  showConfirmButton: false,
            		  timer: 2000
            	})
            }else{
            	$('.modal-content').html(data);
            }
        }
    })
});
</script>