<?php
/* @var $this CardController */
/* @var $model Card */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'card_validity_start_date'); ?>
		<?php echo $form->textField($model,'card_validity_start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'card_validity_end_date'); ?>
		<?php echo $form->textField($model,'card_validity_end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'card_activation_date'); ?>
		<?php echo $form->textField($model,'card_activation_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'card_status'); ?>
		<?php echo $form->textField($model,'card_status',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_by'); ?>
		<?php echo $form->textField($model,'updated_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->