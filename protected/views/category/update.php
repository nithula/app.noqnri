<?php
if($parentData){
    $this->breadcrumbs=array(
        'Category List'=>array('category/index'),
        $parentData->category=>array('category/CategoryList?parentId='.$parentId),
        'Update',
    );
}else{
    $this->breadcrumbs=array(
        'Category List'=>array('category/index'),
        'Update',
    );
}
?>
<div class="row">
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

<h1>Update Category - <?php echo $model->category;?></h1>
<hr>
<?php echo $this->renderPartial('_form',array('model'=>$model,'parentId'=>$parentId,'parentData'=>$parentData)); ?>
</div>
</div>
</div>