<section class="content">
	<div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo Common::modelCount('Partner','status','Y','0');?></h3>
              <p>Partners</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo Yii::app()->baseurl."/partner/admin";?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo Common::modelCount('ForkindUser','status','Y','0');?></h3>
              <p>Sales</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo Yii::app()->baseurl."/partner/admin";?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo Common::modelCount('Customer','status','Y','0');?></h3>
              <p>Customers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo Yii::app()->baseurl."/customer/";?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo Common::modelCount('Category','status','Y','0');?></h3>
              <p>Categories</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo Yii::app()->baseurl."/category/";?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Transaction Report</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                  </p>
                  <div class="chart">
                    <canvas id="salesChart" style="height: 180px;"></canvas>
                  </div>
                </div>
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Transaction data</strong>
                  </p>
                  <div class="progress-group">
                    <span class="progress-text">Total transaction amount</span>
                    <span class="progress-number"><b><?php echo Common::Total('Transaction','trans_amount','0');?></b></span>
                    <div class="progress lg">
                      <div class="progress-bar progress-bar-yellow" style="width: 60%"></div>
                    </div>
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">Total points earned</span>
                    <span class="progress-number"><b><?php echo Common::Total('Transaction','points_earned','0');?></b></span>
                    <div class="progress lg">
                      <div class="progress-bar progress-bar-green" style="width: 40%"></div>
                    </div>
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">Total points redeemed</span>
                    <span class="progress-number"><b><?php echo Common::Total('Transaction','points_redeemed','0');?></b></span>
                    <div class="progress lg">
                      <div class="progress-bar progress-bar-green" style="width: 70%"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Popular Partners</h3>
              <div class="box-tools pull-right">
                <span class="label label-danger"><?php echo Common::modelTotalCount('Review','status','Y','created_at','desc','8','0');?> New Members</span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="users-list clearfix">
              	<?php 
              	$Reviewusers = Common::modelAll('Review','status','Y','created_at','desc','8','0');
              	foreach($Reviewusers as $partner){
              	    $partnerData = Partner::model()->findByAttributes(array('id'=>$partner->partner_id));
              	    ?>
                    <li>
                      <img src="<?php echo Yii::app()->request->baseUrl.'/uploads/partner/'.$partnerData->id.'/logo/'.$partnerData->logo;?>" alt="Partner Logo">
                      <a class="users-list-name" href="<?php echo Yii::app()->baseurl."/sales/index?parent_id=".$partnerData->id;?>"><?php echo $partnerData->name;?></a>
                      <span class="users-list-date"><?php echo Common::getTimezone($partnerData->created_at,'d M y');?></span>
                    </li>
                <?php }?>
              </ul>
            </div>
            <div class="box-footer text-center">
              <a href="<?php echo Yii::app()->baseurl."/partner/admin/"?>" class="uppercase">View All Users</a>
            </div>
          </div>
        </div>
      	<div class="col-md-6">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Unused Cards</span>
              <span class="info-box-number"><?php echo Common::modelCount('Card','card_issue_status','Pending','0');?></span>
              <div class="progress">
                <div class="progress-bar" style="width: <?php echo Common::modelPercentage('Card','card_issue_status','Pending','0');?>%"></div>
              </div>
              <span class="progress-description"><?php echo Common::modelPercentage('Card','card_issue_status','Pending','0');?>% Increase in 30 Days</span>
            </div>
          </div>
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Active Cards</span>
              <span class="info-box-number"><?php echo Common::modelCount('Card','card_issue_status','Approved','0');?></span>
              <div class="progress">
                <div class="progress-bar" style="width: <?php echo Common::modelPercentage('Card','card_issue_status','Approved','0');?>%"></div>
              </div>
              <span class="progress-description"><?php echo Common::modelPercentage('Card','card_issue_status','Approved','0');?>% Increase in 30 Days</span>
            </div>
          </div>
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Open Enquiry</span>
              <span class="info-box-number"><?php echo Common::modelCount('Enquiry','status','N','0');?></span>
              <div class="progress">
                <div class="progress-bar" style="width: <?php echo Common::modelPercentage('Enquiry','status','N','0');?>0%"></div>
              </div>
              <span class="progress-description"><?php echo Common::modelPercentage('Enquiry','status','N','0');?>% Increase in 30 Days</span>
            </div>
          </div>
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Approved Enquiry</span>
              <span class="info-box-number"><?php echo Common::modelCount('Enquiry','status','Y','0');?></span>
              <div class="progress">
                <div class="progress-bar" style="width: <?php echo Common::modelPercentage('Enquiry','status','Y','0');?>0%"></div>
              </div>
              <span class="progress-description"><?php echo Common::modelPercentage('Enquiry','status','Y','0');?>% Increase in 30 Days</span>
            </div>
          </div>
        </div>
      </div>	
