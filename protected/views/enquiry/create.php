<?php
/* @var $this EnquiryController */
/* @var $model Enquiry */

$this->breadcrumbs=array(
	'Enquiries'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Enquiry', 'url'=>array('index')),
	array('label'=>'Manage Enquiry', 'url'=>array('admin')),
);
?>

<h1>Create Enquiry</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>