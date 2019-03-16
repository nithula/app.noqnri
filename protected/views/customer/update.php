<?php
$this->breadcrumbs=array(
    'Customer'=>array('index'),
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
        
        <h1>Update Customer</h1>
        <br>
        <hr>
        <?php $this->renderPartial('_form', array('customer'=>$customer,'addressess'=>$addressess,'location'=>$location,'phone'=>$phone,'phones'=>$phones,'add'=>$add,'imageData'=>$imageData)); ?>
    </div>
</div>