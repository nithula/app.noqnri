<!DOCTYPE html>
<html>
    <head>
        <title>Customer Registration</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">   
      	<link rel="icon" type="image/png" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon_fork.ico"> 
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/font-awesome.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/ionicons.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/dist/css/AdminLTE.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/animate.min.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/additional_style.css">
 		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    </head>
    <body class="hold-transition login-page" id="register">

        <div class="login-box" id="partner-login-box">
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
            <div class="login-logo">
                <a><img src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/dist/img/site_logo.png"></a>
            </div>
            <div class="login-box-body">
            	<?php $this->renderPartial('//site/customer/_register',array('customer'=>$customer,'address'=>$address,'country'=>$country,'state'=>$state,'city'=>$city,'phone'=>$phone,'login'=>$login,'card'=>$card,'imageData'=>$imageData,'PhoneData'=>$PhoneData));?>
			</div>
        </div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jQuery-2.1.4.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/select2/dist/css/select2.min.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style>
.select2-container .select2-selection--single{height: 34px;}
</style>
<script type="text/javascript">
$(function () {
	$('.select2').select2()
})
$('#Customer_dob').datepicker({
    autoclose: true
})
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
	var append_number = $('.img').length;
	var value_plus = Number(append_number)+Number(1);
	if(value_plus==6){
		$('#add_new_phone').hide();
	}
	var countryCode = $('.country_code').val();
	$('#append_type_'+value).after('<div id="main_'+value_plus+'" class="animated fadeInLeft"><hr><div class="form-group has-feedback" id="content_div_first_'+value_plus+'"><label for="Phone_phone_type">Phone Type</label><select class="form-control select2 special" data-validation="required" name="Phone[phone_type][]" id="Phone_phone_type"><option value="Mobile" selected="selected">Mobile</option><option value="Office">Office</option><option value="Home">Home</option></select><div class="errorMessage" id="Phone_phone_type_em_" style="display:none"></div></div><div class="form-group has-feedback"  id="content_div_second_'+value_plus+'"><label for="Phone_country_code">Country Code</label><input class="form-control date" placeholder="Country Code" value="'+countryCode+'" readonly="readonly" name="Phone[country_code][]" id="Phone_country_code" type="text" maxlength="45"><div style="color:#FF0000;display:none" class="errorMessage" id="Phone_country_code_em_"></div><span class="glyphicon glyphicon-phone form-control-feedback"></span></div></div>');
	$('#append_number_'+value).after('<div id="main_second_'+value_plus+'"  class="animated fadeInRight"><hr><div class="form-group has-feedback" id="contents_div_first_'+value_plus+'"><div class="row"><div class="col-md-10"><label for="Phone_contact_type">Primary/Secondary</label><select class="form-control select2 additional" data-validation="required" name="Phone[contact_type][]" id="Phone_contact_type"><option value="Primary" selected="selected">Primary</option><option value="Secondary">Secondary</option></select><div class="errorMessage" id="Phone_contact_type_em_" style="display:none"></div></div><div class="col-md-2" style="margin-top:10%;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/cross.png" class="img" style="cursor:pointer;" alt="remove" id="'+value_plus+'" onClick="remove(this)"></div></div></div><div class="form-group has-feedback"  id="contents_div_second_'+value_plus+'"><div class="row"><div class="col-md-12"><label for="Phone_phone_number">Phone Number</label><input class="form-control" data-validation="length number" data-validation-length="min10" placeholder="Phone Number" name="Phone[phone_number][]" id="Phone_phone_number" type="text", onKeyup="checkUnity(this,"phone_number","Phone");"><div style="color:#FF0000;display:none" class="errorMessage" id="Phone_phone_number_em_"></div><span class="glyphicon glyphicon-phone form-control-feedback" style="right:20px;"></span></div></div></div></div>');
	$('.select2').select2();
}


