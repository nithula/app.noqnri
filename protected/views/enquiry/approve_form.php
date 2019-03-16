<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Approve enquiry</h4>
</div>
<div class="modal-body">
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
						<div class="form-group" style="text-align:left;">
					 		<?php echo $form->labelEx($model,'address'); ?>
                          	<?php echo $form->textArea($model,'address',array('class'=>'form-control','maxlength'=>200,'data-validation'=>"required","rows"=>"4",'value'=>$model->address,'readonly'=>true)); ?>
                          	<?php echo $form->error($model,'address'); ?>
					 	</div>
					 	<div class="form-group has-feedback" style="text-align:left;">
                        	<?php echo $form->labelEx($model,'status'); ?>
    			    		<?php echo CHtml::dropDownList('status','status',array('Y'=>'Approved','N'=>'Rejected'),array('class'=>'form-control select2 special','empty'=>'Select Option','data-validation'=>'required','onChange'=>'getValue(this)'));?>
                            <?php echo $form->error($model,'status'); ?>
                        </div>
                        <div class="form-group has-feedback" id="card_div" style="text-align:left;display:none;">
                        	<?php echo $form->labelEx($card,'card_number'); ?>
                        	<?php 
                        	$type_list=CHtml::listData(Card::model()->findAllByAttributes(array('card_issue_status'=>'Pending','phone_number'=>NULL)),'id','card_number');
                        	echo CHtml::activeDropDownList($card,'card_number',$type_list,array('class'=>'form-control select2 special','empty'=>'Select Option','data-validation'=>'required')); 
                        	?>
                        </div>
                      	<div class="form-group" style="text-align:left;">
                          <?php echo $form->labelEx($model,'replay'); ?>
                          <?php echo $form->textArea($model,'replay',array('class'=>'form-control','maxlength'=>200,'data-validation'=>"required","rows"=>"4")); ?>
                          <?php echo $form->error($model,'replay'); ?>
                          <input type="hidden" id="Enquiry_id" value="<?php echo $model->id?>" name="Enquiry[id]"/>
                          <input type="hidden" id="Enquiry_mobile_number" value="<?php echo $model->mobile_number?>" name="Enquiry[mobile_number]"/>
                      	</div>
                      	<div class="form-group" style="float: right;">
                        	<img id="loading_img" src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading_second.gif" style="display: none;">
                            <?php $this->widget('bootstrap.widgets.TbButton', array(
                        		'buttonType'=>'submit',
                        		'type'=>'primary',
                        	    'htmlOptions'=>array('id'=>'approve_submit'),
                        	    'label'=>($model->id)?'Update':'Save',
                        	)); ?>
                    	  	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                	 	</div>
    				</div> 
    			</div>
    		</div>
		</div>
    </div>
    <?php $this->endWidget();?>  
</div>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/select2/dist/css/select2.min.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form-validator.min.js"></script>
<style>
.select2-container .select2-selection--single{height:35px;}
</style>
<script type="text/javascript">
$(function () {
	$('.select2').select2()
})
$.validate({
});
$('form#create-new-form').submit(function(event){
	$('#approve_submit').html('loading...').css({'cursor':'not-allowed'}).attr('disabled',true);
	$('#loading_img').show();
    event.preventDefault();
    $.ajax({
        url:'<?php echo Yii::app()->request->baseUrl;?>/enquiry/submitReplay',
        type:'POST',
        data:$('form#create-new-form').serialize(),
        success:function(data){
        	$('#approve_submit').html('Submit').css({'cursor':'pointer'}).attr('disabled',false);
            if(data=="0"){
            	$('#loading_img').hide();
            	swal({
            		  position: 'top-end',
            		  type: 'error',
            		  title: data.message,
            		  showConfirmButton: false,
            		  timer: 2000
            	})
            }else{
            	window.location.href="<?php echo Yii::app()->baseUrl."/enquiry"?>";
            }
        }
    })
});

function getValue(param){
	var val = $(param).val();
	if(val=="Y"){
		$('#card_div').show();
	}else{
		$('#card_div').hide();
	}
}
</script>