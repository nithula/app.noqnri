<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'forind-user-form',
    'enableAjaxValidation'=>true,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
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
                      <?php echo $form->labelEx($model,'last_name'); ?>
                      <?php echo $form->textField($model,'last_name',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                      <?php echo $form->error($model,'last_name'); ?>
                  </div>
                  <div class="form-group">
                      <?php echo $form->labelEx($model,'email_id'); ?>
                      <?php echo $form->textField($model,'email_id',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                      <?php echo $form->error($model,'email_id'); ?>
                  </div>
                  <div class="form-group">
                  <?php echo $form->labelEx($imageData,'image'); ?>
                        <div class="input-group image-preview">
                            <input type="text" class="form-control image-preview-filename" id="image-preview-filename-image" readonly="true" value="<?php echo $imageData->image;?>">
                            <span class="input-group-btn">
                                <div class="btn btn-default image-preview-input">
                                    <span class="glyphicon glyphicon-folder-open"></span>
                                    <span class="image-preview-input-title">Choose File</span>
                                    <?php 
                                    echo $form->fileField($imageData, 'image',array('id'=>'profile_image','accept'=>"image/*"));
                                    echo $form->error($imageData, 'image');
                                    ?>
                                </div>
                            </span>
                        </div>
                   </div>
                   <div class="form-group has-feedback"> 
    						<div id="thumb-output">
    						<?php $img_path = Yii::app()->basePath.'/../uploads/partner/'.$partner->id.'/profile_image/'.$imageData->image;?>
    						<?php if($imageData->image!=NULL && file_exists($img_path)){?>
    						    <img class="thumb" src="<?php echo Yii::app()->request->baseUrl.'/uploads/partner/'.$partner->id.'/profile_image/'.$imageData->image;?>">
    						<?php }?>
    						</div>
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
                      <?php echo $form->labelEx($model,'middle_name'); ?>
                      <?php echo $form->textField($model,'middle_name',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                      <?php echo $form->error($model,'middle_name'); ?>
                  	</div>
                  	<div class="form-group">
                      <?php echo $form->labelEx($model,'phone_number'); ?>
                      <?php echo $form->textField($model,'phone_number',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                      <?php echo $form->error($model,'phone_number'); ?>
                  	</div>
                  	<div class="form-group">
                      <?php echo $form->labelEx($model,'ext_referance_id'); ?>
                      <?php echo $form->textField($model,'ext_referance_id',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                      <?php echo $form->error($model,'ext_referance_id'); ?>
                  	</div>
                  	<?php if($partner->id==1){?>
                  		<?php if($model->id!=1){?>
                      	<div class="form-group has-feedback">
                      		<?php echo $form->labelEx($login,'role_id'); ?>
                            <?php $listContent = array('2'=>'Admin','3'=>'Staff')?>
                            <?php echo $form->dropdownlist($login,'role_id',$listContent,array('class'=>'form-control select2 special','data-validation'=>"required")); ?>
                	        <?php echo $form->error($login,'role_id')?>
                      	</div> 
                      	<?php }?>
                  	<?php }else{
                  	    if($model->LoginData->role_id!="4"){?>
                          	<div class="form-group has-feedback">
                          		<?php echo $form->labelEx($login,'role_id'); ?>
                                <?php $listContent = array('4'=>'Partner','5'=>'Sales');?>
                                <?php echo $form->dropdownlist($login,'role_id',$listContent,array('class'=>'form-control select2 special','data-validation'=>"required")); ?>
                    	        <?php echo $form->error($login,'role_id')?>
                          	</div> 
                  		<?php }
                  	}?>
                  	<div class="form-group">
                    	<?php $this->widget('bootstrap.widgets.TbButton', array(
                    		'buttonType'=>'submit',
                    		'type'=>'primary',
                    	    'htmlOptions'=>array('id'=>'submit_reg'),
                    	    'label'=>($model->id)?'Update':'Save',
                    	)); ?>
                    	
                    	<?php
                    	if($partner->id){
                            echo CHtml::ResetButton('Cancel',array(
                                "id"=>'cancel_form',
                                "class"=>'btn btn-secondary'
                            ));
                    	}
                        ?>
                        <img id="loading_img" src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading_second.gif" style="display:none;">
                     </div>
				</div>
			</div>
		</div>
	</div>	
</div>
<style>
.image-preview-input {
    position: relative;
	overflow: hidden;
	margin: 0px;    
    color: #333;
    background-color: #fff;
    border-color: #ccc;    
}
.image-preview-input input[type=file] {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;
	font-size: 20px;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}
.image-preview-input-title {
    margin-left:2px;
}
.thumb{
	border: 3px solid #86bd48;
    margin: 0px 12px 0 0;
    width: 25%;
}
 .thumb:hover{ 
	border: 3px solid #687DDB; 
    margin: 0px 12px 0 0; 
    width: 25%; 
 }
</style>
<?php $this->endWidget(); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form-validator.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#profile_image').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#thumb-output').html(''); //clear html of output element
            var data = $(this)[0].files; //this file data
            $.each(data, function(index, file){ //loop though each file
            	 $('#image-preview-filename-image').val(file.name);
                if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element
                        $('#thumb-output').append(img); //append image to output element
                    };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
           
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
    });
});
$.validate({
});

$('#cancel_form').on('click',function(){
	window.location.href="<?php echo Yii::app()->createAbsoluteUrl("dashboard")?>";
});
</script>