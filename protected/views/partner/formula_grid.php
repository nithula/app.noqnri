<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Manage Formula List</h4>
    <a href="javascript:void(0);" style="float:right;padding: 3px 8px;margin-left:10px;" class="btn btn-primary add_new_form" id="<?php echo $partner_id;?>">Add New</a>
</div>
<div class="modal-body">
    <?php
    if(count($model->search())>0){
        //$condition_delete = '$data->id!="1"';
        $this->widget('ext.yiisortablemodel.widgets.SortableCGridView', array(
        'id' => 'feedback-grid',
        'dataProvider' => $model->search(),
        'summaryText' => "{start} - {end} of {count}",
        'ajaxUpdate' => true,
        'enableDragDropSorting'=>false,
        //'orderField' => 'id',
        'idField' => 'id',
        'filter' => $model,
        'htmlOptions' => array('class' => 'span12 table-responsive'),
        'itemsCssClass' => 'table',
        'columns' => array(
            array(
                'name'=>'id',
                'header' => 'Id',
                'type' => 'html',
                'value' => array($model,'IDData'),
                'htmlOptions' => array('style' => 'width: 5%'),
                'headerHtmlOptions'=>array('style'=>'width:10%')
            ),
            array(
                'name'=>'formula',
                'header'=> 'Formula',
                'type' => 'html',
                'value' => array($model,'FormulaData'),
                'htmlOptions' => array('style' => 'width: 10%'),
                'headerHtmlOptions'=>array('style'=>'width:30%')
            ),
            array(
                'name'=>'description',
                'header'=> 'Description',
                'type' => 'html',
                'value' => array($model,'DescriptionData'),
                'htmlOptions' => array('style' => 'width: 10%'),
                'headerHtmlOptions'=>array('style'=>'width:25%')
            ),
            array(
                'name' => 'created_at',
                'value' => array($model,'CreatedDate'),
                'filter'=>'',
                'htmlOptions' => array('style' => 'width: 20%'),
                'headerHtmlOptions'=>array('style'=>'width:25%')
            ),
            array(
                'name'=>'status',
                'header'=> 'Status',
                'type' => 'html',
                'value'=> array($model,'Switch_active_inactive'),
                'htmlOptions' => array('style' => 'width: 10%'),
                'headerHtmlOptions'=>array('style'=>'width:20%')
            ),
        ),
    ));
    }
    ?>
</div>
<style>
.on-off-switch-thumb-color{
top:0px!important;
}
</style>
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 28px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 19px;
  width: 20px;
  left: 0px;
  bottom: 3px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<script type="text/javascript">
$('.specialClass').on('click',function(){
	var id = $(this).attr('id');
	$('.show_'+id).hide();
	$('.hidden_'+id).show();
	$('.showInput_'+id).hide();
	$('.hiddenInput_'+id).show();
});

$(document).ready(function(){
	$('.summary').hide();
});

$('.change_status'). click(function(){
	if($(this).is(':checked')) {
		var status="Active"
		var checked = "true";
	}
	var id = $(this).attr('id');
	$.ajax({
    	type:'POST',
    	dataType:'html',
    	data:{'value':checked,'id':id},
    	url:'<?php echo Yii::app()->createAbsoluteUrl("Partner/FormulaChangeStatus")?>',
    	success:function(response){
        	if(response==1){
        		swal({
          		  position: 'top-end',
          		  type: 'success',
          		  title: 'Status has been successfully changed to '+status,
          		  showConfirmButton: false,
          		  timer: 2000
          		})
        	}else{
        		swal({
            		  position: 'top-end',
            		  type: 'error',
            		  title: 'Error while changing the status',
            		  showConfirmButton: false,
            		  timer: 2000
            	})
           	}
    	},error: function(jqXHR, textStatus, errorThrown) {
    		swal({
      		  position: 'top-end',
      		  type: 'error',
      		  title: 'Error while changing the status',
      		  showConfirmButton: false,
      		  timer: 2000
      		})
        }
    });
});

$('.add_new_form').on('click',function(){
	$('.modal-body').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loading_second.gif'>").css({'text-align':'center'});
	var partner_id = $(this).attr('id');
	$.ajax({
    	type:'POST',
    	dataType:'html',
    	url:'<?php echo Yii::app()->createAbsoluteUrl("partner/create_formula_form"); ?>',
    	data: {'partner_id':partner_id},
    	success:function(response){
        	$('.modal-title').html('Add New Formula');
        	$('.add_new_form').hide();
    		$('.modal-body').html(response);
    	},error: function(jqXHR, textStatus, errorThrown) {
    		$('.modal-body').html("Error while loading form");
        }
    });
});

$('.fa-check').on('click',function(){
	//$('.modal-body').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loading_second.gif'>").css({'text-align':'center'});
	var formula_id = $(this).attr('id');
	var formula = $('#Formula_formula_'+formula_id).val();
	var description = $('#Formula_description_'+formula_id).val(); 
	$.ajax({
    	type:'POST',
    	dataType:'html',
    	url:'<?php echo Yii::app()->createAbsoluteUrl("partner/update_formula_form"); ?>',
    	data: {'formula_id':formula_id,'formula':formula,'description':description},
    	success:function(response){
        	if(response=="1"){
        		$('.hidden_'+formula_id).hide();
        		$('.hiddenInput_'+formula_id).hide();
        		$('.showInput_'+formula_id).show();
        		$('.show_'+formula_id).show();
        		$('#textfield_'+formula_id).html(formula);
        		$('#textArea_'+formula_id).html(description);
        		swal({
          		  position: 'top-end',
          		  type: 'success',
          		  title: 'Update Succesful',
          		  showConfirmButton: false,
          		  timer: 2000
          	})
            }else{
            	swal({
            		  position: 'top-end',
            		  type: 'error',
            		  title: 'Error while update',
            		  showConfirmButton: false,
            		  timer: 2000
            	})
            }
    	},error: function(jqXHR, textStatus, errorThrown) {
    		$('.modal-body').html("Error while loading form");
        }
    });
});
</script>