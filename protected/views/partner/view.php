<?php
$this->breadcrumbs=array(
    'Partner'=>array('partner/admin'),
    'view',
);

?>
<div class="box">
  <div class="box-body">
   <h1>Partner Details : <?php echo $partner->name;?></h1>
   <br>
   <hr>
    <?php
    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'admin-form',
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="row">
      <div class="col-md-6">
         <div class="box box-primary">
            <div class="box-header with-border"></div>
               <div class="box-body">
    				<div class="form-group">
    					<?php if($partner->id!=1){?>
        					<div  class="form-group has-feedback">
                                <?php echo $form->labelEx($partner,'category_id'); ?>
                                <?php $classification_levels_options = array('empty'=>'Select Category');
                                      $criteria=new CDbCriteria;
                                      $criteria->condition = "status = :status";
                                      $criteria->params = array (':status' => "Y");?>
                                <?php echo $form->dropDownList($partner, 'category_id', CHtml::listData(Category::model()->findAll($criteria), 'id', 'category'),$classification_levels_options,array('data-validation'=>"required")); ?>
                                <?php echo $form->error($partner,'category_id',array('style'=>'color:#FF0000'));?>
                            </div>
                        <?php }?>
                        <div  class="form-group has-feedback">
                            <?php echo $form->labelEx($partner,'name'); ?>
                            <?php echo $form->textField($partner, 'name', array('class'=>'form-control','placeholder' => 'Name','data-validation'=>"required")); ?>
                            <?php echo $form->error($partner,'name',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group">
                            <label>Established Date</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <?php echo $form->textField($partner, 'established_date', array('class'=>'form-control date','placeholder' => 'Established Date','data-validation'=>"required")); ?>
                              <?php echo $form->error($partner,'established_date',array('style'=>'color:#FF0000'));?>
                            </div>
                        </div>
                        <div  class="form-group has-feedback">
                        	<?php echo $form->labelEx($address,'address'); ?>
                            <?php echo $form->textArea($address, 'address', array('class'=>'form-control editors','placeholder' => 'Address','data-validation'=>"required",'rows'=>'4','value'=>nl2br($address->address))); ?>
                            <?php echo $form->error($address,'address',array('style'=>'color:#FF0000'));?>
                        </div>
                      	<div class="form-group has-feedback">
                      		<?php echo $form->labelEx($address,'country_id'); ?>
                            <?php echo $form->dropDownList($address, 'country_id', CHtml::listData(Country::model()->findAll(), 'id', 'country_name'),array('class'=>'form-control select2 special','empty'=>'Select Country','data-placeholder'=>"Select Country",'onChange'=>'getState(this)'));?>
                            <?php echo $form->error($address,'country_id'); ?>
                      	</div>
                        <div class="form-group has-feedback" id="city_content">
                        	<label for="City_city_content">City Name</label>
                      		<?php $CityDetails = City::model()->findAllByAttributes(array('state_id'=>$address->state_id));
                            if(count($CityDetails)>0){?>
                      		<select id="Address_city_id" class="form-control select2" data-placeholder="Select city" name="Address[city_id]" onChange="PlaceOther(this);" data-validation="required">
            	            <?php foreach($CityDetails as $user_data){?>
            	            	<option value="<?php echo $user_data->id?>" <?php echo ($user_data->name==$address->City_details->name)?"selected":'';?>><?php echo $user_data->name;?></option>
            	            <?php }?>
            	            </select>
                      		<?php }else{
            	               echo "<select class='form-control select2' multiple='multiple' data-placeholder='Select city'></select>";
            	            }?>
                        </div>
                        <div class="form-group">
                      		  <?php echo $form->labelEx($address,'Landmark'); ?>
                              <?php echo $form->textField($address, 'Landmark', array('class'=>'form-control','placeholder'=>'Landmark','data-validation'=>"required")); ?>
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
                                <?php echo $form->textField($phone, 'country_code[]', array('class'=>'form-control date','placeholder'=>'Country Code','value'=>'+91','readonly'=>true)); ?>
                                <?php echo $form->error($phone,'country_code',array('style'=>'color:#FF0000'));?>
                            </div>
                        <?php }?>
                        <div class="form-group">
                        	<?php echo $form->labelEx($partner,'google_plus_url'); ?>
                            <?php echo $form->textField($partner, 'google_plus_url', array('class'=>'form-control date','placeholder'=>'Google Plus')); ?>
                            <?php echo $form->error($partner,'google_plus_url',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group">
                        	<?php echo $form->labelEx($partner,'twitter_url'); ?>
                            <?php echo $form->textField($partner, 'twitter_url', array('class'=>'form-control date','placeholder'=>'Twitter')); ?>
                            <?php echo $form->error($partner,'twitter_url',array('style'=>'color:#FF0000'));?>
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
                            <?php echo $form->textField($partner, 'name', array('class'=>'form-control','placeholder' => 'Name','data-validation'=>"required")); ?>
                            <?php echo $form->error($partner,'name',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group has-feedback">
                        	  <?php echo $form->labelEx($partner,'contact_person'); ?>
                              <?php echo $form->textField($partner, 'contact_person', array('class'=>'form-control','placeholder' => 'Contact Person','data-validation'=>"required")); ?>
                              <?php echo $form->error($partner,'contact_person',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group">
                      		  <?php echo $form->labelEx($partner,'mode_of_business'); ?>
                              <?php echo $form->textField($partner, 'mode_of_business', array('class'=>'form-control','placeholder'=>'Mode Of Business','data-validation'=>"required")); ?>
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
                              <?php echo $form->textField($address, 'pin_code', array('class'=>'form-control','placeholder'=>'Pin Code','data-validation'=>"required")); ?>
                              <?php echo $form->error($address,'pin_code',array('style'=>'color:#FF0000'));?>
                        </div>
                        <div class="form-group">
                        	<?php echo $form->labelEx($partner,'geo_location'); ?>
                           	<div id="geolocation" class="input-group">
                        	<?php echo $form->textField($partner, 'geo_location', array('class'=>'form-control date','placeholder'=>'Geo Location')); ?>
                          	<span class="input-group-addon" style=""><i class="fa fa-globe" aria-hidden="true"></i></span>
                          	<?php echo $form->error($partner,'geo_location',array('style'=>'color:#FF0000'));?>
                            </div>
                    	</div>
                        <div class="form-group">
                        	<?php echo $form->labelEx($partner,'currency'); ?>
                            <?php echo $form->textField($partner, 'currency', array('class'=>'form-control date','placeholder'=>'Currency','data-validation'=>"required")); ?>
                            <?php echo $form->error($partner,'currency',array('style'=>'color:#FF0000'));?>
                        </div> 
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
                                              <?php echo $form->textField($ph, 'phone_number[]', array('class'=>'form-control','placeholder'=>'Phone Number','data-validation'=>"length number",'data-validation-length'=>"min10",'autocomplete'=>'off','onKeyup'=>'checkUnity(this,"phone_number","Phone")','value'=>$ph->phone_number)); ?>
                                              <?php echo $form->error($ph,'phone_number',array('style'=>'color:#FF0000'));?>
                                              <span id="phone_number"></span>
                                      		</div>
                                        </div>
                                    </div>
                                </div>
                        <?php $i++;}?>
                        <div class="form-group">
                        	<?php echo $form->labelEx($partner,'faccebook_url'); ?>
                            <?php echo $form->textField($partner, 'faccebook_url', array('class'=>'form-control date','placeholder'=>'Facebook')); ?>
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
<?php $this->endWidget(); ?>
<script type="text/javascript">
$("#admin-form :input").prop("disabled", true);
$(function () {
	$('.select2').select2()
})
</script>