function appendAddressBox(value){
	$('#add_new_address').hide();
	var append_number = $('.img').length;
	var value_plus = Number(append_number)+Number(1);
	$('#add_new_address').attr('ref',value_plus);
	$('#append_address_left').after('<div id="main_address_2" class="animated fadeInLeft"><hr><div class="form-group has-feedback" style="margin-bottom: 35px;"><label for="Address_address_type">Address Type <span class="required">*</span></label><input class="form-control" placeholder="Address" value="Communication Address" readonly="readonly" name="Address[address_type][]" id="Address_address_type_2" type="text"><div style="color:#FF0000;display:none" class="errorMessage" id="Address_address_type_em_"></div></div><div class="form-group has-feedback" style="margin-top: 35px;"> <label for="Address_country_id" class="required">Country Name <span class="required">*</span></label> <select class="form-control select2 special" data-placeholder="Select Country" onchange="getState(this,2)" name="Address[country_id][]" id="Address_country_id_2"><option value="">Select Country</option><option value="1">Afghanistan</option><option value="2">Albania</option><option value="3">Algeria</option><option value="4">American Samoa</option><option value="5">Andorra</option><option value="6">Angola</option><option value="7">Anguilla</option><option value="8">Antarctica</option><option value="9">Antigua And Barbuda</option><option value="10">Argentina</option><option value="11">Armenia</option><option value="12">Aruba</option><option value="13">Australia</option><option value="14">Austria</option><option value="15">Azerbaijan</option><option value="16">Bahamas The</option><option value="17">Bahrain</option><option value="18">Bangladesh</option><option value="19">Barbados</option><option value="20">Belarus</option><option value="21">Belgium</option><option value="22">Belize</option><option value="23">Benin</option><option value="24">Bermuda</option><option value="25">Bhutan</option><option value="26">Bolivia</option><option value="27">Bosnia and Herzegovina</option><option value="28">Botswana</option><option value="29">Bouvet Island</option><option value="30">Brazil</option><option value="31">British Indian Ocean Territory</option><option value="32">Brunei</option><option value="33">Bulgaria</option><option value="34">Burkina Faso</option><option value="35">Burundi</option><option value="36">Cambodia</option><option value="37">Cameroon</option><option value="38">Canada</option><option value="39">Cape Verde</option><option value="40">Cayman Islands</option><option value="41">Central African Republic</option><option value="42">Chad</option><option value="43">Chile</option><option value="44">China</option><option value="45">Christmas Island</option><option value="46">Cocos (Keeling) Islands</option><option value="47">Colombia</option><option value="48">Comoros</option><option value="49">Republic Of The Congo</option><option value="50">Democratic Republic Of The Congo</option><option value="51">Cook Islands</option><option value="52">Costa Rica</option><option value="53">Cote DIvoire (Ivory Coast)</option><option value="54">Croatia (Hrvatska)</option><option value="55">Cuba</option><option value="56">Cyprus</option><option value="57">Czech Republic</option><option value="58">Denmark</option><option value="59">Djibouti</option><option value="60">Dominica</option><option value="61">Dominican Republic</option><option value="62">East Timor</option><option value="63">Ecuador</option><option value="64">Egypt</option><option value="65">El Salvador</option><option value="66">Equatorial Guinea</option><option value="67">Eritrea</option><option value="68">Estonia</option><option value="69">Ethiopia</option><option value="70">External Territories of Australia</option><option value="71">Falkland Islands</option><option value="72">Faroe Islands</option><option value="73">Fiji Islands</option><option value="74">Finland</option><option value="75">France</option><option value="76">French Guiana</option><option value="77">French Polynesia</option><option value="78">French Southern Territories</option><option value="79">Gabon</option><option value="80">Gambia The</option><option value="81">Georgia</option><option value="82">Germany</option><option value="83">Ghana</option><option value="84">Gibraltar</option><option value="85">Greece</option><option value="86">Greenland</option><option value="87">Grenada</option><option value="88">Guadeloupe</option><option value="89">Guam</option><option value="90">Guatemala</option><option value="91">Guernsey and Alderney</option><option value="92">Guinea</option><option value="93">Guinea-Bissau</option><option value="94">Guyana</option><option value="95">Haiti</option><option value="96">Heard and McDonald Islands</option><option value="97">Honduras</option><option value="98">Hong Kong S.A.R.</option><option value="99">Hungary</option><option value="100">Iceland</option><option value="101">India</option><option value="102">Indonesia</option><option value="103">Iran</option><option value="104">Iraq</option><option value="105">Ireland</option><option value="106">Israel</option><option value="107">Italy</option><option value="108">Jamaica</option><option value="109">Japan</option><option value="110">Jersey</option><option value="111">Jordan</option><option value="112">Kazakhstan</option><option value="113">Kenya</option><option value="114">Kiribati</option><option value="115">Korea North</option><option value="116">Korea South</option><option value="117">Kuwait</option><option value="118">Kyrgyzstan</option><option value="119">Laos</option><option value="120">Latvia</option><option value="121">Lebanon</option><option value="122">Lesotho</option><option value="123">Liberia</option><option value="124">Libya</option><option value="125">Liechtenstein</option><option value="126">Lithuania</option><option value="127">Luxembourg</option><option value="128">Macau S.A.R.</option><option value="129">Macedonia</option><option value="130">Madagascar</option><option value="131">Malawi</option><option value="132">Malaysia</option><option value="133">Maldives</option><option value="134">Mali</option><option value="135">Malta</option><option value="136">Man (Isle of)</option><option value="137">Marshall Islands</option><option value="138">Martinique</option><option value="139">Mauritania</option><option value="140">Mauritius</option><option value="141">Mayotte</option><option value="142">Mexico</option><option value="143">Micronesia</option><option value="144">Moldova</option><option value="145">Monaco</option><option value="146">Mongolia</option><option value="147">Montserrat</option><option value="148">Morocco</option><option value="149">Mozambique</option><option value="150">Myanmar</option><option value="151">Namibia</option><option value="152">Nauru</option><option value="153">Nepal</option><option value="154">Netherlands Antilles</option><option value="155">Netherlands The</option><option value="156">New Caledonia</option><option value="157">New Zealand</option><option value="158">Nicaragua</option><option value="159">Niger</option><option value="160">Nigeria</option><option value="161">Niue</option><option value="162">Norfolk Island</option><option value="163">Northern Mariana Islands</option><option value="164">Norway</option><option value="165">Oman</option><option value="166">Pakistan</option><option value="167">Palau</option><option value="168">Palestinian Territory Occupied</option><option value="169">Panama</option><option value="170">Papua new Guinea</option><option value="171">Paraguay</option><option value="172">Peru</option><option value="173">Philippines</option><option value="174">Pitcairn Island</option><option value="175">Poland</option><option value="176">Portugal</option><option value="177">Puerto Rico</option><option value="178">Qatar</option><option value="179">Reunion</option><option value="180">Romania</option><option value="181">Russia</option><option value="182">Rwanda</option><option value="183">Saint Helena</option><option value="184">Saint Kitts And Nevis</option><option value="185">Saint Lucia</option><option value="186">Saint Pierre and Miquelon</option><option value="187">Saint Vincent And The Grenadines</option><option value="188">Samoa</option><option value="189">San Marino</option><option value="190">Sao Tome and Principe</option><option value="191">Saudi Arabia</option><option value="192">Senegal</option><option value="193">Serbia</option><option value="194">Seychelles</option><option value="195">Sierra Leone</option><option value="196">Singapore</option><option value="197">Slovakia</option><option value="198">Slovenia</option><option value="199">Smaller Territories of the UK</option><option value="200">Solomon Islands</option><option value="201">Somalia</option><option value="202">South Africa</option><option value="203">South Georgia</option><option value="204">South Sudan</option><option value="205">Spain</option><option value="206">Sri Lanka</option><option value="207">Sudan</option><option value="208">Suriname</option><option value="209">Svalbard And Jan Mayen Islands</option><option value="210">Swaziland</option><option value="211">Sweden</option><option value="212">Switzerland</option><option value="213">Syria</option><option value="214">Taiwan</option><option value="215">Tajikistan</option><option value="216">Tanzania</option><option value="217">Thailand</option><option value="218">Togo</option><option value="219">Tokelau</option><option value="220">Tonga</option><option value="221">Trinidad And Tobago</option><option value="222">Tunisia</option><option value="223">Turkey</option><option value="224">Turkmenistan</option><option value="225">Turks And Caicos Islands</option><option value="226">Tuvalu</option><option value="227">Uganda</option><option value="228">Ukraine</option><option value="229">United Arab Emirates</option><option value="230">United Kingdom</option><option value="231">United States</option><option value="232">United States Minor Outlying Islands</option><option value="233">Uruguay</option><option value="234">Uzbekistan</option><option value="235">Vanuatu</option><option value="236">Vatican City State (Holy See)</option><option value="237">Venezuela</option><option value="238">Vietnam</option><option value="239">Virgin Islands (British)</option><option value="240">Virgin Islands (US)</option><option value="241">Wallis And Futuna Islands</option><option value="242">Western Sahara</option><option value="243">Yemen</option><option value="244">Yugoslavia</option><option value="245">Zambia</option><option value="246">Zimbabwe</option> </select><div class="errorMessage" id="Address_country_id_em_" style="display:none"></div></div><div class="form-group has-feedback append_city_2"> <label for="Address_city_content">City Name <span class="required">*</span></label> <select class="form-control select2 special" data-placeholder="Select city" data-validation="required" name="Address[city_id][]" id="Address_city_id_2"><option value="">Select City</option> </select><div class="errorMessage" id="Address_city_content_em_" style="display:none"></div></div><hr></div>');
	$('#append_address_right').after('<div id="main_second_address_2" class="animated fadeInRight"><hr><div class="form-group has-feedback"><div class="row"><div class="col-md-10"> <label for="Address_address">Address <span class="required">*</span></label><textarea class="form-control" placeholder="Address" data-validation="required" name="Address[address][]" id="Address_address_2"></textarea><div style="color:#FF0000;display:none" class="errorMessage" id="Address_address_em_"></div></div><div class="col-md-2" style="margin-top:10%;"> <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/cross.png" style="cursor:pointer;" alt="remove" id="2" onClick="remove_address(this)"></div></div></div><div class="form-group has-feedback append_state_2"> <label for="Address_state_name">State Name <span class="required">*</span></label> <select class="form-control select2 special" name="Address[state_id][]" id="Address_state_id_2"><option value="">Select State</option> </select><div class="errorMessage" id="Address_state_id_em_" style="display:none"></div></div><div class="form-group has-feedback"> <label for="Address_pincode">Pincode <span class="required">*</span></label> <input class="form-control" placeholder="Pin Code" data-validation="required" name="Address[pin_code][]" id="Address_pin_code_2" type="text"><div style="color:#FF0000;display:none" class="errorMessage" id="Address_pin_code_em_"></div></div><hr></div>');
	$('.select2').select2();
}

