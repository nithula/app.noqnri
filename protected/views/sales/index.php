<?php
/* @var $this ForkindUserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Forkind Users',
);

$this->menu=array(
	array('label'=>'Create ForkindUser', 'url'=>array('create')),
	array('label'=>'Manage ForkindUser', 'url'=>array('admin')),
);
?>

<h1>Forkind Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
