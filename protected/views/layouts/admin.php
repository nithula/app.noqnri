<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->pageTitle?></title>
  <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.png"> 
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/dist/css/AdminLTE.css">
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/custom.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/morris.js/morris.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/sweetalert2.min.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/additional_style.css">
</head>
<script type="text/javascript">
	var Baseurl = '<?php echo Yii::app()->request->baseUrl; ?>';
</script>
<body class="hold-transition skin-blue sidebar-mini">
<?php echo $this->renderPartial('//layouts/header', array()); 
        if (!$this->hideSidebar) {
            echo $this->renderPartial('//layouts/sidebar', array());
        }
?>
 <div class="wrapper">
<div class="content-wrapper">
 <section class="content-header">
    <h1>
        <?php echo isset($this->page_title) ? $this->page_title : ''; ?> 
    </h1>  
    <div class="clear"></div>                                                                                                                                                 
    <?php if (isset($this->breadcrumbs)): ?>
        <?php
        $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs,
            'homeLink' => CHtml::link('<i class="fa fa-dashboard"></i>Home', Yii::app()->createAbsoluteUrl('Dashboard')),
        ));                        
        ?>

        <!-- breadcrumbs -->
<?php endif ?>
</section>
<?php echo $content; ?>
<!-- /.content -->
</div>
<?php echo $this->renderPartial('//layouts/footer', array()); ?>
 </body>
 <div class="se-pre-con"></div>
 <style>
 .no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/loader.gif') center no-repeat #fff;
}
 </style>
 <script type="text/javascript">
 $(window).load(function() {
		$(".se-pre-con").fadeOut("slow");
 });
 </script>
</html>
