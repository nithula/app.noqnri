<?php
/* @var $this TransactionController */
/* @var $data Transaction */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('l_card_id')); ?>:</b>
	<?php echo CHtml::encode($data->l_card_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('partner_id')); ?>:</b>
	<?php echo CHtml::encode($data->partner_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_currency')); ?>:</b>
	<?php echo CHtml::encode($data->trans_currency); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_amount')); ?>:</b>
	<?php echo CHtml::encode($data->trans_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_date')); ?>:</b>
	<?php echo CHtml::encode($data->trans_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_ref_no')); ?>:</b>
	<?php echo CHtml::encode($data->trans_ref_no); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('points_earned')); ?>:</b>
	<?php echo CHtml::encode($data->points_earned); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('points_reference')); ?>:</b>
	<?php echo CHtml::encode($data->points_reference); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_currency_rate')); ?>:</b>
	<?php echo CHtml::encode($data->trans_currency_rate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updated_by); ?>
	<br />

	*/ ?>

</div>