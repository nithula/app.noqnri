<?php

class DashboardController extends Controller {

    public $layout = '//layouts/column2';
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function init()
    {
        if((Yii::app()->user->getId()==null) && (!isset(Yii::app()->user->userType)))
        {
            $this->redirect(Yii::app()->baseURL."/site/");
        }
    }
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view','loadmap','loadloginstatus'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
            $this->page_title = Yii::app()->user->userType. '- Dashboard';
            $this->activeLink = 'dashboard';
            if(Yii::app()->user->userType=="Forkind" || Yii::app()->user->userType=="Admin"){
            	$partnerCount = Partner::model()->countByAttributes(array('status'=>'Y'));
            	$SalesCount = ForkindUser::model()->countByAttributes(array('status'=>'Y'));
            	$CustomerCount = Customer::model()->countByAttributes(array('status'=>'Y'));
            	$CategoryCount = Category::model()->countByAttributes(array('status'=>'Y'));
            	$this->render('index');
            }else if(Yii::app()->user->userType=="Partner" || Yii::app()->user->userType=="Sales"){
            	$this->render('partner_index');
            }else{
            	$this->render('customer_index');
            }
    }
}
