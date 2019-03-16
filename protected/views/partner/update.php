<?php
$this->breadcrumbs=array(
    'Partner'=>array('admin'),
    'update',
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
        
        <h1>Update Partner</h1>
        <br>
        <hr>
        <?php $this->renderPartial('_form', array('partner'=>$partner,'address'=>$address,'country'=>$country,'state'=>$state,'city'=>$city,'phone'=>$phone,'phones'=>$phones,'photos'=>$photos,'photoModel'=>$photoModel)); ?>
    </div>
</div>