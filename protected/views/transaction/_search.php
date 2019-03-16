<?php
/* @var $this TransactionController */
/* @var $model Transaction */
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
		<?php echo $form->label($model,'l_card_id'); ?>
		<?php echo $form->textField($model,'l_card_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'partner_id'); ?>
		<?php echo $form->textField($model,'partner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trans_currency'); ?>
		<?php echo $form->textField($model,'trans_currency',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trans_amount'); ?>
		<?php echo $form->textField($model,'trans_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trans_date'); ?>
		<?php echo $form->textField($model,'trans_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trans_ref_no'); ?>
		<?php echo $form->textField($model,'trans_ref_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'points_earned'); ?>
		<?php echo $form->textField($model,'points_earned'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'points_reference'); ?>
		<?php echo $form->textField($model,'points_reference'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trans_currency_rate'); ?>
		<?php echo $form->textField($model,'trans_currency_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
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