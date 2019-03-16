<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
Yii::setPathOfAlias('vendor', dirname(__FILE__) . '/../vendor');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'NoQnri',
    'defaultController' => 'site', 
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.yiisortablemodel.*',
        'ext.YiiMailer.YiiMailer',
        'ext.morris.*',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'generatorPaths' => array(
                'bootstrap.gii',
            ),
            'class' => 'system.gii.GiiModule',
            'password' => 'forkind@123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('*', '::1'),
        ),
    ),
    // application components
    // application components
    'components' => array(
        'clientScript' => array(
            'scriptMap' => array(
                // 'jquery.js' => false,
                'jquery.ba-bbq.min.js' => false,
                'jquery.ba-bbq.js'=>false,
                'jquery.yiiactiveform.js'=>false,
                // 'core.css'      => false,
                // 'styles.css'    => false,
                // 'pager.css'     => false,
                // 'default.css'   => false,
            ),
           
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl' => array('site')
        ),
        'phpThumb' => array(
            'class' => 'ext.EPhpThumb.EPhpThumb',
            'options' => array()
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                'gii' => 'gii',
                'gii/<controller:\w+>' => 'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
            'showScriptName' => false
        ),
        'db' => array(
            //'connectionString' => 'mysql:host=cloud9.crskpqcg2cxx.us-west-2.rds.amazonaws.com;dbname=cloud9_dev',
            'connectionString' => 'mysql:host=localhost;dbname=chedawuk_forkind',
            'emulatePrepare' => true,
            'username' => 'chedawuk_forkind',
            'password' => 'jfGNYE@X$Id~',
            'charset' => 'utf8',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, trace, info',
                ),
                // uncomment the following to show log messages on web pages
                
                // array(
                // 'class'=>'CWebLogRoute',
                // ),
                
            ),
        ),
    ),
);

