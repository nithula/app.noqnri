<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Import card</h4>
</div>
<div class="modal-body">
    <div class="row">
      <div class="col-md-12">
         <div class="box-primary">
               <div class="box-body">
               		<?php
                        $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                            'id'=>'csv-form',
                            'enableAjaxValidation'=>true,
                            'htmlOptions'=>array('enctype' => 'multipart/form-data'),
                        )); ?> 
                   		<div class="form-group">
                            <div class="input-group image-preview">
                                <input type="text" class="form-control image-preview-filename" id="file_name_id" readonly="true">
                                <span class="input-group-btn">
                                    <div class="btn btn-default image-preview-input">
                                        <span class="glyphicon glyphicon-folder-open"></span>
                                        <span class="image-preview-input-title">Choose File</span>
                                        <!-- <input type="file" name="csv_file"/> -->
                                        <?php 
                                            echo $form->fileField($model, 'csv_file',array('data-validation'=>"required",'accept'=>'.xls,.xlsx,.csv'));
                                            echo $form->error($model, 'csv_file');
                                        ?>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="form-group" style="float: right;">
                        	<img id="loading_img" src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading_second.gif" style="visibility: hidden;">
                            <?php $this->widget('bootstrap.widgets.TbButton', array(
                        		'buttonType'=>'submit',
                        		'type'=>'primary',
                        	    'htmlOptions'=>array('id'=>'csv_submit'),
                        	    'label'=>'Upload',
                        	)); ?>
                          	<?php $this->endWidget();?>  
                    	  	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                	 	</div>
                </div>
        	</div>
     	</div>
    </div>
</div>
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
</style>
<script type="text/javascript">
$.validate({
});

$('#Card_csv_file').on('change', function(){
	var filename = $('input[type=file]').val().split('\\').pop();
	$('#file_name_id').val(filename);
});

$('form#csv-form').submit(function(event){
    event.preventDefault();
    $('#csv_submit').html('Loading').css({'cursor':'not-allowed'}).attr('disabled',true);
    $('#loading_img').css({'visibility': 'visible'});
    var formData = new FormData( $("#csv-form")[0] );
    jQuery.ajax({
	    type: "POST",
	    dataType:'json',
	    url: "<?php echo Yii::app()->request->baseUrl;?>/card/submit_card_list",
	    data: formData,
	    async : false,
        cache : false,
        contentType : false,
        processData : false,
	    success: function(data) 
	    {
        	$('#loading_img').css({'visibility': 'hidden'});
        	$('#csv_submit').html('Upload').css({'cursor':'pointer'}).attr('disabled',false);
            if(data.status=="success"){
                $('form')[0].reset();
                $("#myModal .close").click();
                	swal({
              		  position: 'top-end',
              		  type: data.status,
              		  title: "<p>Message : "+data.msg+"</p><p style='text-align:left'>Success : "+data.success+"</p><p style='text-align:left'>Failure : "+data.failed+"</p><p style='text-align:left'>Duplicate : "+data.duplicate,
              		  showConfirmButton: true,
              		})
            }else{
            	swal({
          		  position: 'top-end',
          		  type: 'error',
          		  title: "<p>Message : "+data.msg+"</p><p style='text-align:left'>Success : "+data.success+"</p><p style='text-align:left'>Failure : "+data.failed+"</p><p style='text-align:left'>Duplicate : "+data.duplicate,
          		  showConfirmButton: true,
          		})
            }
        }
    })
});
</script>