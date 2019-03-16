<?php

class CategoryController extends Controller
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
				'actions'=>array('Create','Update','Admin','categoryList','ChangeStatus'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	
	public function actionCreate($id='')
	{
		$model=new Category;
		$parentData = array();
		$this->page_title   = 'Create Category';
		if($id!=''){
		    $model->parent_category = $id;
		    $parentData = Category::model()->findByPk($id);
		    $this->page_title   = 'Create sub-category :' .$parentData->category;
		}
		
		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			$model->category_discription = $_POST['Category']['category_discription'];
			if($id!=''){
			    $model->parent_category = $_POST['parent_category'];
			}
			$model->created_at = date('Y-m-d H:i:s');
			if($model->save()){
			    $imageDetails=CUploadedFile::getInstance($model,'category_image');
			    if($imageDetails!=NULL){
			        $image_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/category/';
			        if (!file_exists($image_path)){
			            mkdir($image_path, 0777, true);
			        }
			        $file_name = $_FILES['Category']['name']['category_image'];
			        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
			        $categorysubname = str_replace(' ','_',$model->category);
			        $categoryName = str_replace(' ','_',$categorysubname);
			        $model->category_image = $model->id."_".$categoryName."_".date('ymdhis').".".$ext;
			        $path = Yii::app()->basePath.'/../uploads/category/'.$model->category_image;
			        $imageDetails->saveAs($path);
			        $model->save(false);
			    }
			    $bannerDetails=CUploadedFile::getInstance($model,'category_banner');
			    if($bannerDetails!=NULL){
			        $banner_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/category/banner/';
			        if (!file_exists($banner_path)){
			            mkdir($banner_path, 0777, true);
			        }
			        $banner_name = $_FILES['Category']['name']['category_banner'];
			        $ext = pathinfo($banner_name, PATHINFO_EXTENSION);
			        $categorysubname = str_replace(' ','_',$model->category);
			        $name = str_replace(' ','_',$categorysubname);
			        $categoryBanner = str_replace('','_',$name);
			        $model->category_banner = $model->id."_".$categoryBanner."_".date('ymdhis').".".$ext;
			        $path = Yii::app()->basePath.'/../uploads/category/banner/'.$model->category_banner;
			        $bannerDetails->saveAs($path);
			        $model->save(false);
			    }
			    if($id!=NULL){
			        Yii::app()->user->setFlash('success','Sub-category has been created successfully');
			        Common::activityLog($model->id, 'CATEGORY', 'New Category '.$categoryName.' created', date('Y-m-d H:i:s'));
			        $this->redirect(Yii::app()->baseURL.'/category/categoryList?parentId='.$id);
			    }else{
			     Yii::app()->user->setFlash('success','Category has been created successfully');
			     $this->redirect(Yii::app()->baseURL.'/category');
			    }
			}else{
			    Yii::app()->user->setFlash('success','Error while creating category');
			}
		}

		$this->render('create',array(
		    'model'=>$model,'parentId'=>$id,'parentData'=>$parentData
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$parentData = Category::model()->findByPk($model->parent_category);
		if($model->category_image!=NULL){
		    $old_image = $model->category_image;
		}
		if($model->category_banner!=NULL){
		    $old_banner = $model->category_banner;
		}
		if($parentData){
		  $this->page_title   = 'Update sub-category :' .$parentData->category;
		}else{
		    $this->page_title   = 'Update category : '.$model->category;
		}
		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			$model->category_discription = $_POST['Category']['category_discription'];
			$model->updated_at = date('Y-m-d H:i:s');
			if($model->save()){
			    $imageDetails=CUploadedFile::getInstance($model,'category_image');
			    if($imageDetails!=NULL){
			        $image_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/category/';
			        if($old_image!=NULL){
			            unlink($image_path.$old_image);
			        }
			        if (!file_exists($image_path)){
			            mkdir($image_path, 0777, true);
			        }
			        $file_name = $_FILES['Category']['name']['category_image'];
			        $categoryName = str_replace(' ','_',$model->category);
			        $categoryName = str_replace(':','_',$categoryName);
			        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
			        $model->category_image = $model->id."_".$categoryName."_".date('ymdhis').".".$ext;
			        $path = Yii::app()->basePath.'/../uploads/category/'.$model->category_image;
			        $imageDetails->saveAs($path);
			        $model->save(false);
			    }else{
			        if($old_image!=NULL){
			            $model->category_image = $old_image;
			            $model->save(false);
			        }
			    }
			    $bannerDetails=CUploadedFile::getInstance($model,'category_banner');
			    if($bannerDetails!=NULL){
			        $banner_path = (dirname(dirname(dirname(__FILE__)))).'/uploads/category/banner/';
			        if($old_banner!=NULL){
			            unlink($banner_path.$old_banner);
			        }
			        if (!file_exists($banner_path)){
			            mkdir($banner_path, 0777, true);
			        }
			        $banner_name = $_FILES['Category']['name']['category_banner'];
			        $ext = pathinfo($banner_name, PATHINFO_EXTENSION);
			        $name = str_replace(' ','_',$model->category);
			        $categoryBanner = str_replace(' ','_',$name);
			        $model->category_banner = $model->id."_".$categoryBanner."_".date('ymdhis').".".$ext;
			        $path = Yii::app()->basePath.'/../uploads/category/banner/'.$model->category_banner;
			        $bannerDetails->saveAs($path);
			        $model->save(false);
			    }else{
			        if($old_banner!=NULL){
			            $model->category_banner = $old_banner;
			            $model->save(false);
			        }
			    }
			    if($model->parent_category!=0){
			        Yii::app()->user->setFlash('success','Sub-category has been updated successfully');
			        $this->redirect(Yii::app()->baseURL.'/Category/CategoryList?parentId='.$model->parent_category);
			    }else{
			        Yii::app()->user->setFlash('success','Category has been updated successfully');
			        $this->redirect(Yii::app()->baseURL.'/Category');
			    }
			}else{
			    Yii::app()->user->setFlash('success','Error while creating category');
			}
		}

		$this->render('update',array(
		    'model'=>$model,'parentId'=>$model->parent_category,'parentData'=>$parentData
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}


	public function actionIndex()
	{
	    if(Yii::app()->user->userType=="Forkind" || Yii::app()->user->userType=="Admin"){
	        $model = new Category('search');
	        $this->page_title   = 'Category Management';
	        $model->unsetAttributes();  // clear any default values
	        $model->parent_category=0;
	        if (isset($_GET['Category']))
	            $model->unsetAttributes();  // clear any default values
	            $model->parent_category=0;
	            $model->attributes = $_GET['Category'];
	            $this->render('admin', array(
	                'model' => $model
	            ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}

	public function actionCategoryList($parentId){
	    if(Yii::app()->user->userType=="Forkind" || Yii::app()->user->userType=="Admin"){
	        $categoryData=$this->loadModel($parentId);
	        $model = new Category('search');
	        $this->page_title   = $categoryData->category.' sub category list';
	        $model->unsetAttributes();  // clear any default values
	        $model->parent_category=$parentId;
	        if (isset($_GET['Category']))
	            $model->unsetAttributes();  // clear any default values
	            $model->attributes = $_GET['Category'];
	            $this->render('categoryList', array(
	                'model' => $model,'categoryData'=>$categoryData
	            ));
	    }else{
	        throw new CHttpException(401,'You are not authorised to perform this action');
	    }
	}
	
	public function actionChangeStatus(){
	    if(isset($_POST['value'])){
	        $status = ($_POST['value']=='true')?'Y':'N';
	        $partner = Category::model()->findByPk($_POST['id']);
	        if($partner){
	            $partner->status= $status;
	            if($partner->save()){
	                echo "1";
	            }else{
	                echo "0";
	            }
	        }
	        
	    }
	}
	
	public function actionAdmin()
	{
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
