<?php

class EnquiryController extends Controller
{
	
	public $layout='//layouts/column2';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','index','admin','ApproveEnquiryAction','submitReplay'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function init()
	{
	    if((Yii::app()->user->getId()==null) && (!isset(Yii::app()->user->userType)))
	    {
	        $this->redirect(Yii::app()->baseURL."/site/");
	    }
	}
	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new Enquiry;
		if(isset($_POST['Enquiry']))
		{
			$model->attributes=$_POST['Enquiry'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Enquiry']))
		{
			$model->attributes=$_POST['Enquiry'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex()
	{
	    if(Yii::app()->user->userType=="Forkind" || Yii::app()->user->userType=="Admin"){
	        $model = new Enquiry('search');
	        $this->page_title   = 'Enquiry';
	        $model->unsetAttributes();  // clear any default values
	        if (isset($_GET['Enquiry']))
	            $model->unsetAttributes();  // clear any default values
	            $model->attributes = $_GET['Enquiry'];
	            $this->render('admin', array(
	                'model' => $model,'card'=>$card
	            ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	public function actionAdmin()
	{
		$model=new Enquiry('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Enquiry']))
			$model->attributes=$_GET['Enquiry'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Enquiry::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='enquiry-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionApproveEnquiryAction(){
	    $this->layout=false;
	    if(isset($_POST['id'])){
	        $this->page_title   = 'Approve Enquiry';
	        $model = $this->loadModel($_POST['id']);
	        $card =new Card();
	        $this->render('approve_form', array('model'=>$model,'card'=>$card));
	    }
	}
	public function actionsubmitReplay(){
	    if(isset($_POST['Enquiry'])){
	        $id = $_POST['Enquiry']['id'];
	        $EnquiryData = Enquiry::model()->findByPk($id);
	        $transaction = Yii::app()->db->beginTransaction();
	        if(count($EnquiryData)>0){
	            $EnquiryData->replay = $_POST['Enquiry']['replay'];
	            $EnquiryData->status = $_POST['status'];
	            if($EnquiryData->save(false)){
	                $cardData = Card::model()->findByPk($_POST['Card']['card_number']);
	                if(count($cardData)>0){
	                    Yii::app()->user->setFlash('success','Enquiry has been successfully approved');
	                    $cardData->phone_number = $_POST['Enquiry']['mobile_number'];
	                    $cardData->save(false);
	                    $to = $EnquiryData->email_id;
	                    if($EnquiryData->email_id!=NULL){
    	                    $subject = Yii::app()->name. " - Enquiry Submit";
    	                    $myfile = fopen(dirname(dirname(dirname((__FILE__)))).'/templates/enquiry_replay_template.html', "r") or die("Unable to open file!");
    	                    $html =  fread($myfile,filesize(dirname((dirname(dirname(__FILE__)))).'/templates/enquiry_replay_template.html'));
    	                    fclose($myfile);
    	                    $site_name = Yii::app()->name;
    	                    $name = $EnquiryData->full_name;
    	                    $content_text = ($EnquiryData->replay!=NULL)?$EnquiryData->replay:'Your request has been approved';
    	                    $link = "<a href=http://noqnri.com/>http://noqnri.com/</a>";
    	                    $username = $cardData->card_number;
    	                    $company = Yii::app()->name;
    	                    $phone = "0484-285-236-05";
    	                    $gmail = "info@gmail.com";
    	                    $website = "http://www.noqnri.com";
    	                    $keys = array('{site_name}','{name}','{content_text}','{link}','{username}','{company_name}','{phone}','{gmail}','{website}');
    	                    $values =array($site_name,$name,$link,$username,$company,$phone,$gmail,$website);
    	                    $htmlContent=str_replace($keys,$values,$html);
    	                    $headers='From: noreply@noqnri.com \n';
    	                    $headers.='Reply-To: noreply@noqnri.com \n';
    	                    $headers.='X-Mailer: PHP/' . phpversion().'\n';
    	                    $headers.= 'MIME-Version: 1.0' . "\n";
    	                    $headers.= 'Content-type: text/html; charset=iso-8859-1 \n';
    	                    mail($to,$subject,$htmlContent,$headers);
	                    }
	                    $transaction->commit();
	                    echo "1";
	                }else{
	                    $transaction->rollBack();
	                    echo "0";
	                }
	            }else{
	                $transaction->rollBack();
	                echo "0";
	            }
	        }else{
	            echo "0";
	        }
	    }
	}
}
