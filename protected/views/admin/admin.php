<?php
$this->breadcrumbs = array(
    'Admin List',
);
$this->menu = array(
    array('label' => 'List Requestors', 'url' => array('index')),
    array('label' => 'Create Requestors', 'url' => array('create')),
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
<h1>Manage Admin list</h1>
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
        <a href="<?php echo Yii::app()->request->baseUrl."/admin/create/"?>" style="float:right;padding: 3px 8px;margin-left:10px;" class="btn btn-primary">Add New</a>
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
    $condition_delete = '$data->id!="1"';
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
            'name'=>'first_name',
            'header'=> 'Name',
            'type' => 'html',
            'value'=> array($model,'FullName'),
            'htmlOptions' => array('style' => 'width: 10%'),
        ),
        array(
            'name'=>'email_id',
            'header'=> 'Email Id',
            'type' => 'html',
            'value'=> array($model,'Email_address'),
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name'=>'username',
            'header'=> 'Username',
            //'type' => 'html',
            //'value'=> array($model,'FullName'),
            'htmlOptions' => array('style' => 'width: 8%'),
        ),
        array(
            'name'=>'phone',
            'header'=> 'Phone Number',
            //'type' => 'html',
            //'value'=> array($model,'FullName'),
            'htmlOptions' => array('style' => 'width: 8%'),
        ),        
        array(
            'name' => 'created_on',
            'value' => array($model,'CreatedDate'),
            // 'value'=>'Yii::app()->dateFormatter->format("m/d/y",$data->created)',
            'htmlOptions' => array('style' => 'width: 15%')
        ),
        array(
            'header' => 'Action',
            'class' => 'ButtonColumn',
            'template' => '{update}{delete}{view}',
            'htmlOptions' => array('style' => 'width: 10%','class' => "button-column"),
            'buttons' => array(
                'update' => array(
                    'label' => '<i class="icon-pencil icon-white"></i> Edit', // text label of the button
                    'options' => array('class' => "btn btn-primary btn-xs", 'title' => 'Update','style'=>'margin-right:0px'),
                    'url' => function($data) {
                        $url = Yii::app()->createUrl('admin/update/' . $data->id);
                        return $url;
                        },
                    ),
                    'delete' => array(//the name {reply} must be same
                        'label' => '<i class="icon-remove icon-white"></i> Delete', // text label of the button
                        'options' => array('class' => "btn btn-danger btn-xs delete", 'title' => 'Delete','style'=>'margin-right:0px','id'=>$data->id),
                        'url' => function($data) {
                            $url = Yii::app()->createUrl('admin/adminDelete/' . $data->id);
                            return $url;
                        },
                        'visible'=>$condition_delete,
                    ),
                    'view' => array( //the name {reply} must be same
                        'label' => '<i class="icon-remove icon-white"></i> View', // text label of the button
                        'options' => array('class'=>"btn btn-info btn-xs ",'title'=>'View'),
                        'url' => function($data) {
                            $url = Yii::app()->createUrl('admin/adminView?id=' . $data->id);
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

<script type="text/javascript">
jQuery(function ($) {
    jQuery(document).on("change", '#pageSize', function () {
        $.fn.yiiGridView.update('users-grid', {data: {pageSize: $(this).val()}});
    });
   
});
</script> 
</div>
</div>