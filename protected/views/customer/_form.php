<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'admin-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
    'htmlOptions' => array(
        'class' => 'separate-sections',
        'enctype' => 'multipart/form-data'
    )
));?>
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
                        <div  class="form-group has-feedback">
                        	<?php echo $form->labelEx($customer,'first_name'); ?>
                            <?php echo $form->textField($customer, 'first_name', array('class'=>'form-control','placeholder' => 'First Name','data-validation'=>"required")); ?>
                            <?php echo $form->error($customer,'first_name',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group" style="margin-bottom: -24px;">
                            <div class="row">
                            	<div class="col-md-12">
                            	<?php echo $form->labelEx($customer,'gender'); ?>
                                <?php
                            		$accountStatus = array('M'=>'Male', 'F'=>'Female');
                            		echo $form->radioButtonList($customer,'gender',$accountStatus);
                            	?>
                            	</div>
                            </div>
                        </div>
                        <div  class="form-group has-feedback" style="margin-top: 24px;">
                        	<?php echo $form->labelEx($customer,'email'); ?>
                            <?php echo $form->textField($customer, 'email', array('class'=>'form-control','placeholder' => 'Email','data-validation'=>"email",'onKeyup'=>'checkUnity(this,"email","Customer")')); ?>
                            <?php echo $form->error($customer,'email',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            <span id="email"></span>
                        </div>
                        <?php //echo "<pre>";print_r($addressess);die;?>
                        <?php $i=0;foreach($addressess as $address){?>
                      	<div id="main_address_<?php echo $i;?>">
                            <div class="form-group has-feedback">
                            	<?php echo $form->labelEx($add,'address_type'); ?>
                                <?php echo $form->textField($address, 'address_type[]', array('class'=>'form-control','placeholder' => 'Address','value'=>'Permanent Address','readonly'=>true)); ?>
                                <?php echo $form->error($address,'address_type',array('style'=>'color:#FF0000'));?>
                          	</div>
                            <div class="form-group has-feedback" style="margin-top:20px;">
                          		<?php echo $form->labelEx($address,'country_id'); ?>
                                <?php echo $form->dropDownList($address, 'country_id[]', CHtml::listData(Country::model()->findAll(), 'id', 'country_name'),array('class'=>'form-control select2 special','empty'=>'Select Country','data-placeholder'=>"Select Country",'onChange'=>'getState(this,"'.$i.'")','options' => array($address->country_id=>array('selected'=>true))));?>
                                <?php echo $form->error($address,'country_id'); ?>
                      		</div>
                            <div class="form-group has-feedback append_city_<?php echo $i;?>" id="append_address_left">
                            <?php if($customer->id){?>
                            	<label for="City_city_content">City Name</label>
                          		<?php $CityDetails = City::model()->findAllByAttributes(array('state_id'=>$address->state_id));
                                if(count($CityDetails)>0){?>
                          		<select id="Address_city_id" class="form-control select2" data-placeholder="Select city" name="Address[city_id][]" data-validation="required">
                	            <?php foreach($CityDetails as $user_data){?>
                	            	<option value="<?php echo $user_data->id?>" <?php echo ($user_data->name==$address->City_details->name)?"selected":'';?>><?php echo $user_data->name;?></option>
                	            <?php }?>
                	            </select>
                          		<?php }else{
                	               echo "<select class='form-control select2' multiple='multiple' data-placeholder='Select city'></select>";
                	            }?>
                            <?php }else{?>
                            	<?php echo $form->labelEx($address,'city_id'); ?>
                                <?php $listContent = array();?>
                                <?php echo $form->dropdownlist($address,'city_id[]',$listContent,array('class'=>'form-control select2 special','data-validation'=>"required",'empty'=>'Select City')); ?>
                                <?php echo $form->error($address,'city_id',array('style'=>'color:#FF0000'));?>
                            <?php }?>    
                            </div>
                        </div>
                        <?php $i++;}?>
                        <?php $i=0;foreach($phones as $ph){?>
                        <div id="main_<?php echo $i;?>">
                            <div class="form-group" >
                            	<?php echo $form->labelEx($phone,'phone_type'); ?>
                                <?php $phoneType = array('Mobile'=>'Mobile','Office'=>'Office','Home'=>'Home')?>
                                <?php echo $form->dropDownList($ph,'phone_type[]',$phoneType,array('class'=>'form-control select2 special','data-validation'=>"required",'options' => array($ph->phone_type=>array('selected'=>true))));?>
                                <?php echo $form->error($ph,'phone_type'); ?>
                            </div>
                            <div class="form-group" id="append_type_<?php echo $i;?>">
                            	<?php echo $form->labelEx($phone,'country_code'); ?>
                                <?php echo $form->textField($ph, 'country_code[]', array('class'=>'form-control date country_code','placeholder'=>'Country Code','value'=>'+91','readonly'=>true)); ?>
                                <?php echo $form->error($ph,'country_code',array('style'=>'color:#FF0000'));?>
                            </div>
                        </div>    
                        <?php $i++;}?>
                        <div class="form-group">
                        	<?php echo $form->labelEx($imageData,'image'); ?>
                            <div class="input-group image-preview">
                                <input type="text" class="form-control image-preview-filename" readonly="true" value="<?php echo ($imageData->image)?$imageData->image:'';?>">
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
    				</div> 
    			</div>
    		</div>
    	</div>
    	<div class="col-sm-6">
    	<div class="box box-danger">
            <div class="box-header with-border"></div>
               <div class="box-body">
    				<div class="form-group">
                        <div  class="form-group has-feedback">
                        	<?php echo $form->labelEx($customer,'last_name'); ?>
                            <?php echo $form->textField($customer, 'last_name', array('class'=>'form-control','placeholder' => 'Last Name','data-validation'=>"required")); ?>
                            <?php echo $form->error($customer,'last_name',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>	
                        <div class="form-group has-feedback">
                        	  <?php echo $form->labelEx($customer,'dob'); ?>
                              <?php echo $form->textField($customer, 'dob', array('class'=>'form-control date','placeholder' => 'Date Of Birth','autocomplete'=>'off')); ?>
                              <?php echo $form->error($customer,'dob',array('style'=>'color:#FF0000'));?>
                              <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                        	<?php echo $form->labelEx($customer,'profession'); ?>
            				<?php echo $form->textField($customer, 'profession', array('class'=>'form-control','placeholder' => 'Profession')); ?>
                            <?php echo $form->error($customer,'profession',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
                      	</div>
                      	<?php $i=0;foreach($addressess as $address){?>
                          	<div id="main_second_address_<?php echo $i;?>">
                            	<?php echo $form->HiddenField($address, 'address_id[]',array('value'=>$address->id))?>
                                <div class="form-group has-feedback">
                                    <div class="row">
                    			    	<div class="col-md-10">
                    			    		<?php echo $form->labelEx($add,'address'); ?>
                    			    		<?php echo $form->textArea($address, 'address[]', array('class'=>'form-control','placeholder' => 'Address','data-validation'=>"required",'value'=>$address->address)); ?>
                                        	<?php echo $form->error($address,'address',array('style'=>'color:#FF0000'));?>
                                        	<span class="glyphicon glyphicon-globe form-control-feedback" style="margin-right: 20px;"></span>
                                        </div>
                                        <div class="col-md-2" style="margin-top: 25px;">
                                        	<?php if($i==0){?>
                                        		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/plus.png" alt="add_new" onClick="appendAddressBox(0)" style="cursor:pointer;" id="add_new_address">
                                        	<?php }else{?>
                                        		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/cross.png" alt="removeExisting" onClick="removeAddressBox('<?php echo $address->id;?>','<?php echo $i;?>')" style="cursor:pointer;">
                                        	<?php }?>
                                        </div>
                                    </div>
                              	</div> 
                                <div class="form-group has-feedback append_state_<?php echo $i ?>" >
                              		<?php echo $form->labelEx($address,'state_id'); ?>
                              		<?php echo $form->dropDownList($address, 'state_id[]', CHtml::listData(State::model()->findAllByAttributes(array('country_id'=>$address->country_id)), 'id', 'state_name'),array('class'=>'form-control select2 special','empty'=>'Select State','data-placeholder'=>"Select State",'options' => array($address->state_id=>array('selected'=>true))));?>
                                    <?php echo $form->error($address,'state_id'); ?>
                              	</div>
                                <div class="form-group has-feedback"  id="append_address_right">
                                  <?php echo $form->labelEx($address,'pin_code'); ?>
                                  <?php echo $form->textField($address, 'pin_code[]', array('class'=>'form-control','placeholder'=>'Pin Code','data-validation'=>"required",'value'=>$address->pin_code)); ?>
                                  <?php echo $form->error($address,'pin_code',array('style'=>'color:#FF0000'));?>
                            	</div> 
                            </div>
                        <?php $i++;}?>
                    	<?php $i=0;foreach($phones as $ph){?>
                    		<div id="main_second_<?php echo $i;?>">
                    			<?php echo $form->HiddenField($ph, 'phone_id[]',array('value'=>$ph->id))?>
                                <div class="form-group has-feedback">
                                    <div class="row">
                    			    	<div class="col-md-10">
                    			    		<?php echo $form->labelEx($phone,'contact_type'); ?>
                    			    		<?php $typeList = array('Primary'=>'Primary','Secondary'=>'Secondary');?>
                                            <?php echo $form->dropDownList($ph, 'contact_type[]', $typeList,array('class'=>'form-control select2 additional','data-validation'=>"required",'options' => array($ph->contact_type=>array('selected'=>true))));?>
                                            <?php echo $form->error($ph,'contact_type'); ?>
                                        </div>
                                        <?php //if(!$partner->id){?>
                                            <div class="col-md-2" style="margin-top: 25px;">
                                            	<?php if($i==0){?>
                                            		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/plus.png" alt="add_new" onClick="appendBox(0)" style="cursor:pointer;">
                                            	<?php }else{?>
                                            		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/cross.png" alt="removeExisting" onClick="removeBox('<?php echo $ph->id;?>','<?php echo $i;?>')" style="cursor:pointer;">
                                            	<?php }?>
                                            </div>
                                        <?php //}?>
                                    </div>
                  				</div> 
                              	<div class="form-group"  id="append_number_<?php echo $i;?>">
                              		<div class="row">
                    			    	<div class="col-md-12">
                    			    	  <?php echo $form->labelEx($phone,'phone_number'); ?>
                                          <?php echo $form->textField($ph, 'phone_number[]', array('class'=>'form-control','placeholder'=>'Phone Number','data-validation'=>"length number",'data-validation-length'=>"min10",'autocomplete'=>'off','onKeyup'=>'checkUnity(this,"phone_number","Phone")','value'=>$ph->phone_number)); ?>
                                          <?php echo $form->error($ph,'phone_number',array('style'=>'color:#FF0000'));?>
                                          <span id="phone_number"></span>
                                  		</div>
                                    </div>
                                </div>
                            </div>
                        <?php $i++;}?>
                        <div class="form-group has-feedback"> 
    						<div id="thumb-output">
    						<?php $img_path = Yii::app()->basePath.'/../uploads/customer/profile_image/'.$imageData->image;?>
    						<?php if($imageData->image!=NULL && file_exists($img_path)){?>
    						    <img class="thumb" src="<?php echo Yii::app()->request->baseUrl.'/uploads/customer/profile_image/'.$imageData->image?>">
    						<?php }?>
    						</div>
						</div>	
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
        	<div class="form-group" style="text-align: center">
            	<?php $this->widget('bootstrap.widgets.TbButton', array(
            		'buttonType'=>'submit',
            		'type'=>'primary',
            	    'htmlOptions'=>array('id'=>'submit_reg'),
            	    'label'=>($customer->id)?'Update':'Register',
            	)); ?>
            	
            	<?php
            	if(!$customer->id){
            	    echo CHtml::ResetButton('Reset',array(
            	        "id"=>'reset_form',
            	        "class"=>'btn btn-secondary'
            	    ));
            	}
                ?>
                <?php echo CHtml::link('Cancel',array('customer/index'),array('class'=>'btn btn-danger')); ?>
                <img id="loading_img" src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading_second.gif" style="display:none;">
             </div>
         </div>
    </div>
<?php $this->endWidget(); ?>
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
<style>

.timerangepicker-container {
  display:flex;
  position: relative;
}
.timerangepicker-label {
  display: block;
  line-height: 2em;
  background-color: #c8c8c880;
  padding-left: 1em;
  border-bottom: 1px solid grey;
  margin-bottom: 0.75em;
}

.timerangepicker-from,
.timerangepicker-to {
  border: 1px solid grey;
  padding-bottom: 0.75em;
}
.timerangepicker-from {
  border-right: none;
}
.timerangepicker-display {
  box-sizing: border-box;
  display: inline-block;
  width: 2.5em;
  height: 2.5em;
  border: 1px solid grey;
  line-height: 2.5em;
  text-align: center;
  position: relative;
  margin: 1em 0.175em;
}
.timerangepicker-display .increment,
.timerangepicker-display .decrement {
  cursor: pointer;
  position: absolute;
  font-size: 1.5em;
  width: 1.5em;
  text-align: center;
  left: 0;
}

.timerangepicker-display .increment {
  margin-top: -0.25em;
  top: -1em;
}

.timerangepicker-display .decrement {
  margin-bottom: -0.25em;
  bottom: -1em;
}

.timerangepicker-display.hour {
  margin-left: 1em;
}
.timerangepicker-display.period {
  margin-right: 1em;
}
/*.special{width:300px!important;}*/
.additional{width: 270px;}
.select2-container .select2-selection--single{height: 34px;}
</style>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form-validator.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#profile_image').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#thumb-output').html(''); //clear html of output element
            var data = $(this)[0].files; //this file data
            $.each(data, function(index, file){ //loop though each file
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
$(function () {
	$('.select2').select2()
})
$('#Partner_established_date').datepicker({
    autoclose: true,
    format: 'yyyy/mm/dd',
})
$.validate({
    //modules : 'date'
});
$('#cancel_form').click(function(){
	window.location.href="<?php echo Yii::app()->request->baseUrl."/customer";?>";
});
</script>
<script type="text/javascript">
function getState(param,id){
	$('.append_state_'+id).html('<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif" alt="loading">');
	$('.country_code').val('Please wait..');
	var value = $(param).val();
	$.ajax({
    	type:'POST',
    	dataType:'html',
    	data:{'value':value,'id':id},
    	url:'<?php echo Yii::app()->createAbsoluteUrl("site/StatesListCust")?>',
    	success:function(response){
    		$('.append_state_'+id).html(response);
    		$('.select2').select2();
    		$.ajax({
    	    	type:'POST',
    	    	dataType:'html',
    	    	data:{'value':value},
    	    	url:'<?php echo Yii::app()->createAbsoluteUrl("site/CountryCode")?>',
    	    	success:function(data){
    	    		$('.country_code').val(data);
    	    	},error: function(jqXHR, textStatus, errorThrown) {
    	    		//window.location.reload();
    	        }
    	    });
    	},error: function(jqXHR, textStatus, errorThrown) {
    		//window.location.reload();
        }
    });
}

function SelectCity(param,id){
	$('.append_city_'+id).html('<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif" alt="loading">');
	var value = $(param).val();
	$.ajax({
    	type:'POST',
    	dataType:'html',
    	data:{'value':value,'id':id},
    	url:'<?php echo Yii::app()->createAbsoluteUrl("site/CityListCust")?>',
    	success:function(response){
    		$('.append_city_'+id).html(response);
    		$('.select2').select2();
    	},error: function(jqXHR, textStatus, errorThrown) {
    		//window.location.reload();
        }
    });
}


function appendBox(value){
	var value_plus = value+1;
	$('#append_type_'+value).after('<div id="main_'+value_plus+'" class="animated fadeInLeft"><hr><div class="form-group has-feedback" id="content_div_first_'+value_plus+'"><label for="Phone_phone_type">Phone Type</label><select class="form-control select2 special" data-validation="required" name="Phone[phone_type][]" id="Phone_phone_type"><option value="Mobile" selected="selected">Mobile</option><option value="Office">Office</option><option value="Home">Home</option></select><div class="errorMessage" id="Phone_phone_type_em_" style="display:none"></div></div><div class="form-group has-feedback"  id="content_div_second_'+value_plus+'"><label for="Phone_country_code">Country Code</label><input class="form-control date" placeholder="Country Code" value="+91" readonly="readonly" name="Phone[country_code][]" id="Phone_country_code" type="text" maxlength="45"><div style="color:#FF0000;display:none" class="errorMessage" id="Phone_country_code_em_"></div></div></div>');
	$('#append_number_'+value).after('<div id="main_second_'+value_plus+'"  class="animated fadeInRight"><hr><input value="0" name="Phone[phone_id][]" id="Phone_phone_id" type="hidden"><div class="form-group has-feedback" id="contents_div_first_'+value_plus+'"><div class="row"><div class="col-md-10"><label for="Phone_contact_type">Primary/Secondary</label><select class="form-control select2 additional" data-validation="required" name="Phone[contact_type][]" id="Phone_contact_type"><option value="Primary" selected="selected">Primary</option><option value="Secondary">Secondary</option></select><div class="errorMessage" id="Phone_contact_type_em_" style="display:none"></div></div><div class="col-md-2" style="margin-top: 25px;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/cross.png" style="cursor:pointer;" alt="remove" id="'+value_plus+'" onClick="remove(this)"></div></div></div><div class="form-group has-feedback"  id="contents_div_second_'+value_plus+'"><div class="row"><div class="col-md-12"><label for="Phone_phone_number">Phone Number</label><input class="form-control" data-validation="length number" data-validation-length="min10" placeholder="Phone Number" name="Phone[phone_number][]" id="Phone_phone_number" type="text" onKeyup="checkUnity(this,"phone_number","Phone")"><div style="color:#FF0000;display:none" class="errorMessage" id="Phone_phone_number_em_"></div></div></div></div></div>');
	$('.select2').select2();
}
function remove(param){
	var value = $(param).attr('id');
	$('#main_'+value).remove();
	$('#main_second_'+value).remove();
}

function appendAddressBox(value){
	$('#add_new_address').hide();
	var append_number = $('.img').length;
	var value_plus = Number(append_number)+Number(1);
	$('#add_new_address').attr('ref',value_plus);
	$('#append_address_left').after('<div id="main_address_2" class="animated fadeInLeft"><hr><div class="form-group has-feedback" style="margin-bottom: 35px;"><label for="Address_address_type">Address Type <span class="required">*</span></label><input class="form-control" placeholder="Address" value="Communication Address" readonly="readonly" name="Address[address_type][]" id="Address_address_type_2" type="text"><div style="color:#FF0000;display:none" class="errorMessage" id="Address_address_type_em_"></div></div><div class="form-group has-feedback" style="margin-top: 35px;"> <label for="Address_country_id" class="required">Country Name <span class="required">*</span></label> <select class="form-control select2 special" data-placeholder="Select Country" onchange="getState(this,2)" name="Address[country_id][]" id="Address_country_id_2"><option value="">Select Country</option><option value="1">Afghanistan</option><option value="2">Albania</option><option value="3">Algeria</option><option value="4">American Samoa</option><option value="5">Andorra</option><option value="6">Angola</option><option value="7">Anguilla</option><option value="8">Antarctica</option><option value="9">Antigua And Barbuda</option><option value="10">Argentina</option><option value="11">Armenia</option><option value="12">Aruba</option><option value="13">Australia</option><option value="14">Austria</option><option value="15">Azerbaijan</option><option value="16">Bahamas The</option><option value="17">Bahrain</option><option value="18">Bangladesh</option><option value="19">Barbados</option><option value="20">Belarus</option><option value="21">Belgium</option><option value="22">Belize</option><option value="23">Benin</option><option value="24">Bermuda</option><option value="25">Bhutan</option><option value="26">Bolivia</option><option value="27">Bosnia and Herzegovina</option><option value="28">Botswana</option><option value="29">Bouvet Island</option><option value="30">Brazil</option><option value="31">British Indian Ocean Territory</option><option value="32">Brunei</option><option value="33">Bulgaria</option><option value="34">Burkina Faso</option><option value="35">Burundi</option><option value="36">Cambodia</option><option value="37">Cameroon</option><option value="38">Canada</option><option value="39">Cape Verde</option><option value="40">Cayman Islands</option><option value="41">Central African Republic</option><option value="42">Chad</option><option value="43">Chile</option><option value="44">China</option><option value="45">Christmas Island</option><option value="46">Cocos (Keeling) Islands</option><option value="47">Colombia</option><option value="48">Comoros</option><option value="49">Republic Of The Congo</option><option value="50">Democratic Republic Of The Congo</option><option value="51">Cook Islands</option><option value="52">Costa Rica</option><option value="53">Cote DIvoire (Ivory Coast)</option><option value="54">Croatia (Hrvatska)</option><option value="55">Cuba</option><option value="56">Cyprus</option><option value="57">Czech Republic</option><option value="58">Denmark</option><option value="59">Djibouti</option><option value="60">Dominica</option><option value="61">Dominican Republic</option><option value="62">East Timor</option><option value="63">Ecuador</option><option value="64">Egypt</option><option value="65">El Salvador</option><option value="66">Equatorial Guinea</option><option value="67">Eritrea</option><option value="68">Estonia</option><option value="69">Ethiopia</option><option value="70">External Territories of Australia</option><option value="71">Falkland Islands</option><option value="72">Faroe Islands</option><option value="73">Fiji Islands</option><option value="74">Finland</option><option value="75">France</option><option value="76">French Guiana</option><option value="77">French Polynesia</option><option value="78">French Southern Territories</option><option value="79">Gabon</option><option value="80">Gambia The</option><option value="81">Georgia</option><option value="82">Germany</option><option value="83">Ghana</option><option value="84">Gibraltar</option><option value="85">Greece</option><option value="86">Greenland</option><option value="87">Grenada</option><option value="88">Guadeloupe</option><option value="89">Guam</option><option value="90">Guatemala</option><option value="91">Guernsey and Alderney</option><option value="92">Guinea</option><option value="93">Guinea-Bissau</option><option value="94">Guyana</option><option value="95">Haiti</option><option value="96">Heard and McDonald Islands</option><option value="97">Honduras</option><option value="98">Hong Kong S.A.R.</option><option value="99">Hungary</option><option value="100">Iceland</option><option value="101">India</option><option value="102">Indonesia</option><option value="103">Iran</option><option value="104">Iraq</option><option value="105">Ireland</option><option value="106">Israel</option><option value="107">Italy</option><option value="108">Jamaica</option><option value="109">Japan</option><option value="110">Jersey</option><option value="111">Jordan</option><option value="112">Kazakhstan</option><option value="113">Kenya</option><option value="114">Kiribati</option><option value="115">Korea North</option><option value="116">Korea South</option><option value="117">Kuwait</option><option value="118">Kyrgyzstan</option><option value="119">Laos</option><option value="120">Latvia</option><option value="121">Lebanon</option><option value="122">Lesotho</option><option value="123">Liberia</option><option value="124">Libya</option><option value="125">Liechtenstein</option><option value="126">Lithuania</option><option value="127">Luxembourg</option><option value="128">Macau S.A.R.</option><option value="129">Macedonia</option><option value="130">Madagascar</option><option value="131">Malawi</option><option value="132">Malaysia</option><option value="133">Maldives</option><option value="134">Mali</option><option value="135">Malta</option><option value="136">Man (Isle of)</option><option value="137">Marshall Islands</option><option value="138">Martinique</option><option value="139">Mauritania</option><option value="140">Mauritius</option><option value="141">Mayotte</option><option value="142">Mexico</option><option value="143">Micronesia</option><option value="144">Moldova</option><option value="145">Monaco</option><option value="146">Mongolia</option><option value="147">Montserrat</option><option value="148">Morocco</option><option value="149">Mozambique</option><option value="150">Myanmar</option><option value="151">Namibia</option><option value="152">Nauru</option><option value="153">Nepal</option><option value="154">Netherlands Antilles</option><option value="155">Netherlands The</option><option value="156">New Caledonia</option><option value="157">New Zealand</option><option value="158">Nicaragua</option><option value="159">Niger</option><option value="160">Nigeria</option><option value="161">Niue</option><option value="162">Norfolk Island</option><option value="163">Northern Mariana Islands</option><option value="164">Norway</option><option value="165">Oman</option><option value="166">Pakistan</option><option value="167">Palau</option><option value="168">Palestinian Territory Occupied</option><option value="169">Panama</option><option value="170">Papua new Guinea</option><option value="171">Paraguay</option><option value="172">Peru</option><option value="173">Philippines</option><option value="174">Pitcairn Island</option><option value="175">Poland</option><option value="176">Portugal</option><option value="177">Puerto Rico</option><option value="178">Qatar</option><option value="179">Reunion</option><option value="180">Romania</option><option value="181">Russia</option><option value="182">Rwanda</option><option value="183">Saint Helena</option><option value="184">Saint Kitts And Nevis</option><option value="185">Saint Lucia</option><option value="186">Saint Pierre and Miquelon</option><option value="187">Saint Vincent And The Grenadines</option><option value="188">Samoa</option><option value="189">San Marino</option><option value="190">Sao Tome and Principe</option><option value="191">Saudi Arabia</option><option value="192">Senegal</option><option value="193">Serbia</option><option value="194">Seychelles</option><option value="195">Sierra Leone</option><option value="196">Singapore</option><option value="197">Slovakia</option><option value="198">Slovenia</option><option value="199">Smaller Territories of the UK</option><option value="200">Solomon Islands</option><option value="201">Somalia</option><option value="202">South Africa</option><option value="203">South Georgia</option><option value="204">South Sudan</option><option value="205">Spain</option><option value="206">Sri Lanka</option><option value="207">Sudan</option><option value="208">Suriname</option><option value="209">Svalbard And Jan Mayen Islands</option><option value="210">Swaziland</option><option value="211">Sweden</option><option value="212">Switzerland</option><option value="213">Syria</option><option value="214">Taiwan</option><option value="215">Tajikistan</option><option value="216">Tanzania</option><option value="217">Thailand</option><option value="218">Togo</option><option value="219">Tokelau</option><option value="220">Tonga</option><option value="221">Trinidad And Tobago</option><option value="222">Tunisia</option><option value="223">Turkey</option><option value="224">Turkmenistan</option><option value="225">Turks And Caicos Islands</option><option value="226">Tuvalu</option><option value="227">Uganda</option><option value="228">Ukraine</option><option value="229">United Arab Emirates</option><option value="230">United Kingdom</option><option value="231">United States</option><option value="232">United States Minor Outlying Islands</option><option value="233">Uruguay</option><option value="234">Uzbekistan</option><option value="235">Vanuatu</option><option value="236">Vatican City State (Holy See)</option><option value="237">Venezuela</option><option value="238">Vietnam</option><option value="239">Virgin Islands (British)</option><option value="240">Virgin Islands (US)</option><option value="241">Wallis And Futuna Islands</option><option value="242">Western Sahara</option><option value="243">Yemen</option><option value="244">Yugoslavia</option><option value="245">Zambia</option><option value="246">Zimbabwe</option> </select><div class="errorMessage" id="Address_country_id_em_" style="display:none"></div></div><div class="form-group has-feedback append_city_2"> <label for="Address_city_content">City Name <span class="required">*</span></label> <select class="form-control select2 special" data-placeholder="Select city" data-validation="required" name="Address[city_id][]" id="Address_city_id_2"><option value="">Select City</option> </select><div class="errorMessage" id="Address_city_content_em_" style="display:none"></div></div><hr></div>');
	$('#append_address_right').after('<div id="main_second_address_2" class="animated fadeInRight"><hr><input value="0" name="Address[address_id][]" id="Address_address_id" type="hidden"><div class="form-group has-feedback"><div class="row"><div class="col-md-10"> <label for="Address_address">Address <span class="required">*</span></label><textarea class="form-control" placeholder="Address" data-validation="required" name="Address[address][]" id="Address_address_2"></textarea><div style="color:#FF0000;display:none" class="errorMessage" id="Address_address_em_"></div></div><div class="col-md-2" style="margin-top:10%;"> <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/cross.png" style="cursor:pointer;" alt="remove" id="2" onClick="remove_address(this)"></div></div></div><div class="form-group has-feedback append_state_2"> <label for="Address_state_name">State Name <span class="required">*</span></label> <select class="form-control select2 special" name="Address[state_id][]" id="Address_state_id_2"><option value="">Select State</option> </select><div class="errorMessage" id="Address_state_id_em_" style="display:none"></div></div><div class="form-group has-feedback"> <label for="Address_pincode">Pincode <span class="required">*</span></label> <input class="form-control" placeholder="Pin Code" data-validation="required" name="Address[pin_code][]" id="Address_pin_code_2" type="text"><div style="color:#FF0000;display:none" class="errorMessage" id="Address_pin_code_em_"></div></div><hr></div>');
	$('.select2').select2();
}

function remove_address(param){
	var value = $(param).attr('id');
	$('#main_address_'+value).remove();
	$('#main_second_address_'+value).remove();
	$('#add_new_address').show();
}

function removeAddressBox(address_id,attr_id){
	swal({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.value) {
  			$.ajax({
  		    	type:'POST',
  		    	dataType:'html',
  		    	data:{'address_id':address_id},
  		    	url:'<?php echo Yii::app()->createAbsoluteUrl("Customer/RemoveAddress")?>',
  		    	success:function(response){
  		        	if(response==1){
  		        		$('#main_address_'+attr_id).remove();
  		        		$('#main_second_address_'+attr_id).remove();
  		        		var type_text = 'success';
  		        		var title_text = 'Address has been removed..!';
  		        	}else{
  		        		var type_text = 'success';
  		        		var title_text = 'Error while removing address..!';
  		            }
  		        	swal({
  		      		  position: 'top-end',
  		      		  type: type_text,
  		      		  title: title_text,
  		      		  showConfirmButton: false,
  		      		  timer: 2000
  		      		})
  		    	},error: function(jqXHR, textStatus, errorThrown) {
  		    		swal({
  		        		  position: 'top-end',
  		        		  type: 'error',
  		        		  title: 'Error while removing address',
  		        		  showConfirmButton: false,
  		        		  timer: 2000
  		        	})
  		        }
  		    });
			}
	})
}

function removeBox(phone_id,attr_id){
	swal({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.value) {
    			$.ajax({
    		    	type:'POST',
    		    	dataType:'html',
    		    	data:{'phone_id':phone_id},
    		    	url:'<?php echo Yii::app()->createAbsoluteUrl("Customer/RemovePhone")?>',
    		    	success:function(response){
    		        	if(response==1){
    		        		$('#main_'+attr_id).remove();
    		        		$('#main_second_'+attr_id).remove();
    		        		var type_text = 'success';
    		        		var title_text = 'Phone has been removed..!';
    		        	}else{
    		        		var type_text = 'success';
    		        		var title_text = 'Error while removing phone..!';
    		            }
    		        	swal({
    		      		  position: 'top-end',
    		      		  type: type_text,
    		      		  title: title_text,
    		      		  showConfirmButton: false,
    		      		  timer: 2000
    		      		})
    		    	},error: function(jqXHR, textStatus, errorThrown) {
    		    		swal({
    		        		  position: 'top-end',
    		        		  type: 'error',
    		        		  title: 'Error while removing phone',
    		        		  showConfirmButton: false,
    		        		  timer: 2000
    		        	})
    		        }
    		    });
			}
	})
}

$('.timerange').on('click', function(e) {
    e.stopPropagation();
    var input = $(this).find('input.myclass');

    var now = new Date();
    var hours = now.getHours();
    var period = "PM";
    if (hours < 12) {
      period = "AM";
    } else {
      hours = hours - 11;
    }
    var minutes = now.getMinutes();

    var range = {
      from: {
        hour: hours,
        minute: minutes,
        period: period
      },
      to: {
        hour: hours,
        minute: minutes,
        period: period
      }
    };

    if (input.val() !== "") {
      var timerange = input.val();
      var matches = timerange.match(/([0-9]{2}):([0-9]{2}) (\bAM\b|\bPM\b)-([0-9]{2}):([0-9]{2}) (\bAM\b|\bPM\b)/);
      if( matches.length === 7) {
        range = {
          from: {
            hour: matches[1],
            minute: matches[2],
            period: matches[3]
          },
          to: {
            hour: matches[4],
            minute: matches[5],
            period: matches[6]
          }
        }
      }
    };
    console.log(range);

    var html = '<div class="timerangepicker-container">'+
      '<div class="timerangepicker-from">'+
      '<label class="timerangepicker-label">From:</label>' +
      '<div class="timerangepicker-display hour">' +
          '<span class="increment fa fa-angle-up"></span>' +
          '<span class="value">'+('0' + range.from.hour).substr(-2)+'</span>' +
          '<span class="decrement fa fa-angle-down"></span>' +
      '</div>' +
      ':' +
      '<div class="timerangepicker-display minute">' +
          '<span class="increment fa fa-angle-up"></span>' +
          '<span class="value">'+('0' + range.from.minute).substr(-2)+'</span>' +
          '<span class="decrement fa fa-angle-down"></span>' +
      '</div>' +
      ':' +
      '<div class="timerangepicker-display period">' +
          '<span class="increment fa fa-angle-up"></span>' +
          '<span class="value">PM</span>' +
          '<span class="decrement fa fa-angle-down"></span>' +
      '</div>' +
      '</div>' +
      '<div class="timerangepicker-to">' +
      '<label class="timerangepicker-label">To:</label>' +
      '<div class="timerangepicker-display hour">' +
          '<span class="increment fa fa-angle-up"></span>' +
          '<span class="value">'+('0' + range.to.hour).substr(-2)+'</span>' +
          '<span class="decrement fa fa-angle-down"></span>' +
      '</div>' +
      ':' +
      '<div class="timerangepicker-display minute">' +
          '<span class="increment fa fa-angle-up"></span>' +
          '<span class="value">'+('0' + range.to.minute).substr(-2)+'</span>' +
          '<span class="decrement fa fa-angle-down"></span>' +
      '</div>' +
      ':' +
      '<div class="timerangepicker-display period">' +
          '<span class="increment fa fa-angle-up"></span>' +
          '<span class="value">PM</span>' +
          '<span class="decrement fa fa-angle-down"></span>' +
      '</div>' +
      '</div>' +
    '</div>';

    $(html).insertAfter(this);
    $('.timerangepicker-container').on(
      'click',
      '.timerangepicker-display.hour .increment',
      function(){
        var value = $(this).siblings('.value');
        value.text(
          increment(value.text(), 12, 1, 2)
        );
      }
    );

    $('.timerangepicker-container').on(
      'click',
      '.timerangepicker-display.hour .decrement',
      function(){
        var value = $(this).siblings('.value');
        value.text(
          decrement(value.text(), 12, 1, 2)
        );
      }
    );

    $('.timerangepicker-container').on(
      'click',
      '.timerangepicker-display.minute .increment',
      function(){
        var value = $(this).siblings('.value');
        value.text(
          increment(value.text(), 59, 0 , 2)
        );
      }
    );

    $('.timerangepicker-container').on(
      'click',
      '.timerangepicker-display.minute .decrement',
      function(){
        var value = $(this).siblings('.value');
        value.text(
          decrement(value.text(), 12, 1, 2)
        );
      }
    );

    $('.timerangepicker-container').on(
      'click',
      '.timerangepicker-display.period .increment, .timerangepicker-display.period .decrement',
      function(){
        var value = $(this).siblings('.value');
        var next = value.text() == "PM" ? "AM" : "PM";
        value.text(next);
      }
    );

  });

  $(document).on('click', e => {

    if(!$(e.target).closest('.timerangepicker-container').length) {
      if($('.timerangepicker-container').is(":visible")) {
        var timerangeContainer = $('.timerangepicker-container');
        if(timerangeContainer.length > 0) {
          var timeRange = {
            from: {
              hour: timerangeContainer.find('.value')[0].innerText,
              minute: timerangeContainer.find('.value')[1].innerText,
              period: timerangeContainer.find('.value')[2].innerText
            },
            to: {
              hour: timerangeContainer.find('.value')[3].innerText,
              minute: timerangeContainer.find('.value')[4].innerText,
              period: timerangeContainer.find('.value')[5].innerText
            },
          };

          timerangeContainer.parent().find('input.myclass').val(
            timeRange.from.hour+":"+
            timeRange.from.minute+" "+    
            timeRange.from.period+"-"+
            timeRange.to.hour+":"+
            timeRange.to.minute+" "+
            timeRange.to.period
          );
          timerangeContainer.remove();
        }
      }
    }
    
  });

  function increment(value, max, min, size) {
    var intValue = parseInt(value);
    if (intValue == max) {
      return ('0' + min).substr(-size);
    } else {
      var next = intValue + 1;
      return ('0' + next).substr(-size);
    }
  }

  function decrement(value, max, min, size) {
    var intValue = parseInt(value);
    if (intValue == min) {
      return ('0' + max).substr(-size);
    } else {
      var next = intValue - 1;
      return ('0' + next).substr(-size);
    }
  }

  function checkUnity(param,key,table){
		var value=$(param).val();
		if(value!=null || value!=""){
	    	$('#submit_reg').html('Loading').css({'cursor':'not-allowed'}).attr('disabled',true);
	    	$.ajax({
	            url:'<?php echo Yii::app()->request->baseUrl;?>/site/check_unity',
	            type:'POST',
	            dataType:'json',
	            data:{'value':value,'key':key,'table':table},
	            success:function(data){
	                if(data.status=="false"){
	    				$('#'+key).html(data.msg).css({'color':data.color});
	                }else{
	                	$('#submit_reg').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
	                	$('#'+key).html("");
	                }
	            }
	        })
		}
	}

  
</script>