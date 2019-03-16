<?php

class SalesController extends Controller
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
				'actions'=>array('create','update','ChangeStatus','View'),
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
	
	public function actionView($id)
	{
	    $model=$this->loadModel($id);
	    if(Yii::app()->user->userType=="Forkind" || Yii::app()->user->userType=="Admin" || (Yii::app()->user->userType=="Partner" && $model->parent_id==Yii::app()->user->partner)){
	        $partner = Partner::model()->findbyPk($model->parent_id);
	        $login = new Login;
	        $imageData = ProfileImages::model()->findByAttributes(array('owner_id'=>$id,'owner_type'=>'1'));
	        if($imageData){
	            $imageData = ProfileImages::model()->findByPk($imageData->id);
	            $old_pic = $imageData->image;
	            $img_path = Yii::app()->basePath.'/../uploads/partner/'.$partner->id.'/profile_image/'.$old_pic;
	        }else{
	            $imageData = new ProfileImages();
	            $old_pic=NULL;
	            $img_path = NULL;
	        }
	        $this->page_title ='View '.$model->first_name." ".$model->last_name;
	        if(isset($_POST['ForkindUser']))
	        {
	            $model->attributes=$_POST['ForkindUser'];
	            $model->updated_on = date('Y-m-d H:i:s');
	            if($model->save()){
	                $this->redirect(Yii::app()->baseURL.'/Sales/index?parent_id='.$model->parent_id);
	            }else{
	                $this->redirect(Yii::app()->baseURL.'/Sales/update/'.$id);
	            }
	        }
	        
	        $this->render('view',array(
	            'model'=>$model,'partner'=>$partner,'login'=>$login,'imageData'=>$imageData
	        ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	
	public function actionCreate($id)
	{
	    if(Yii::app()->user->userType=="Forkind" || Yii::app()->user->userType=="Admin" || (Yii::app()->user->userType=="Partner" && $id==Yii::app()->user->partner)){
	        $len=16;
	        $last=-1;
	        for ($i=0;$i<$len;$i++)
	        {
	            do
	            {
	                $next_digit=mt_rand(0,9);
	            }
	            while ($next_digit == $last);
	            $last=$next_digit;
	            $code.=$next_digit;
	        }
	        $model=new ForkindUser;
    		$login = new Login;
    		$imageData = new ProfileImages();
    		$partner = Partner::model()->findbyPk($id);
    		$this->page_title ='Create '.$partner->name." User";
    		if(isset($_POST['ForkindUser']))
    		{
    		    $transaction = Yii::app()->db->beginTransaction();
    		    $login->attributes=$_POST['Login'];
    		    $login->role_id = $_POST['Login']['role_id'];
    		    $login->username = $code;
    		    $login->password = md5('forkind');
    		    $login->login_status = 'N';
    		    if($login->validate() && $login->save(false)){
    		        $model->attributes=$_POST['ForkindUser'];
    		        $model->login_id = $login->id;
    		        $model->created_on = date('Y-m-d H:i:s');
    		        $model->parent_id = $id;
    		        if($model->validate() && $model->save()){
    		            $imageDetails=CUploadedFile::getInstance($imageData,'image');
    		            if($imageDetails!=NULL){
    		                $image_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/partner/'.$id.'/profile_image';
    		                if (!file_exists($image_path)){
    		                    mkdir($image_path, 0777, true);
    		                }
        		            $path = $_FILES['ProfileImages']['name']['image'];
        		            $ext = pathinfo($path, PATHINFO_EXTENSION);
        		            $imageData->attributes=$_POST['ProfileImages'];
        		            $imageData->image = $model->id."_".$model->first_name."_".date('ymdhis').".".$ext;
        		            $imageData->owner_id = $model->id;
        		            $imageData->owner_type = 1;
        		            $imageData->created_date = date('Y-m-d H:i:s');
        		            if($imageData->validate()) {
        		                $path = Yii::app()->basePath.'/../uploads/partner/'.$id."/profile_image/".$imageData->image;
        		                $imageDetails->saveAs($path);
        		                if($imageData->save()){
        		                    $transaction->commit();
        		                    Yii::app()->user->setFlash('success','partneruser has been created successfully');
        		                    $this->redirect(Yii::app()->baseURL.'/sales/index?parent_id='.$model->parent_id);
        		                }else{
        		                    $transaction->rollBack();
        		                    Yii::app()->user->setFlash('error','Failed to create partner');
        		                }
        		            }
    		            }else{
    		                $transaction->commit();
    		                Yii::app()->user->setFlash('success','partneruser has been created successfully');
    		                $this->redirect(Yii::app()->baseURL.'/sales/index?parent_id='.$model->parent_id);
    		            }
    		        }else{
    		            $transaction->rollBack();
    		            Yii::app()->user->setFlash('error','Failed to update partner');
    		        }
    		    }
    		 }
    		 $this->render('create',array(
    		     'model'=>$model,'partner'=>$partner,'login'=>$login,'imageData'=>$imageData
    		 ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	
	public function actionUpdate($id)
	{
	    $model=$this->loadModel($id);
	    if(Yii::app()->user->userType=="Forkind" || Yii::app()->user->userType=="Admin" || (Yii::app()->user->partner==$model->parent_id)){
	        $login = Login::model()->findByPk($model->login_id);
	        $partner = Partner::model()->findbyPk($model->parent_id);
    		$imageData = ProfileImages::model()->findByAttributes(array('owner_id'=>$id,'owner_type'=>'1'));
    		$img_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/partner/'.$partner->id.'/profile_image';
    		if (!file_exists($img_path)){
    		    mkdir($img_path, 0777, true);
    		}
    		if($imageData){
    		  $imageData = ProfileImages::model()->findByPk($imageData->id);
    		  $old_pic = $imageData->image;
    		  $old_path = $img_path."/".$old_pic;
    		}else{
    		    $imageData = new ProfileImages();
    		    $old_pic=NULL;
    		}
    		$this->page_title ='Update '.$model->first_name." ".$model->last_name;
    		if(isset($_POST['ForkindUser']))
    		{
    		    $path = $_FILES['ProfileImages']['name']['image'];
    		    $ext = pathinfo($path, PATHINFO_EXTENSION);
    		    $transaction = Yii::app()->db->beginTransaction();
    			$model->attributes=$_POST['ForkindUser'];
    			$model->updated_on = date('Y-m-d H:i:s');
    			if($model->validate() && $model->save()){
    			    $imageData->attributes=$_POST['ProfileImages'];
    			    $imageDetails=CUploadedFile::getInstance($imageData,'image');
    			    if($imageDetails!=NULL){
    			        $imageData->image = $model->id."_".$model->first_name."_".date('ymdhis').".".$ext;
        			    $imageData->owner_id = $id;
        			    $imageData->owner_type = 1;
        			    $imageData->created_date = date('Y-m-d H:i:s');
        			    if($imageData->validate()) {
        			        if($old_pic!=NULL && file_exists($old_path)){
        			             unlink($old_path);
        			         }
        			         $path = $img_path."/".$imageData->image;
        			         $imageDetails->saveAs($path);
        			         if($imageData->save()){
        			             $transaction->commit();
        			             Yii::app()->user->setFlash('success','Partneruser has been updated successfully');
        			             if(Yii::app()->user->id==$id){
        			                 $this->redirect(Yii::app()->baseURL.'/sales/update/'.$id);
        			             }else{
        			                 $this->redirect(Yii::app()->baseURL.'/sales/index?parent_id='.$model->parent_id);
        			             }
        			         }else{
        			             $transaction->rollBack();
        			             Yii::app()->user->setFlash('error','Failed to update partneruser');
        			         }
        			    }
    			    }else{
    			        $transaction->commit();
    			        Yii::app()->user->setFlash('success','Partneruser has been updated successfully');
    			        $this->redirect(Yii::app()->baseURL.'/sales/index?parent_id='.$model->parent_id);
    			    }
    			}else{
    			    $transaction->rollBack();
    			    Yii::app()->user->setFlash('error','Failed to update partner');
    			}
    		}
    		$this->render('update',array(
    		    'model'=>$model,'partner'=>$partner,'login'=>$login,'imageData'=>$imageData
    		));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex($parent_id){
	    if(Yii::app()->user->userType=="Forkind" || Yii::app()->user->userType=="Admin" || (Yii::app()->user->userType=="Partner" && $parent_id==Yii::app()->user->partner)){
	        $model = new ForkindUser('search');
	        $partner = Partner::model()->findbyPk($parent_id);
	        $this->page_title   = $partner->name.' User Management';
	        $model->unsetAttributes();  // clear any default values
	        $model->parent_id = $parent_id;
	        if (isset($_GET['ForkindUser']))
	            $model->unsetAttributes();  // clear any default values
	            $model->attributes = $_GET['Partner'];
	            $model->parent_id = $parent_id;
	            $this->render('admin', array(
	                'model' => $model,'partner'=>$partner
	            ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	
	public function actionAdmin()
	{
		$model=new ForkindUser('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ForkindUser']))
			$model->attributes=$_GET['ForkindUser'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionChangeStatus(){
	    if(isset($_POST['value'])){
	        $status = ($_POST['value']=='true')?'Y':'N';
	        $partner = ForkindUser::model()->findByPk($_POST['id']);
	        if($partner){
	            $loginData = Login::model()->findByAttributes(array('id'=>$partner->login_id));
	            if($loginData){
	                $loginData->login_status= $status;
	                if($loginData->save()){
    	                echo "1";
    	            }else{
    	                echo "0";
    	            }
	            }
	        }
	        
	    }
	}
	public function loadModel($id)
	{
		$model=ForkindUser::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='forkind-user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
