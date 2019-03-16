<?php
$this->breadcrumbs = array(
    'Enquiry List',
);
?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 500px;">
    <div class="modal-content">
    </div>
  </div>
</div>
<div class="box">
    <div class="box-body">
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
<h1>Manage Enquiry list</h1>
<hr>
<?php
$pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
$pageSizeDropDown = CHtml::dropDownList(
    'pageSize', $pageSize, array(10 => 10, 15 => 15, 30 => 30, -1 => 'All'), array(
     'id' => 'pageSize',
    )
);
?>
<div class="table-toolbar">
<div class="page-size-wrap" style="width:100%">
    <div class="results-perpage">
        <?= $pageSizeDropDown; ?><label>results per page</label>
    </div>
</div>
<?php Yii::app()->clientScript->registerCss('initPageSizeCSS', '.page-size-wrap{width: 10%; float: left;}'); ?>            
</div>
<div class="custom_div_data">
<div class="clear"></div>
<div class="space_10px"></div>
<div class="clear"></div>
<?php
if(count($model->search())>0){
    $this->widget('ext.yiisortablemodel.widgets.SortableCGridView', array(
    'id' => 'category',
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
            'htmlOptions' => array('style' => 'width: 4%')
        ),
        array(
            'name'=>'full_name',
            'header'=> 'Name',
            'type' => 'html',
            'htmlOptions' => array('style' => 'width: 10%'),
        ),
        array(
            'name'=>'email_id',
            'header'=> 'Email',
            'type' => 'html',
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name'=>'country_code',
            'header'=> 'Code',
            'type' => 'html',
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name'=>'mobile_number',
            'header'=> 'Mobile Number',
            'type' => 'html',
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name'=>'address',
            'header'=> 'Address',
            'type' => 'html',
            'value'=> array($model,'AddressData'),
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name' => 'created_at',
            'value' => array($model,'CreatedDate'),
            'htmlOptions' => array('style' => 'width: 15%')
        ),
        array(
            'name' => 'created_at',
            'header'=> 'Action',
            'filter'=>'',
            'value' => array($model,'ActionButton'),
            'htmlOptions' => array('style' => 'width: 15%')
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
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/switch/on-off-switch.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/switch/on-off-switch-onload.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/switch/on-off-switch.css">
<script type="text/javascript">
new DG.OnOffSwitchAuto({
    cls:'.custom-switch',
    textOn:"Active",
    height:25,
    trackColorOn:'#00acd6',
    trackColorOff:'#666',
    trackBorderColor:'#555',
    textColorOff:'#fff',
    textOff:"Suspended",
    textSizeRatio:0.35,
    listener:function(name, checked){
        if(checked==true){
			var status="Active"
        }else{
			var status="Inactive";
        }
    	$.ajax({
        	type:'POST',
        	dataType:'html',
        	data:{'value':checked,'id':name},
        	url:'<?php echo Yii::app()->createAbsoluteUrl("Category/ChangeStatus")?>',
        	success:function(response){
            	if(response==1){
            		swal({
              		  position: 'top-end',
              		  type: 'success',
              		  title: 'Status has been successfully changed to '+status,
              		  showConfirmButton: false,
              		  timer: 2000
              		})
            		$('#'+name).removeAttr("href").css({'color':'#555555'});
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
    }
});
jQuery(function ($) {
    jQuery(document).on("change", '#pageSize', function () {
        $.fn.yiiGridView.update('category-grid', {data: {pageSize: $(this).val()}});
    });
   
});

function ApproveEnquiry(param){
	$('.modal-content').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loading_second.gif'>").css({'text-align':'center'});
	var id = $(param).attr('id');
	$.ajax({
    	type:'POST',
    	dataType:'html',
    	url:'<?php echo Yii::app()->createAbsoluteUrl("Enquiry/ApproveEnquiryAction"); ?>',
    	data: {'id':id},
    	success:function(response){
        	$('.modal-title').html('Approve Enquiry');
    		$('.modal-content').html(response);
    	},error: function(jqXHR, textStatus, errorThrown) {
    		$('.modal-content').html("Error while loading form");
        }
    });
    return false;
}

</script> 
</div>
</div>