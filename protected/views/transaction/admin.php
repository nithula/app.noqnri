<?php
$this->breadcrumbs = array(
    'Transaction List',
);
?>
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
<h1>Manage Transaction list</h1>
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
        <?php 
        $ActiveFormula = Formula::model()->findByAttributes(array('status'=>'Y','partner_id'=>Yii::app()->user->partner));
        if(count($ActiveFormula)>0){?>
        	<a href="<?php echo Yii::app()->request->baseUrl."/transaction/create/"?>" style="float:right;padding: 3px 8px;margin-left:10px;" class="btn btn-primary">Add New</a>
        <?php }else{?>
        	<a href="javascipt:void(0);" style="float:right;padding: 3px 8px;margin-left:10px;" class="btn btn-primary not_allowed">Add New</a>
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
    $condition_edit = '$data->points_redeemed=="0"';
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
            'name'=>'l_card_id',
            'header'=> 'Card Number',
            'type' => 'html',
            'value'=> array($model,'CardNumber'),
            'htmlOptions' => array('style' => 'width: 10%'),
        ),
        array(
            'name'=>'trans_currency',
            'header'=> 'Currency',
            'type' => 'html',
            //'value'=> array($model,'TransactionCurrency'),
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name'=>'trans_amount',
            'header'=> 'Amount',
            'type' => 'html',
            //'value'=> array($model,'TransactionAmount'),
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name'=>'trans_date',
            'header'=> 'Transaction Date',
            'type' => 'html',
            'value'=> array($model,'TransactionDate'),
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name' => 'created_at',
            'value' => array($model,'CreatedDate'),
            'htmlOptions' => array('style' => 'width: 15%')
        ),
        array(
            'header' => 'Action',
            'class' => 'ButtonColumn',
            'template' => '{update}',
            'htmlOptions' => array('style' => 'width: 10%','class' => "button-column"),
            'buttons' => array(
                'update' => array(
                    'label' => '<i class="icon-pencil icon-white"></i> Edit', // text label of the button
                    'options' => array('class' => "btn btn-primary btn-xs", 'title' => 'Update','style'=>'margin-right:0px'),
                    'url' => function($data) {
                        $url = Yii::app()->createUrl('transaction/Update/' . $data->id);
                        return $url;
                        },
                        'visible'=>$condition_edit
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

$('.not_allowed').on('click',function(){
	swal({
		  position: 'top-end',
		  type: 'error',
		  title: 'You must update your redeem formula before doing a transaction...!',
		  showConfirmButton: false,
		  timer: 2000
	})
});
</script> 
</div>
</div>