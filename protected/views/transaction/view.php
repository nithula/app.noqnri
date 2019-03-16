<?php
/* @var $this TransactionController */
/* @var $model Transaction */

$this->breadcrumbs=array(
	'Transactions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Transaction', 'url'=>array('index')),
	array('label'=>'Create Transaction', 'url'=>array('create')),
	array('label'=>'Update Transaction', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Transaction', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Transaction', 'url'=>array('admin')),
);
?>

<h1>View Transaction #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'l_card_id',
		'partner_id',
		'trans_currency',
		'trans_amount',
		'trans_date',
		'trans_ref_no',
		'points_earned',
		'points_reference',
		'trans_currency_rate',
		'created_at',
		'created_by',
		'updated_at',
		'updated_by',
	),
)); ?>
