<?php

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'yiitest',
    'basePath' => dirname(__DIR__),
    'aliases' => [
      '@bower' => '@vendor/bower-asset',
    ],
    'components' => [
      'user' => [
        'identityClass' => 'app\models\User',
      ],
      'authManager' => [
        'class' => 'yii\rbac\DbManager',
      ],
      'db' => $db,
      'request' => [
        'enableCookieValidation' => true,
        'cookieValidationKey' => 'mysecret',
      ],
      'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
          '/' => 'site/index',
          '/posts' => 'post/index',
          'admin/<controller>s' => 'admin/<controller>s/index',
          'admin/<controller>s/<id:\d+>' => 'admin/<controller>s/view',
          'admin/posts/<id:\d+/comments>' => 'admin/posts/comments',
        ],
      ]
    ],
      'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'defaultRoute' => 'users',
            'viewPath' => '@app/modules/admin/views',
        ],
    ],
  ];

  // if (YII_ENV_DEV) {
  //   // configuration adjustments for 'dev' environment
  //   $config['bootstrap'][] = 'debug';
  //   $config['modules']['debug'] = [
  //       'class' => 'yii\debug\Module',
  //       // uncomment the following to add your IP if you are not connecting from localhost.
  //       //'allowedIPs' => ['127.0.0.1', '::1'],
  //   ];

  //   $config['bootstrap'][] = 'gii';
  //   $config['modules']['gii'] = [
  //       'class' => 'yii\gii\Module',
  //       // uncomment the following to add your IP if you are not connecting from localhost.
  //       //'allowedIPs' => ['127.0.0.1', '::1'],
  //   ];
  //}
  
return $config;
