<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo Yii::app()->baseUrl."/dashboard"?>" class="logo">
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/dist/img/site_logo.png" alt="logo" style="width: 100px;"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- Notifications: style can be found in dropdown.less -->
          
          <!-- Tasks: style can be found in dropdown.less -->
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php 
                if(Yii::app()->user->userType!='Customer'){
                      $userDetails = ProfileImages::model()->findByAttributes(array('owner_id'=>Yii::app()->user->id,'owner_type'=>'1'));
                      if($userDetails){?>
                  		<img src="<?php echo Yii::app()->request->baseUrl.'/uploads/partner/'.Yii::app()->user->partner.'/profile_photo/'.$userDetails->image?>" class="user-image" alt="User Image">
                      <?php }else{?>
                      	<img src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                      <?php }
                }else{
                    $userDetails = ProfileImages::model()->findByAttributes(array('owner_id'=>Yii::app()->user->id,'owner_type'=>'0'));
                    if($userDetails){?>
                  		<img src="<?php echo Yii::app()->request->baseUrl.'/uploads/customer/profile_photo/'.$userDetails->image?>" class="user-image" alt="User Image">
                    <?php }else{?>
                      	<img src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                    <?php }?>
                <?php }?>
              <span class="hidden-xs"><?php echo Yii::app()->user->fullname."(".Yii::app()->user->username.")";?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
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
                <p>
                  <?php echo Yii::app()->user->userType;?>
                </p>
              </li>
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                 <!--  <a href="#" class="btn btn-default btn-flat">Profile</a> -->
                </div>
                <div class="pull-right">
                  <a href="<?php echo Yii::app()->request->baseUrl; ?>/site/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
         
        </ul>
      </div>
    </nav>
  </header>