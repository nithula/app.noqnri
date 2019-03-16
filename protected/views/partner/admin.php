<?php
$this->breadcrumbs = array(
    'Partner List',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
  $('.search-form').toggle();
  return false;
});
$('.search-form form').submit(function(){
  $.fn.yiiGridView.update('feedback-grid', {
    data: $(this).serialize()
  });
  return false;
});
");
?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" id="modal-content">
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
<h1>Manage Partner list</h1>
<hr>
<?php
$pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
$pageSizeDropDown = CHtml::dropDownList(
    'pageSize', $pageSize, array(10 => 10, 15 => 15, 30 => 30, -1 => 'All'), array(
     'id' => 'pageSize',
     'onChange'=>'ChangePagecount(this,"Feedback","index","")',
    )
);
?>
<div class="table-toolbar">
<div class="page-size-wrap" style="width:100%">
    <div class="results-perpage">
        <?= $pageSizeDropDown; ?><label>results per page</label>
        <?php if(Yii::app()->user->id==1){?>
        	<a href="<?php echo Yii::app()->request->baseUrl."/partner/create/"?>" style="float:right;padding: 3px 8px;margin-left:10px;" class="btn btn-primary">Add New</a>
        <?php }?>
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
            'htmlOptions' => array('style' => 'width: 4%')
        ),
        array(
            'name'=>'name',
            'header'=> 'Name',
            'type' => 'html',
            'value'=> array($model,'PartnerName'),
            'htmlOptions' => array('style' => 'width: 10%'),
        ),
        array(
        'name'=>'category_id',
        'header'=> 'Category',
        'type' => 'html',
        'value'=> array($model,'CategoryName'),
        'htmlOptions' => array('style' => 'width: 10%'),
        ),
        array(
            'name'=>'email_id',
            'header'=> 'Email',
            'type' => 'html',
            'value'=> array($model,'Email_address'),
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name'=>'contact_person',
            'header'=> 'Contact Person',
            'type' => 'html',
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name'=>'mode_of_business',
            'header'=> 'Mode',
            'type' => 'html',
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name' => 'created_at',
            'value' => array($model,'CreatedDate'),
            // 'value'=>'Yii::app()->dateFormatter->format("m/d/y",$data->created)',
            'htmlOptions' => array('style' => 'width: 8%')
        ),
        array(
            'name'=>'status',
            'header'=> 'Status',
            'type' => 'html',
            'value'=> array($model,'Switch_active_inactive'),
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
        'name'=>'status',
        'header'=> 'Action',
        'filter'=>'',
        'type' => 'html',
        'value'=> array($model,'UpdateFormula'),
        'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'header' => '',
            'class' => 'ButtonColumn',
            'template' => '{update}{view}',
            'htmlOptions' => array('style' => 'width: 10%','class' => "button-column"),
            'buttons' => array(
                    'update' => array(
                        'label' => '<i class="icon-pencil icon-white"></i> Edit', // text label of the button
                        'options' => array('class' => "btn btn-primary btn-xs", 'title' => 'Update','style'=>'margin-right:0px'),
                        'url' => function($data) {
                            $url = Yii::app()->createUrl('partner/update/' . $data->id);
                            return $url;
                        },
                    ),
                    /*'delete' => array(//the name {reply} must be same
                        'label' => '<i class="icon-remove icon-white"></i> Delete', // text label of the button
                        'options' => array('class' => "btn btn-danger btn-xs delete", 'title' => 'Delete','style'=>'margin-right:0px','id'=>$data->id),
                        'url' => function($data) {
                            $url = Yii::app()->createUrl('partner/partnerDelete/' . $data->id);
                            return $url;
                        },
                    ),*/
                    'view' => array( //the name {reply} must be same
                        'label' => '<i class="icon-remove icon-white"></i> View', // text label of the button
                        'options' => array('class'=>"btn btn-info btn-xs ",'title'=>'View'),
                        'url' => function($data) {
                            $url = Yii::app()->createUrl('partner/partnerView?id=' . $data->id);
                            return $url;
                         },
                     ),
                  )
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
        	url:'<?php echo Yii::app()->createAbsoluteUrl("Partner/changeStatus")?>',
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
    }
});
jQuery(function ($) {
    jQuery(document).on("change", '#pageSize', function () {
        $.fn.yiiGridView.update('users-grid', {data: {pageSize: $(this).val()}});
    });
   
});


function FormulaManage(param){
	$('.modal-content').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loading_second.gif'>").css({'text-align':'center'});
	var id = $(param).attr('id');
	$.ajax({
    	type:'POST',
    	dataType:'html',
    	url:'<?php echo Yii::app()->createAbsoluteUrl("partner/FormulaGrid"); ?>',
    	data: {'partner_id':id},
    	success:function(response){
        	//$('.modal-title').html('View Card');
        	$('.modal-title').html('Update card');
    		$('.modal-content').html(response);
    	},error: function(jqXHR, textStatus, errorThrown) {
    		$('.modal-content').html("Error while loading form");
        }
    });
}
</script> 
</div>
</div>