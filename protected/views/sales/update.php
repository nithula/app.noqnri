<?php
$this->breadcrumbs=array(
    $partner->name=>array('index?parent_id='.$model->parent_id),
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
        
        <h1>Update <?php echo $partner->name;?> User</h1>
        <br>
        <hr>
        <?php $this->renderPartial('_form', array('model'=>$model,'partner'=>$partner,'login'=>$login,'imageData'=>$imageData)); ?>
    </div>
</div>