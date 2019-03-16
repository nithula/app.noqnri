<?php
$this->breadcrumbs=array(
    'Partner'=>array('admin'),
    'create',
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

<h1>Create Partner</h1>
<br>
<hr>
<?php echo $this->renderPartial('_form', array('partner'=>$partner,'address'=>$address,'country'=>$country,'state'=>$state,'city'=>$city,'phone'=>$phone,'login'=>$login,'photoModel'=>$photoModel)); ?>
</div>
</div>