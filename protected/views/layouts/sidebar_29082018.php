<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
    <div class="pull-left image">
    <?php 
    if(Yii::app()->user->userType!='Customer'){
        $userDetails = ProfileImages::model()->findByAttributes(array('owner_id'=>Yii::app()->user->id,'owner_type'=>'1'));
          if($userDetails){?>
      		<img src="<?php echo Yii::app()->request->baseUrl.'/uploads/partner/'.Yii::app()->user->partner.'/profile_photo/'.$userDetails->image?>" class="img-circle" alt="User Image">
          <?php }else{?>
          	<img src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
          <?php }
    }else{
        $userDetails = ProfileImages::model()->findByAttributes(array('owner_id'=>Yii::app()->user->id,'owner_type'=>'0'));
        if($userDetails){?>
      		<img src="<?php echo Yii::app()->request->baseUrl.'/uploads/customer/profile_photo/'.$userDetails->image?>" class="img-circle" alt="User Image">
        <?php }else{?>
          	<img src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        <?php }?>
    <?php }?>
    </div>
    <div class="pull-left info">
      <p><?php echo Yii::app()->user->fullname;?><br/>(<?php echo (Yii::app()->user->userType=="Forkind")?"Forkind":Yii::app()->user->userType;?>)</p>
      <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
    </div>
  </div>
 
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    <li><a href="<?php echo Yii::app()->baseUrl . '/dashboard' ?>"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
    <?php if(Yii::app()->user->userType=="Forkind" || Yii::app()->user->userType=="Admin"){?>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/sales/update/'.Yii::app()->user->getId(); ?>"><i class="fa fa-user-secret"></i> <span>Update Profile</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/category'; ?>"><i class="fa fa-list" aria-hidden="true"></i> <span>Category Management</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/partner/admin'; ?>"><i class="fa fa-handshake-o" aria-hidden="true"></i> <span>Partner Management</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/customer'; ?>"><i class="fa fa-user-circle" aria-hidden="true"></i> <span>Customer Management</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/card'; ?>"><i class="fa fa-credit-card" aria-hidden="true"></i> <span>Card Management</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report/performance_report'; ?>"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Performance Report</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report/redeem_report'; ?>"><i class="fa fa-bar-chart-o" aria-hidden="true"></i> <span>Redemption Report</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report'; ?>"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Report</span></a></li>
    <?php }else if(Yii::app()->user->userType=="Staff"){?>
        <li><a href="<?php echo Yii::app()->baseUrl.'/card'; ?>"><i class="fa fa-credit-card" aria-hidden="true"></i> <span>Card Management</span></a></li>
        <li><a href="<?php echo Yii::app()->baseUrl.'/report'; ?>"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Report</span></a></li>
    <?php }elseif(Yii::app()->user->userType=="Partner"){?>
    	<!-- <li><a href="<?php echo Yii::app()->baseUrl.'/sales/update/'.Yii::app()->user->getId(); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Update Profile</span></a></li> -->
    	<li><a href="<?php echo Yii::app()->baseUrl.'/sales/index?parent_id='.Yii::app()->user->partner; ?>"><i class="fa fa-user-circle" aria-hidden="true"></i> <span>Users Management</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/transaction/modify_transction'; ?>"><i class="fa fa-area-chart" aria-hidden="true"></i> <span>Transaction</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report/performance_report'; ?>"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Performance Report</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report/redeem_report'; ?>"><i class="fa fa-bar-chart-o" aria-hidden="true"></i> <span>Redemption Report</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report'; ?>"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Report</span></a></li>
    <?php }else if(Yii::app()->user->userType=="Sales"){?>
        <!-- <li><a href="<?php echo Yii::app()->baseUrl.'/sales/update/'.Yii::app()->user->getId(); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Update Profile</span></a></li> -->
        <li><a href="<?php echo Yii::app()->baseUrl.'/report/transaction_report'; ?>"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Transaction Report</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report/redeem_points'; ?>"><i class="fa fa-bar-chart-o" aria-hidden="true"></i> <span>Redeem Points</span></a></li>
    	<li><a href="<?php echo Yii::app()->baseUrl.'/report'; ?>"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Report</span></a></li>
    <?php }else{
        
    }?>
  </ul>
</section>
<!-- /.sidebar -->
</aside>