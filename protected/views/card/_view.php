<?php
/* @var $this CardController */
/* @var $data Card */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('card_validity_start_date')); ?>:</b>
	<?php echo CHtml::encode($data->card_validity_start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('card_validity_end_date')); ?>:</b>
	<?php echo CHtml::encode($data->card_validity_end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('card_activation_date')); ?>:</b>
	<?php echo CHtml::encode($data->card_activation_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('card_status')); ?>:</b>
	<?php echo CHtml::encode($data->card_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updated_by); ?>
	<br />

	*/ ?>

</div>