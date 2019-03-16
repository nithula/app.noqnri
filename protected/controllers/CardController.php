<?php

class CardController extends Controller
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
			    'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
			    'actions'=>array('CardForm','EditCard','index','LoadModelContent','Submit_card_list','Import','cardDelete','ViewCard','changeStatus','InsertCard','Update'),
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
    
	public function actionCardForm(){
	    $this->layout=false;
	    $model = new Card;
	    $this->render('card_form',array(
	        'model'=>$model,
	    ));
	}
	public function actionAppendList(){
	    $this->layout=false;
	    $model = new Card('search');
	    $this->page_title   = 'Card Management';
	    $model->unsetAttributes();  // clear any default values
	    if (isset($_GET['Card']))
	        $model->unsetAttributes();  // clear any default values
	        $model->attributes = $_GET['Card'];
	        $this->render('card_list', array(
	            'model' => $model
	        ));
	}
	public function actionInsertCard(){
	    header('Content-Type: application/json');
	    if(isset($_POST['Card']['id'])&&$_POST['Card']['id']!=0){
	        $model = Card::model()->findByPk($_POST['Card']['id']);
	        $successmsg = "Card successfully updated";
	        $errormsg = "Error while updating card";
	        $pageTitle = "Update Card";
	    }else{
	        $model=new Card;
	        $successmsg = "New card created successfully";
	        $errormsg = "Error while creating card";
	        $pageTitle = "Create New Card";
	    }
	    $this->page_title   = $pageTitle;
	    if(isset($_POST['Card']))
	    {
	        $model->attributes=$_POST['Card'];
	        if(isset($_POST['Card']['id'])&&$_POST['Card']['id']!=0){
	            $model->updated_at = date('Y-m-d H:i:s');
	            $model->updated_by = Yii::app()->user->id;
	        }else{
    	        $model->created_at = date('Y-m-d H:i:s');
    	        $model->created_by = Yii::app()->user->id;
	        }
	        if($model->validate()&&$model->save()){
	            Yii::app()->user->setFlash('success', $successmsg);
	            Common::activityLog($model->id, 'CARD', $successmsg, date('Y-m-d H:i:s'));
	            $this->renderJSON(array('status'=>'success','msg'=>$successmsg));
	        }else{
	            $errors = $model->geterrors();
	            $this->renderJSON(array('status'=>'error','msg'=>'erros','phone_number'=>$errors['phone_number'][0],'card_number'=>$errors['card_number'][0]));
	        }
	    }
	}

	
	public function actioncardDelete($id)
	{
	    if(Yii::app()->user->userType=="Super Admin" || Yii::app()->user->userType=="Admin"){
	        $model = $this->loadModel($id);
	        $this->loadModel($id)->delete();
	        Yii::app()->user->setFlash('success', "Card has been deleted successfully.");
	        $message = "Card has been deleted";
	        Common::activityLog($model->id, 'CARD', $message, date('Y-m-d H:i:s'));
	        $this->redirect(array('card'));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	    if(Yii::app()->user->userType=="Forkind" || Yii::app()->user->userType=="Admin"){
	        $model = new Card('search');
	        $this->page_title   = 'Card Management';
	        $model->unsetAttributes();  // clear any default values
	        if (isset($_GET['Card']))
	            $model->unsetAttributes();  // clear any default values
	            $model->attributes = $_GET['Card'];
	            $this->render('admin', array(
	                'model' => $model,'card'=>$card
	            ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}
	
	public function actionLoadModelContent(){
	    $this->layout=false;
	    $model = new Card();
	    $this->render('import_csv_form', array('model'=>$model));
	}
	public function actionEditCard(){
	    $this->layout=false;
	    $this->page_title   = 'Edit Card';
	    $model = $this->loadModel($_POST['id']);
	    $this->render('card_form', array('model'=>$model));
	}
	
	public function actionchangeStatus(){
	    if(isset($_POST['value'])){
	        $status = ($_POST['value']=='true')?'Y':'N';
	        $card = Card::model()->findByPk($_POST['id']);
	        if($card){
	            $card->card_status= $status;
	            if($card->save()){
	                echo "1";
	            }else{
	                echo "0";
	            }
	        }
	    }
	}
	
	public function actionSubmit_card_list(){
	    $model=new Card();
	    if(isset($_FILES))
	    {
	        $file = CUploadedFile::getInstance($model,'csv_file');
	        try{
	            $transaction = Yii::app()->db->beginTransaction();
	            $handle = fopen("$file->tempName", "r");
	            $row = 1;
	            $successCount = array();
	            $failureCount = array();
	            $duplicate = array();
	            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	                $cardata = Card::model()->findByAttributes(array('card_number'=>$data[0]));
	                if(count($cardata)>0){
	                    array_push($duplicate,$row);
	                }else{
	                    $newmodel=new Card;
	                    $newmodel->card_number=$data[0];
	                    //$newmodel->phone_number=$data[1];
	                    $newmodel->card_issue_status="Pending";
	                    $newmodel->created_at = date('Y-m-d H:i:s');
	                    $newmodel->created_by=Yii::app()->user->id;
	                    if($newmodel->save()){
	                        array_push($successCount,$row);
	                    }else{
	                        array_push($failureCount,$row);
	                    }
	                }
	                $row++;
	            }
	            
	            if(empty($failureCount) && count($successCount)>0){
	               $transaction->commit();
	               $this->renderJSON(array('status'=>'success','msg'=>'Success','duplicate'=>count($duplicate),'success'=>count($successCount),'failed'=>count($failureCount)));
	            }else{
	                $transaction->rollback();
	                $this->renderJSON(array('status'=>'failed','msg'=>'Error','duplicate'=>count($duplicate),'success'=>count($successCount),'failed'=>count($failureCount)));
	            }
	        }catch(Exception $error){
	            
	        } 
	    }else{
	        echo(json_encode(array('status'=>'failed','msg'=>'Please upload a valid csv file')));
	    }
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Card('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Card']))
			$model->attributes=$_GET['Card'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Card the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Card::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	/**
	 * Performs the AJAX validation.
	 * @param Card $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='card-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