</section>  
<script src="https://code.jquery.com/jquery-1.11.3.js"></script> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bower_components/chart.js/Chart.js"></script> 
<script type="text/javascript">
var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
var salesChart       = new Chart(salesChartCanvas);
var salesChartData = {
  labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
  datasets: [
	  <?php 
	  $ParatnerData = Partner::model()->findAllByAttributes(array('status'=>'Y'));
	  if(count($ParatnerData)>0){
      $partnerArray=array();
        foreach($ParatnerData as $data){
          $partnerArray=array();
          $transactionList = Transaction::model()->findAllByAttributes(array('partner_id'=>$data->id));
          if(count($transactionList)>0){
              foreach($transactionList as $trans){
                  array_push($partnerArray,$trans->points_earned);
              }
              $resultArray = implode(',',$partnerArray);?>
              {
                  label               : '<?php echo $data->name;?>',
                  fillColor           : '<?php $randomString = md5($data->id);$r = substr($randomString,0,2);$g = substr($randomString,2,2);$b = substr($randomString,4,2);echo '#'.$r.$g.$b;?>',
                  strokeColor         : '<?php $randomString = md5($data->id);$r = substr($randomString,0,2);$g = substr($randomString,2,2);$b = substr($randomString,4,2);echo '#'.$r.$g.$b;?>',
                  pointColor          : '<?php $randomString = md5($data->id);$r = substr($randomString,0,2);$g = substr($randomString,2,2);$b = substr($randomString,4,2);echo '#'.$r.$g.$b;?>',
                  pointStrokeColor    : '<?php $randomString = md5($data->id);$r = substr($randomString,0,2);$g = substr($randomString,2,2);$b = substr($randomString,4,2);echo '#'.$r.$g.$b;?>',
                  pointHighlightFill  : '#fff',
                  pointHighlightStroke: '<?php $randomString = md5($data->id+1);$r = substr($randomString,0,2);$g = substr($randomString,2,2);$b = substr($randomString,4,2);echo '#'.$r.$g.$b;?>',
                  data                : [<?php echo $resultArray;?>]
                },
        <?php }
	   }
	}?>
  ]
};

var salesChartOptions = {
  // Boolean - If we should show the scale at all
  showScale               : true,
  // Boolean - Whether grid lines are shown across the chart
  scaleShowGridLines      : false,
  // String - Colour of the grid lines
  scaleGridLineColor      : 'rgba(0,0,0,.05)',
  // Number - Width of the grid lines
  scaleGridLineWidth      : 1,
  // Boolean - Whether to show horizontal lines (except X axis)
  scaleShowHorizontalLines: true,
  // Boolean - Whether to show vertical lines (except Y axis)
  scaleShowVerticalLines  : true,
  // Boolean - Whether the line is curved between points
  bezierCurve             : true,
  // Number - Tension of the bezier curve between points
  bezierCurveTension      : 0.3,
  // Boolean - Whether to show a dot for each point
  pointDot                : false,
  // Number - Radius of each point dot in pixels
  pointDotRadius          : 4,
  // Number - Pixel width of point dot stroke
  pointDotStrokeWidth     : 1,
  // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
  pointHitDetectionRadius : 20,
  // Boolean - Whether to show a stroke for datasets
  datasetStroke           : true,
  // Number - Pixel width of dataset stroke
  datasetStrokeWidth      : 2,
  // Boolean - Whether to fill the dataset with a color
  datasetFill             : true,
  // String - A legend template
  legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
  // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
  maintainAspectRatio     : true,
  // Boolean - whether to make the chart responsive to window resizing
  responsive              : true
};

salesChart.Line(salesChartData, salesChartOptions);
</script> 