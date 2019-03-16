<?php

class TransactionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
	
	public function actionIndex()
	{
	    if(Yii::app()->user->userType=="Partner" || Yii::app()->user->userType=="Sales"){
	        $model = new Transaction('search');
	        $this->page_title   = 'Transaction Management';
	        $model->unsetAttributes();  // clear any default values
	        if (isset($_GET['Transaction']))
	            $model->unsetAttributes();  // clear any default values
	            $model->attributes = $_GET['Transaction'];
	            $this->render('admin', array(
	                'model' => $model
	            ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
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
	    if(Yii::app()->user->userType=="Partner" || Yii::app()->user->userType=="Sales"){
    		$model=new Transaction;
    		$this->page_title   = 'Create Transaction';
    		if(isset($_POST['Transaction']))
    		{
    		    $ActiveFormula = Formula::model()->findByAttributes(array('status'=>'Y','partner_id'=>Yii::app()->user->partner));
    		    if(count($ActiveFormula)>0){
        			$model->attributes=$_POST['Transaction'];
        			$model->created_at = date('Y-m-d H:i:s');
        			$model->created_by  = Yii::app()->user->id;
        			$model->partner_id = Yii::app()->user->partner;
        			$model->points_reference = $ActiveFormula->id;
        			if($model->validate() && $model->save()){
        			    Yii::app()->user->setFlash('success','Transaction information has been created successfully');
        			    $this->redirect(Yii::app()->baseURL.'/transaction/index');
        			}
    		    }else{
    		        $error = "You must update your redeem formula before doing a transaction...!";
    		        Yii::app()->user->setFlash('error',$error);
    		        $this->render('create',array(
    		            'model'=>$model,'error'=>$error
    		        ));
    		    }
    		}
    
    		$this->render('create',array(
    			'model'=>$model,
    		));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        if(isset($_POST['Transaction']))
		{
		    $ActiveFormula = Formula::model()->findByAttributes(array('status'=>'Y','partner_id'=>Yii::app()->user->partner));
		    if(count($ActiveFormula)>0){
    			$model->attributes=$_POST['Transaction'];
    			$model->updated_at = date('Y-m-d H:i:s');
    			$model->updated_by  = Yii::app()->user->id;
    			if($model->validate() && $model->save()){
    			    Yii::app()->user->setFlash('success','Transaction information has been updated successfully');
    			    $this->redirect(Yii::app()->baseURL.'/transaction/index');
    		    }
    		}else{
    		    $error = "You must update your redeem formula before doing a transaction...!";
    		    Yii::app()->user->setFlash('error',$error);
    		    $this->render('create',array(
    		        'model'=>$model,'error'=>$error
    		    ));
    		}

		}
		$this->render('update',array(
			'model'=>$model,
		));
	}

	
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionAdmin()
	{
		$model=new Transaction('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Transaction']))
			$model->attributes=$_GET['Transaction'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Transaction::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='transaction-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
