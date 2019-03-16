<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'admin-form',
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
  <div class="col-md-6">
     <div class="box box-primary">
        <div class="box-header with-border"></div>
           <div class="box-body">
				<div class="form-group">
				  <?php if(!empty($parentData)) {?>
                      <div class="form-group">
                          <?php echo $form->labelEx($model,'parent_category_value'); ?>
                          <?php echo $form->textField($model,'parent_category_value',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off','value'=>$parentData->category,'readonly'=>true)); ?>
                          <?php echo $form->error($model,'parent_category_value'); ?>
                      </div>
                      <input type="hidden" name="parent_category" id="parent_category" value="<?php echo $parentId;?>">
                  <?php }?>
                  <div class="form-group">
                      <?php echo $form->labelEx($model,'category'); ?>
                      <?php echo $form->textField($model,'category',array('class'=>'form-control','maxlength'=>150,'autocomplete'=>'off')); ?>
                      <?php echo $form->error($model,'category'); ?>
                  </div>
                  <!-- <div  class="form-group has-feedback">
                        <?php echo $form->labelEx($model,'parent_category'); ?>
                        <?php $classification_levels_options = array('empty'=>'Select Category');?>
                        <?php if($model->id){
                                  $criteria=new CDbCriteria;
                                  $criteria->condition = "id != $model->id AND status = :status";
                                  $criteria->params = array (':status' => "Y");
                              }else{
                                  $criteria=new CDbCriteria;
                                  $criteria->condition = "status = :status";
                                  $criteria->params = array (':status' => "Y");
                              }?>
                        <?php echo $form->dropDownList($model, 'parent_category', CHtml::listData(Category::model()->findAll($criteria), 'id', 'category'),$classification_levels_options,array('data-validation'=>"required")); ?>
                        <?php echo $form->error($model,'parent_category',array('style'=>'color:#FF0000'));?>
                  </div> -->
                  <div class="form-group">
              		<?php echo $form->labelEx($model,'category_image'); ?>
                    <div class="input-group image-preview">
                        <input type="text" class="form-control image-preview-filename" id="image-preview-filename-image" readonly="true" value="<?php echo $model->category_image;?>">
                        <span class="input-group-btn">
                            <div class="btn btn-default image-preview-input">
                                <span class="glyphicon glyphicon-folder-open"></span>
                                <span class="image-preview-input-title">Choose File</span>
                                <?php 
                                echo $form->fileField($model, 'category_image',array('id'=>'category_image','accept'=>"image/*"));
                                echo $form->error($model, 'category_image');
                                ?>
                            </div>
                        </span>
                    </div>
                 </div>
                 <div class="form-group has-feedback">
					<div id="thumb-output-image">
						<?php $img = Yii::app()->basePath.'/../uploads/category/'.$model->category_image;?>
						<?php if($model->category_image!=NULL && file_exists($img)){
						    echo "<strong>Category Image : </strong>";?>
						    <img class="thumb" src="<?php echo Yii::app()->request->baseUrl.'/uploads/category/'.$model->category_image;?>">
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
                      <div  class="form-group has-feedback">
                    	<?php echo $form->labelEx($model,'category_discription'); ?>
                        <?php echo $form->textArea($model, 'category_discription', array('class'=>'form-control editors','placeholder' => 'Category Description','data-validation'=>"required",'rows'=>'4','value'=>$model->category_discription)); ?>
                        <?php echo $form->error($model,'category_discription',array('style'=>'color:#FF0000'));?>
                      </div>
                      <div class="form-group">
                  		<?php echo $form->labelEx($model,'category_banner'); ?>
                        <div class="input-group image-preview">
                            <input type="text" class="form-control image-preview-filename" id="image-preview-filename-banner" readonly="true" value="<?php echo $model->category_banner;?>">
                            <span class="input-group-btn">
                                <div class="btn btn-default image-preview-input">
                                    <span class="glyphicon glyphicon-folder-open"></span>
                                    <span class="image-preview-input-title">Choose File</span>
                                    <?php 
                                    echo $form->fileField($model, 'category_banner',array('id'=>'category_banner','accept'=>"image/*"));
                                    echo $form->error($model, 'category_banner');
                                    ?>
                                </div>
                            </span>
                        </div>
                        <span class="image-error-show"></span>
                     </div>
                     <div class="form-group has-feedback">
    					<div id="thumb-output-banner">
    						<?php $img = Yii::app()->basePath.'/../uploads/category/banner/'.$model->category_banner;?>
    						<?php if($model->category_banner!=NULL && file_exists($img)){
    						    echo "<strong>Category Banner : </strong>";?>
    						    <img class="thumb" src="<?php echo Yii::app()->request->baseUrl.'/uploads/category/banner/'.$model->category_banner;?>">
    						<?php }?>
    					</div>
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
                        <?php echo CHtml::link('Cancel',array('category/index'),array('class'=>'btn btn-danger')); ?>
                     </div>
				</div>
			</div>
		</div>
	</div>			
</div>
<?php $this->endWidget(); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form-validator.min.js"></script>
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
    width: 50px;
    display:inline;
}
 .thumb:hover{ 
	border: 3px solid #687DDB; 
    margin: 0px 12px 0 0; 
    width: 50px;
    display:inline; 
 }
 </style>
 <script type="text/javascript">
 $('#category_image').on('change', function(){//on file input change
     if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
     {
         $('#thumb-output-image').html('<span class="classs_logo"><strong>Category Image : </strong>'); //clear html of output element
         var data = $(this)[0].files; //this file data
         $.each(data, function(index, file){ //loop though each file
             $('#image-preview-filename-image').val(file.name);
             if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                 var fRead = new FileReader(); //new filereader
                 fRead.onload = (function(file){ //trigger function on successful read
                     console.log(file);
                 return function(e) {
                     var img = $('<img class="img-responsive"/>').addClass('thumb').attr('src', e.target.result); //create image element
                     $('.classs_logo').append(img); //append image to output element
                 };
                 })(file);
                 fRead.readAsDataURL(file); //URL representing the file's data.
             }
         });
        
     }else{
         alert("Your browser doesn't support File API!"); //if File API is absent
     }
 });

 $('#category_banner').on('change', function(){//on file input change
     if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
     {
    	 $('#thumb-output-banner').html('<span class="classses_logo"><strong>Category Banner : </strong>'); //clear html of output element
         var data = $(this)[0].files; //this file data
         var output = [];
         var notoutput = [];
         $.each(data, function(index, file){ //loop though each file
         	var img = new Image();
             img.src = window.URL.createObjectURL( file );
             img.onload = function() {
                var width = img.naturalWidth,
                    height = img.naturalHeight;
                 	window.URL.revokeObjectURL( img.src );
                 	if(width>=1500 || height>=700){
                     	$('#image-preview-filename-banner').val(file.name);
                         if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                             var fRead = new FileReader(); //new filereader
                             fRead.onload = (function(file){ //trigger function on successful read
                                 console.log(file);
                             return function(e) {
                                 var img = $('<img  class="img-responsive"/>').addClass('thumb').attr('src', e.target.result); //create image element
                                 $('.classses_logo').append(img); //append image to output element
                             };
                             })(file);
                             fRead.readAsDataURL(file); //URL representing the file's data.
                         }
             		}else{
						$('.image-error-show').html('Image diamention should be greater than 1500 X 900').css({'color':'#dd4b39'});return false;
                 	}
             };
         });
     }else{
         alert("Your browser doesn't support File API!"); //if File API is absent
     }
 });


 
 </script>