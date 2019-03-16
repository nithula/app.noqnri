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
<div class="row">
      <div class="col-md-6">
         <div class="box box-primary">
            <div class="box-header with-border"></div>
               <div class="box-body">
    				<div class="form-group">
    					<?php if($partner->id!=1){?>
                        	<div  class="form-group has-feedback">
                        		<?php echo $form->labelEx($partner,'category_id'); ?>
                        		<?php $listdate = Partner::model()->getCategories(($partner->category_id)?$partner->category_id:'0');?>
                        		<?php print_r($listdate); ?>
                        		<?php echo $form->error($partner,'category_id'); ?>
                        	</div>
                        <?php }?>
                        <div class="form-group has-feedback">
                            <?php echo $form->labelEx($partner,'email_id'); ?>
                            <?php echo $form->textField($partner, 'email_id', array('class'=>'form-control','placeholder' => 'Email','autocomplete'=>'off','data-validation'=>"email",'onKeyup'=>'checkUnity(this,"email_id","Partner");')); ?>
                            <?php echo $form->error($partner,'email_id',array('style'=>'color:#FF0000'));?>
                            <span id="email"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <?php echo $form->labelEx($partner,'established_date'); ?>
                            <div class="input-group date has-feedback">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <?php echo $form->textField($partner, 'established_date', array('class'=>'form-control','autocomplete'=>'off','placeholder' => 'Established Date','data-validation'=>"required",'autocomplete'=>'off')); ?>
                              <?php echo $form->error($partner,'established_date',array('style'=>'color:#FF0000'));?>
                            </div>
                        </div>
                        <div  class="form-group has-feedback">
                        	<?php echo $form->labelEx($address,'address'); ?>
                            <?php echo $form->textArea($address, 'address', array('class'=>'form-control editors','autocomplete'=>'off','placeholder' => 'Address','data-validation'=>"required",'rows'=>'4','value'=>nl2br($address->address))); ?>
                            <?php echo $form->error($address,'address',array('style'=>'color:#FF0000'));?>
                        </div>
                      	<div class="form-group has-feedback">
                      		<?php echo $form->labelEx($address,'country_id'); ?>
                            <?php echo $form->dropDownList($address, 'country_id', CHtml::listData(Country::model()->findAll(), 'id', 'country_name'),array('class'=>'form-control select2 special','empty'=>'Select Country','data-placeholder'=>"Select Country",'onChange'=>'getState(this)'));?>
                            <?php echo $form->error($address,'country_id'); ?>
                      	</div>
                        <div class="form-group has-feedback" id="city_content">
                        <?php if($partner->id){?>
                        	<label for="City_city_content">City Name</label>
                      		<?php $CityDetails = City::model()->findAllByAttributes(array('state_id'=>$address->state_id));
                            if(count($CityDetails)>0){?>
                      		<select id="Address_city_id" class="form-control select2" data-placeholder="Select city" name="Address[city_id]" onChange="PlaceOther(this);" data-validation="required">
            	            <?php foreach($CityDetails as $user_data){?>
            	            	<option value="<?php echo $user_data->id?>" <?php echo ($user_data->name==$address->City_details->name)?"selected":'';?>><?php echo $user_data->name;?></option>
            	            <?php }?>
            	            	<option value="0" <?php echo ($address->city_id=='0')?"selected":'';?>>Other</option>
            	            </select>
                      		<?php }else{
            	               echo "<select class='form-control select2' multiple='multiple' data-placeholder='Select city'></select>";
            	            }?>
                        <?php }else{?>
                        	<?php echo $form->labelEx($address,'city_id'); ?>
                            <?php $listContent = array();?>
                            <?php echo $form->dropdownlist($address,'city_id',$listContent,array('class'=>'form-control select2 special','data-validation'=>"required",'empty'=>'Select City')); ?>
                            <?php echo $form->error($address,'city_id',array('style'=>'color:#FF0000'));?>
                        <?php }?>    
                        </div>
                        <div class="form-group">
                      		  <?php echo $form->labelEx($address,'Landmark'); ?>
                              <?php echo $form->textField($address, 'Landmark', array('class'=>'form-control','autocomplete'=>'off','placeholder'=>'Landmark')); ?>
                              <?php echo $form->error($address,'Landmark',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group">
                        	<label for="Settings_doothan_avail_time">Working Hours</label>
                           	<div id="datetimepickerDate" class="input-group timerange">
                        	<?php echo $form->textField($partner,'working_hours',array('class'=>'form-control myclass','id'=>'working_hours','data-validation'=>"required",'autocomplete'=>'off')); ?>
                          	<span class="input-group-addon" style=""><i aria-hidden="true" class="fa fa-calendar"></i></span>
                          	<?php echo $form->error($partner,'working_hours',array('style'=>'color:#FF0000'));?>
                            </div>
                    	</div>
                        <?php if($partner->id){?>
                        <?php $i=0;foreach($phones as $ph){?>
                        <div id="main_<?php echo $i;?>">
                        <?php echo $form->HiddenField($ph, 'phone_id[]',array('value'=>$ph->id))?>
                        <?php $countryData = Country::model()->findByPk($address->country_id);?>
                            <div class="form-group" >
                            	<?php echo $form->labelEx($phone,'phone_type'); ?>
                                <?php $phoneType = array('Mobile'=>'Mobile','Office'=>'Office','Home'=>'Home')?>
                                <?php echo $form->dropDownList($ph,'phone_type[]',$phoneType,array('class'=>'form-control select2 special','data-validation'=>"required",'options' => array($ph->phone_type=>array('selected'=>true))));?>
                                <?php echo $form->error($ph,'phone_type'); ?>
                            </div>
                            <div class="form-group" id="append_type_0">
                            	<?php echo $form->labelEx($phone,'country_code'); ?>
                                <?php echo $form->textField($ph, 'country_code[]', array('class'=>'form-control date','placeholder'=>'Country Code','readonly'=>true,'value'=>trim(str_replace("(".$countryData->country_code.")",'',$countryData->country_phone_code)))); ?>
                                <?php echo $form->error($ph,'country_code',array('style'=>'color:#FF0000'));?>
                            </div>
                        </div>    
                        <?php $i++;}
                        }else{?>
                        	<div class="form-group">
                            	<?php echo $form->labelEx($phone,'phone_type'); ?>
                                <?php $phoneType = array('Mobile'=>'Mobile','Office'=>'Office','Home'=>'Home')?>
                                <?php echo $form->dropDownList($phone,'phone_type[]',$phoneType,array('class'=>'form-control select2 special','data-validation'=>"required"));?>
                                <?php echo $form->error($phone,'phone_type'); ?>
                            </div>
                            <div class="form-group" id="append_type_0">
                            	<?php echo $form->labelEx($phone,'country_code'); ?>
                                <?php echo $form->textField($phone, 'country_code[]', array('class'=>'form-control date country_code','placeholder'=>'Country Code','readonly'=>true)); ?>
                                <?php echo $form->error($phone,'country_code',array('style'=>'color:#FF0000'));?>
                            </div>
                        <?php }?>
                        <div class="form-group">
                        	<?php echo $form->labelEx($partner,'google_plus_url'); ?>
                            <?php echo $form->textField($partner, 'google_plus_url', array('class'=>'form-control date','autocomplete'=>'off','placeholder'=>'Google Plus')); ?>
                            <?php echo $form->error($partner,'google_plus_url',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group">
                        	<?php echo $form->labelEx($partner,'twitter_url'); ?>
                            <?php echo $form->textField($partner, 'twitter_url', array('class'=>'form-control date','autocomplete'=>'off','placeholder'=>'Twitter')); ?>
                            <?php echo $form->error($partner,'twitter_url',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group">
                  		<?php echo $form->labelEx($partner,'logo'); ?>
                            <div class="input-group image-preview">
                                <input type="text" class="form-control image-preview-filename" id="image-preview-filename-logo" readonly="true" value="<?php echo $partner->logo;?>">
                                <span class="input-group-btn">
                                    <div class="btn btn-default image-preview-input">
                                        <span class="glyphicon glyphicon-folder-open"></span>
                                        <span class="image-preview-input-title">Choose File</span>
                                        <?php 
                                        echo $form->fileField($partner, 'logo',array('id'=>'logo','accept'=>"image/*"));
                                        echo $form->error($partner, 'logo');
                                        ?>
                                    </div>
                                </span>
                            </div>
                   		</div>
                   		<div class="form-group has-feedback">
    						<div id="thumb-output">
    							<?php $img = Yii::app()->basePath.'/../uploads/partner/'.$partner->id.'/logo/'.$partner->logo;?>
    							<div id="thumb-output-logo">
        						<?php if($partner->logo!=NULL && file_exists($img)){
        						    echo "<hr><strong>Logo : </strong>";?>
        						    <img class="thumb" src="<?php echo Yii::app()->request->baseUrl.'/uploads/partner/'.$partner->id.'/logo/'.$partner->logo;?>">
        						<?php }?>
        						</div>
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
    					<div  class="form-group has-feedback">
                            <?php echo $form->labelEx($partner,'name'); ?>
                            <?php echo $form->textField($partner, 'name', array('class'=>'form-control','placeholder' => 'Name','autocomplete'=>'off','data-validation'=>"required")); ?>
                            <?php echo $form->error($partner,'name',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group has-feedback">
                        	  <?php echo $form->labelEx($partner,'contact_person'); ?>
                              <?php echo $form->textField($partner, 'contact_person', array('class'=>'form-control','autocomplete'=>'off','placeholder' => 'Contact Person','data-validation'=>"required")); ?>
                              <?php echo $form->error($partner,'contact_person',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group">
                      		  <?php echo $form->labelEx($partner,'mode_of_business'); ?>
                              <?php echo $form->textField($partner, 'mode_of_business', array('class'=>'form-control','autocomplete'=>'off','placeholder'=>'Mode Of Business','data-validation'=>"required")); ?>
                              <?php echo $form->error($partner,'mode_of_business',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div  class="form-group has-feedback">
                        	<?php echo $form->labelEx($partner,'description'); ?>
                            <?php echo $form->textArea($partner, 'description', array('class'=>'form-control editors','placeholder' => 'Desription','data-validation'=>"required",'rows'=>'4')); ?>
                            <?php echo $form->error($partner,'description',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group has-feedback" id="state_content_div">
                            <?php if($partner->id){?>
                              		<?php echo $form->labelEx($address,'state_id'); ?>
                              		<?php echo $form->dropDownList($address, 'state_id', CHtml::listData(State::model()->findAllByAttributes(array('country_id'=>$address->country_id)), 'id', 'state_name'),array('class'=>'form-control select2 special','empty'=>'Select State','data-placeholder'=>"Select State"),array('options' => array($address->state_id=>array('selected'=>true))));?>
                                    <?php echo $form->error($address,'state_id'); ?>
                            <?php }else{?>
                              		<?php echo $form->labelEx($address,'state_id'); ?>
                              		<?php echo $form->dropDownList($address, 'state_id', array(),array('class'=>'form-control select2 special','empty'=>'Select State','data-placeholder'=>"Select State"));?>
                                    <?php echo $form->error($address,'state_id'); ?>
                          	<?php }?>
                      	</div>
                        <div class="form-group" id="other_pin_code">
                      		  <?php echo $form->labelEx($address,'pin_code'); ?>
                              <?php echo $form->textField($address, 'pin_code', array('class'=>'form-control','autocomplete'=>'off','placeholder'=>'Pin Code','data-validation'=>"required")); ?>
                              <?php echo $form->error($address,'pin_code',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group">
                        	<?php echo $form->labelEx($partner,'geo_location'); ?>
                           	<div id="geolocation" class="input-group">
                        	<?php echo $form->textField($partner, 'geo_location', array('class'=>'form-control date','autocomplete'=>'off','placeholder'=>'Geo Location')); ?>
                          	<span class="input-group-addon" style=""><i class="fa fa-globe" aria-hidden="true"></i></span>
                          	<?php echo $form->error($partner,'geo_location',array('style'=>'color:#FF0000'));?>
                            </div>
                    	</div>
                        <div class="form-group">
                        	<?php echo $form->labelEx($partner,'currency'); ?>
                            <?php echo $form->textField($partner, 'currency', array('class'=>'form-control date','autocomplete'=>'off','placeholder'=>'Currency','data-validation'=>"required")); ?>
                            <?php echo $form->error($partner,'currency',array('style'=>'color:#FF0000'));?>
                        </div>                        
                        <?php if($partner->id){?>
                        	<?php $i=0;foreach($phones as $ph){?>
                        		<div id="main_second_<?php echo $i;?>">
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
                                              <?php echo $form->textField($ph, 'phone_number[]', array('class'=>'form-control','autocomplete'=>'off','placeholder'=>'Phone Number','data-validation'=>"length number",'data-validation-length'=>"min10",'autocomplete'=>'off','onKeyup'=>'checkUnity(this,"phone_number","Phone")','value'=>$ph->phone_number)); ?>
                                              <?php echo $form->error($ph,'phone_number',array('style'=>'color:#FF0000'));?>
                                              <span id="phone_number"></span>
                                      		</div>
                                        </div>
                                    </div>
                                </div>
                            <?php $i++;}
                        }else{?>
                        	<div class="form-group has-feedback">
                                <div class="row">
                			    	<div class="col-md-10">
                			    		<?php echo $form->labelEx($phone,'contact_type'); ?>
                			    		<?php $typeList = array('Primary'=>'Primary','Secondary'=>'Secondary');?>
                                        <?php echo $form->dropDownList($phone, 'contact_type[]', $typeList,array('class'=>'form-control select2 additional','data-validation'=>"required"));?>
                                        <?php echo $form->error($phone,'contact_type'); ?>
                                    </div>
                                    <div class="col-md-2" style="margin-top: 25px;">
                                    	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/plus.png" alt="add_new" onClick="appendBox(0)" style="cursor:pointer;">
                                    </div>
                                </div>
              				</div> 
                          	<div class="form-group"  id="append_number_0">
                          		<div class="row">
                			    	<div class="col-md-12">
                			    	  <?php echo $form->labelEx($phone,'phone_number'); ?>
                                      <?php echo $form->textField($phone, 'phone_number[]', array('class'=>'form-control','autocomplete'=>'off','placeholder'=>'Phone Number','data-validation'=>"length number",'data-validation-length'=>"min10",'autocomplete'=>'off','onKeyup'=>'checkUnity(this,"phone_number","Phone")')); ?>
                                      <?php echo $form->error($phone,'phone_number',array('style'=>'color:#FF0000'));?>
                                      <span id="phone_number"></span>
                              		</div>
                                </div>
                            </div>
                        <?php }?>
                        <div class="form-group">
                        	<?php echo $form->labelEx($partner,'faccebook_url'); ?>
                            <?php echo $form->textField($partner, 'faccebook_url', array('class'=>'form-control date','autocomplete'=>'off','placeholder'=>'Facebook')); ?>
                            <?php echo $form->error($partner,'faccebook_url',array('style'=>'color:#FF0000'));?>
                        </div>
						<div class="form-group">
                  		<?php echo $form->labelEx($photoModel,'image'); ?>
                            <div class="input-group image-preview">
                            	<?php if(count($photos)>0){   
                            	    foreach($photos as $photo){
                            	        $photoArray[] =  $photo->image;
                            	    }
                            	    $photoList = implode(',',$photoArray);
                            	}?>
                                <input type="text" class="form-control image-preview-filename" id="image-preview-filename-photo" readonly="true" value="<?php echo ($photoList)?$photoList:'';?>">
                                <span class="input-group-btn">
                                    <div class="btn btn-default image-preview-input">
                                        <span class="glyphicon glyphicon-folder-open"></span>
                                        <span class="image-preview-input-title">Choose File</span>
                                        <?php 
                                        echo $form->fileField($photoModel, 'image[]',array('id'=>'PhotoModel_image','multiple'=>true,'accept'=>"image/*"));
                                        ?>
                                    </div>
                                </span>
                            </div>
                            <?php echo $form->error($photoModel, 'image');?>
                   		</div>
						<div class="form-group has-feedback"> 
							<div class="classs_image_error"></div></br>
    						<div id="thumb-output-photo">
        						<?php if(count($photos)>0){   
        						    echo "<hr><strong>Photos : </strong>";
        						    foreach($photos as $photo){
        						        $img = Yii::app()->basePath.'/../uploads/partner/'.$partner->id.'/photo/'.$photo->image;
        						        if($photo->image!=NULL && file_exists($img)){?>
        						        	<img class="img-responsive thumb hover_class remove_image_<?php echo $photo->id;?>" src="<?php echo Yii::app()->request->baseUrl.'/uploads/partner/'.$partner->id.'/photo/'.$photo->image;?>" alt="<?php echo $photo->image;?>" id="<?php echo $photo->id;?>">
											<img class="img-responsive thumb non_hover_class remove_image" style="display:none;cursor:pointer;" src="<?php echo Yii::app()->request->baseUrl.'/images/icon-close-gray.png'?>" alt="<?php echo $photo->image;?>" res="<?php echo $partner->id;?>" ref="<?php echo $photo->id;?>" alt="<?php echo $photo->image;?>" id="non_<?php echo $photo->id;?>">
                					  <?php }
        						    }
        						}?>
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
            	    'label'=>($partner->id)?'Update':'Register',
            	)); ?>
            	
            	<?php
            	if(!$partner->id){
            	    echo CHtml::ResetButton('Reset',array(
            	        "id"=>'reset_form',
            	        "class"=>'btn btn-secondary'
            	    ));
            	}
                ?>
                <?php echo CHtml::link('Cancel',array('partner/admin'),array('class'=>'btn btn-danger')); ?>
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
    width: 50px;
    display:inline;
}
 .thumb:hover{ 
	border: 3px solid #687DDB; 
    margin: 0px 12px 0 0; 
    width: 50px;
    display:inline; 
 }
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
.special{width:300px!important;}
.additional{width: 270px;}
.select2-container .select2-selection--single{height: 34px;}
</style>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form-validator.min.js"></script>
<script type="text/javascript">
$('.hover_class').mouseover(function() {
	var id = $(this).attr('id');
	$('#'+id).hide();
	$('#non_'+id).show();
});

$('.non_hover_class').mouseout(function(){
	var id = $(this).attr('ref');
	$('#non_'+id).hide();
	$('#'+id).show();
});

$(document).ready(function(){

/**************************************** Logo  *******************************************/	
    $('#logo').on('change', function(){//on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#thumb-output-logo').html('<span class="classs_logo"><strong>Uploaded Logo : </strong></span>'); //clear html of output element
            var data = $(this)[0].files; //this file data
            $.each(data, function(index, file){ //loop though each file
            	var img = new Image();
                img.src = window.URL.createObjectURL( file );
                img.onload = function() {
                    var width = img.naturalWidth,
                        height = img.naturalHeight;
                    window.URL.revokeObjectURL( img.src );
                    	$('#image-preview-filename-logo').val(file.name);
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
                };
                
            });
           
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
    });

/**************************************** Photo  *******************************************/	
    $('#PhotoModel_image').on('change', function(){//on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#thumb-output-photo').html('<span class="classs_image"><strong>Uploaded Photos : </strong></span>'); //clear html of output element
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
                    	output.push(file.name);	
                        if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                            var fRead = new FileReader(); //new filereader
                            fRead.onload = (function(file){ //trigger function on successful read
                                console.log(file);
                            return function(e) {
                                var img = $('<img  class="img-responsive"/>').addClass('thumb').attr('src', e.target.result); //create image element
                                $('.classs_image').append(img); //append image to output element
                            };
                            })(file);
                            fRead.readAsDataURL(file); //URL representing the file's data.
                        }
                        $('#image-preview-filename-photo').val(output.join(", "));
                };
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
    autoclose: false,
    format: 'yyyy/mm/dd',
})
$.validate({
    //modules : 'date'
});
$('#cancel_form').click(function(){
	window.location.href="<?php echo Yii::app()->request->baseUrl."/partner/admin";?>";
});

function getState(param){
	$('#state_content_div').html('<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif" alt="loading">');
	$('#city_content').html('<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif" alt="loading">');
	$('.country_code').val('Please wait..');
	var value = $(param).val();
	$.ajax({
    	type:'POST',
    	dataType:'html',
    	data:{'value':value},
    	url:'<?php echo Yii::app()->createAbsoluteUrl("site/StatesList")?>',
    	success:function(response){
    		$('#state_content_div').html(response);
    		$('#city_content').html('<label for="Address_city_id">City Name</label><select id="Address_city_id" class="form-control select2" data-placeholder="Select City" name="Address[city_id]" data-validation="required"><option value="">Select State</option></select>');
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

function SelectCity(param){
	$('#city_content').html('<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif" alt="loading">');
	var value = $(param).val();
	$.ajax({
    	type:'POST',
    	dataType:'html',
    	data:{'value':value},
    	url:'<?php echo Yii::app()->createAbsoluteUrl("site/CityList")?>',
    	success:function(response){
    		$('#city_content').html(response);
    		$('#Address_pincode').val('');
    		$('.select2').select2();
    	},error: function(jqXHR, textStatus, errorThrown) {
    		//window.location.reload();
        }
    });
}

function PlaceOther(param){
	$('#other_pin_code').html('<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif" alt="loading">');
	var value=$(param).val();
	$.ajax({
    	type:'POST',
    	dataType:'html',
    	data:{'value':value,'text_value':'1'},
    	url:'<?php echo Yii::app()->createAbsoluteUrl("site/PlaceOther")?>',
    	success:function(response){
    		$('#other_pin_code').html(response);
    	},error: function(jqXHR, textStatus, errorThrown) {
    		//window.location.reload();
        }
    });
}


function appendBox(value){
	var value_plus = value+1;
	var countryCode = $('#Phone_country_code').val();
	$('#append_type_'+value).after('<div id="main_'+value_plus+'" class="animated fadeInLeft"><hr><div class="form-group has-feedback" id="content_div_first_'+value_plus+'"><label for="Phone_phone_type">Phone Type</label><select class="form-control select2 special" data-validation="required" name="Phone[phone_type][]" id="Phone_phone_type"><option value="Mobile" selected="selected">Mobile</option><option value="Office">Office</option><option value="Home">Home</option></select><input value="0" name="Phone[phone_id][]" id="Phone_phone_id_0" type="hidden"><div class="errorMessage" id="Phone_phone_type_em_" style="display:none"></div></div><div class="form-group has-feedback"  id="content_div_second_'+value_plus+'"><label for="Phone_country_code">Country Code</label><input class="form-control date country_code" placeholder="Country Code" value="'+countryCode+'" readonly="readonly" name="Phone[country_code][]" id="Phone_country_code" type="text" maxlength="45"><div style="color:#FF0000;display:none" class="errorMessage" id="Phone_country_code_em_"></div></div></div>');
	$('#append_number_'+value).after('<div id="main_second_'+value_plus+'"  class="animated fadeInRight"><hr><div class="form-group has-feedback" id="contents_div_first_'+value_plus+'"><div class="row"><div class="col-md-10"><label for="Phone_contact_type">Primary/Secondary</label><select class="form-control select2 additional" data-validation="required" name="Phone[contact_type][]" id="Phone_contact_type"><option value="Primary" selected="selected">Primary</option><option value="Secondary">Secondary</option></select><div class="errorMessage" id="Phone_contact_type_em_" style="display:none"></div></div><div class="col-md-2" style="margin-top: 25px;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/cross.png" style="cursor:pointer;" alt="remove" id="'+value_plus+'" onClick="remove(this)"></div></div></div><div class="form-group has-feedback"  id="contents_div_second_'+value_plus+'"><div class="row"><div class="col-md-12"><label for="Phone_phone_number">Phone Number</label><input class="form-control" data-validation="length number" data-validation-length="min10" placeholder="Phone Number" name="Phone[phone_number][]" id="Phone_phone_number" type="text", onKeyup="checkUnity(this,"phone_number","Phone");"><div style="color:#FF0000;display:none" class="errorMessage" id="Phone_phone_number_em_"></div></div></div></div></div>');
	$('.select2').select2();
}
function remove(param){
	var value = $(param).attr('id');
	$('#main_'+value).remove();
	$('#main_second_'+value).remove();
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
    		    	url:'<?php echo Yii::app()->createAbsoluteUrl("Partner/RemovePhone")?>',
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

$('.remove_image').click(function(){
	var image_name = $(this).attr('alt');
	var image_text_id = $(this).attr('id');
	var image_id = $(this).attr('ref');
	var partner_id = $(this).attr('res');
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
    			jQuery.ajax({
    				type: "POST",
    				url:'<?php echo Yii::app()->request->baseUrl;?>/partner/Remove_gallery_item',
    				data: {'image_name':image_name,'image_id':image_id,'partner_id':partner_id},
    				success: function(res) {
    					 if(res==1){
    						$('.remove_image_'+image_id).remove();	 
    						swal(
    							    'Removed!',
    							    'Product Image Deleted!',
    							    'success'
    						)
    						 
    					 }else{
    						 swal(
    						     'Error',
    						     'Error while deleting image...!',
    						     'error'
    						)
    				     }
    				},
    				error: function(jqXHR, textStatus, errorThrown) 
    				{   
    				  swal(
    		 			'Cannot be Remove this time!',
    		 			'Cannot be Remove the image,Error..!',
    		 			'error'
    		 			)
    				}
    			});
			}
		})
});

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
    if($('.timerangepicker-container').is(":visible")){
        
    }else{
        $(html).insertAfter(this);
    }
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