<?php
$this->breadcrumbs=array(
    'Users List'=>array('index?parent_id='.$partner->id),
    'view',
);

?>
<div class="box">
  <div class="box-body">
   
   <h1>(<?php echo $model->LoginData->RoleData->role;?>) : <?php echo $model->first_name." ".$model->last_name; ?> -  <?php echo $partner->name?> </h1>
   <br>
   <hr>
    <?php
    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'forkind-user-form',
        'enableAjaxValidation'=>true,
    )); ?>
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
                  	<?php }else{?>
                      	<div class="form-group has-feedback">
                      		<?php echo $form->labelEx($login,'role_id'); ?>
                            <?php $listContent = array('4'=>'Partner','5'=>'Sales')?>
                            <?php echo $form->dropdownlist($login,'role_id',$listContent,array('class'=>'form-control select2 special','data-validation'=>"required")); ?>
                	        <?php echo $form->error($login,'role_id')?>
                      	</div> 
                  	<?php }?>
                  	<div class="form-group has-feedback"> 
                  			<?php echo $form->labelEx($imageData,'image'); ?>
    						<div id="thumb-output">
    						<?php $img_path = Yii::app()->basePath.'/../uploads/partner/'.$partner->id.'/profile_image/'.$imageData->image?>
    						<?php if($imageData->image!=NULL && file_exists($img_path)){?>
    						    <img class="thumb" src="<?php echo Yii::app()->request->baseUrl.'/uploads/partner/'.$partner->id.'/profile_image/'.$imageData->image?>">
    						<?php }?>
    						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>	
</div>
</div>
</div>
<style>
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
<script type="text/javascript">
$("#forkind-user-form :input").prop("disabled", true);
</script>