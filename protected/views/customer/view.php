<?php
$this->breadcrumbs=array(
    'Admin'=>array('customer'),
    'view',
);

?>
<div class="box">
  <div class="box-body">
   <h1>Customer : <?php echo $customer->first_name." ".$customer->last_name;?></h1>
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
                        <div  class="form-group has-feedback">
                        	<?php echo $form->labelEx($customer,'first_name'); ?>
                            <?php echo $form->textField($customer, 'first_name', array('class'=>'form-control','placeholder' => 'First Name','data-validation'=>"required")); ?>
                            <?php echo $form->error($customer,'first_name',array('style'=>'color:#FF0000'));?>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group" style="margin-bottom: -24px;">
                            <div class="row">
                            	<div class="col-md-4">
                            	<?php echo $form->labelEx($customer,'gender'); ?>
                                <?php
                            		$accountStatus = array('M'=>'Male', 'F'=>'Female');
                            		echo $form->radioButtonList($customer,'gender',$accountStatus,array('class'=>'col-md-4'));
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
                            <div class="form-group has-feedback">
                            	<?php if($partner->id){?>
                            		<?php $location->country_name = $address->Location_details->country_name;?>
                            	<?php }?>
                          		<?php echo $form->labelEx($location,'country_name'); ?>
                                <?php echo $form->dropDownList($location, 'country_name[]', array('0'=>'India'),array('class'=>'form-control select2 special','disabled'=>'disabled'));?>
                                <?php echo $form->error($location,'country_name'); ?>
                          	</div>
                            <div class="form-group has-feedback">
                          		<?php if($customer->id){?>
                              	<?php  if($address->location_id==-1){
                                  		    $DistrictDetails = explode('/',$address->custom_location);
                                  		    $address->dist_name = $DistrictDetails[0];
                                  		}else{
                                  		    $address->dist_name = $address->Location_details->district_name;
                                  		}
                                  		//echo $address->dist_name;die;
                                }?>
                    	        
                    	        <label for="Address_dist_name">District Name</label>
                    	        <select class="form-control select2 special" onchange="SelectCity(this,<?php echo $i?>);" data-validation="required" name="Address[dist_name][]" id="Address_dist_name" tabindex="-1" aria-hidden="true">
                                    <option value="">Select District</option>
                                    <option value="Thiruvananthapuram"<?php echo ($address->dist_name=="Thiruvananthapuram")?"selected":'';?>>Thiruvananthapuram</option>
                                    <option value="Kollam" <?php echo($address->dist_name=="Kollam")?"selected":'';?>>Kollam</option>
                                    <option value="Pathanamthitta" <?php echo($address->dist_name=="Pathanamthitta")?"selected":'';?>>Pathanamthitta</option>
                                    <option value="Alappuzha" <?php echo($address->dist_name=="Alappuzha")?"selected":'';?>>Alappuzha</option>
                                    <option value="Kottayam" <?php echo($address->dist_name=="Kottayam")?"selected":'';?>>Kottayam</option>
                                    <option value="Idukki" <?php echo($address->dist_name=="Idukki")?"selected":'';?>>Idukki</option>
                                    <option value="Ernakulam" <?php echo($address->dist_name=="Ernakulam")?"selected":'';?>>Ernakulam</option>
                                    <option value="Thrissur" <?php echo($address->dist_name=="Thrissur")?"selected":'';?>>Thrissur</option>
                                    <option value="Palakkad" <?php echo($address->dist_name=="Palakkad")?"selected":'';?>>Palakkad</option>
                                    <option value="Malappuram" <?php echo($address->dist_name=="Malappuram")?"selected":'';?>>Malappuram</option>
                                    <option value="Kozhikode" <?php echo($address->dist_name=="Kozhikode")?"selected":'';?>>Kozhikode</option>
                                    <option value="Kannur" <?php echo($address->dist_name=="Kannur")?"selected":'';?>>Kannur</option>
                                    <option value="Wayanad" <?php echo($address->dist_name=="Wayanad")?"selected":'';?>>Wayanad</option>
                                    <option value="Kasargod" <?php echo($address->dist_name=="Kasargod")?"selected":'';?>>Kasaragod</option>
                                </select>
                            </div>
                            <div class="form-group has-feedback append_address_type_<?php echo $i?>" id="other_pin_code_<?php echo $i?>">
                                  <?php if($customer->id){?>
                              		<?php 
                              		if($address->location_id==-1){
                              		    $DistrictDetails = explode('/',$address->custom_location);
                              		    $address->pincode = $DistrictDetails[1];
                              		}else{
                              		    $address->pincode = $address->Location_details->pin_code;
                              		}?>
                              	  <?php }?>
                          		  <?php echo $form->labelEx($add,'pincode'); ?>
                                  <?php echo $form->textField($address, 'pincode[]', array('class'=>'form-control','placeholder'=>'Pin Code','data-validation'=>"required",'value'=>$address->pincode)); ?>
                                  <?php echo $form->error($address,'pincode',array('style'=>'color:#FF0000'));?>
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
                                <?php echo $form->textField($ph, 'country_code[]', array('class'=>'form-control date','placeholder'=>'Country Code','value'=>'+91','readonly'=>true)); ?>
                                <?php echo $form->error($ph,'country_code',array('style'=>'color:#FF0000'));?>
                            </div>
                        </div>    
                        <?php $i++;}?>
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
                    			    	<div class="col-md-12">
                    			    		<?php echo $form->labelEx($add,'address'); ?>
                    			    		<?php echo $form->textArea($address, 'address[]', array('class'=>'form-control','placeholder' => 'Address','data-validation'=>"required",'value'=>$address->address)); ?>
                                        	<?php echo $form->error($address,'address',array('style'=>'color:#FF0000'));?>
                                        	<span class="glyphicon glyphicon-globe form-control-feedback" style="margin-right: 20px;"></span>
                                        </div>
                                    </div>
                              	</div> 
                                <div class="form-group has-feedback">
                              		<?php if($customer->id){?>
                              			<?php $location->state_name = $address->Location_details->state_name;?>
                              		<?php }?>
                              		<?php echo $form->labelEx($location,'state_name'); ?>
                              		<?php $stateList = array('0'=>'Kerala');?>
                                    <?php echo $form->dropDownList($location, 'state_name[]', $stateList,array('class'=>'form-control select2 special','disabled'=>'disabled'));?>
                                    <?php echo $form->error($location,'state_name'); ?>
                              	</div>
                                <div class="form-group has-feedback" id="city_content_<?php echo $i;?>">
                                  		<?php $CityDetails = Location::model()->findAllByAttributes(array('district_name'=>$address->dist_name));
                                        if(count($CityDetails)>0){?>
                                        <label for="Address_city_content">City Name</label>
                                  		<select id="Address_city_content" class="form-control select2" data-placeholder="Select city" name="Address[city_content][]" onChange="PlaceOther(this,'<?php echo $i;?>')" data-validation="required">
                        	            <?php foreach($CityDetails as $user_data){?>
                        	            	<option value="<?php echo $user_data->id?>" <?php echo ($user_data->city_name==$address->Location_details->city_name)?"selected":'';?>><?php echo $user_data->city_name;?></option>
                        	            <?php }?>
                        	            <option value="-1" <?php echo ($address->location_id=='-1')?"selected":'';?>>Other</option>
                        	            </select>
                                  		<?php }else{
                        	               echo "<select class='form-control select2' multiple='multiple' data-placeholder='Select city'></select>";
                        	            }?>
                                </div> 
                                <div class="form-group has-feedback" id="append_address_<?php echo $i?>">
                                	  <?php echo $form->labelEx($add,'Landmark'); ?>
                                      <?php echo $form->textField($address, 'Landmark[]', array('class'=>'form-control','placeholder'=>'Landmark','value'=>$address->Landmark)); ?>
                                      <?php echo $form->error($address,'Landmark',array('style'=>'color:#FF0000'));?>
                                      <span class="glyphicon glyphicon-road form-control-feedback"></span>
                                </div>
                            </div>
                        <?php $i++;}?>
                    	<?php $i=0;foreach($phones as $ph){?>
                    		<div id="main_second_<?php echo $i;?>">
                    			<?php echo $form->HiddenField($ph, 'phone_id[]',array('value'=>$ph->id))?>
                                <div class="form-group has-feedback">
                                    <div class="row">
                    			    	<div class="col-md-12">
                    			    		<?php echo $form->labelEx($phone,'contact_type'); ?>
                    			    		<?php $typeList = array('Primary'=>'Primary','Secondary'=>'Secondary');?>
                                            <?php echo $form->dropDownList($ph, 'contact_type[]', $typeList,array('class'=>'form-control select2 additional','data-validation'=>"required",'options' => array($ph->contact_type=>array('selected'=>true))));?>
                                            <?php echo $form->error($ph,'contact_type'); ?>
                                        </div>
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
    						<?php $img_path = Yii::app()->basePath.'/../uploads/profile_photos/customer/'.$imageData->image?>
    						<?php if($imageData->image!=NULL && file_exists($img_path)){?>
    						    <img class="thumb" src="<?php echo Yii::app()->request->baseUrl.'/uploads/profile_photos/customer/'.$imageData->image?>">
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
<?php $this->endWidget(); ?>
<script type="text/javascript">
$("#admin-form :input").prop("disabled", true);
</script>
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