function remove_address(param){
	var value = $(param).attr('id');
	$('#main_address_'+value).remove();
	$('#main_second_address_'+value).remove();
	$('#add_new_address').show();
}

function remove(param){
	var value = $(param).attr('id');
	$('#main_'+value).remove();
	$('#main_second_'+value).remove();
	$('#add_new_phone').show();
}
/*$('form#register-form').submit(function(event){
    event.preventDefault();
    $('#submit_registration').html('Loading').css({'cursor':'not-allowed'}).attr('disabled',true);
    $('#reg_loading').show();
    var formData = new FormData( $("#register-form")[0] );
    $.ajax({
        type: "POST",
	    dataType:'json',
	    url: "<?php echo Yii::app()->request->baseUrl;?>/site/customer_registration",
	    data: formData,
	    async : false,
        cache : false,
        contentType : false,
        processData : false,
        success:function(data){
        	$('#reg_loading').hide();
        	$('#submit_registration').html('Register').css({'cursor':'pointer'}).attr('disabled',false);
            if(data.status=="true"){
            	window.location.href="<?php echo Yii::app()->baseUrl?>";
            }else if(data.status=="captcha"){
				$('#captcha_error').html(data.msg);
            }else{
            	swal({
          		  position: 'top-end',
          		  type: 'error',
          		  title: 'Some error occured',
          		  showConfirmButton: false,
          		  timer: 2000
          		})
            }
        }
    })
});*/
</script>
</body>
</html>





