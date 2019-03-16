<?php
$this->breadcrumbs = array(
    'Error '.$error['code'],
);?>
<div class="box">
    <div class="box-body" style="text-align: center;">
    	<?php if($error['code']=='401'){?>
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/401.png">
		<?php }else{?>
		    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/404.png">
		<?php }?>
		<div class="col-sm-12">
			<a href="<?php echo Yii::app()->request->baseUrl."/site/"?>" style="padding:25px;background-color: #A9A9A9;text-decoration:none;color:#000;font-weight:bold;">Take me out..!</a>
		</div>
	</div>
</div>