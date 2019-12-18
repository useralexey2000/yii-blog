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
        
      ],

      

    ],
    
      'modules' => [
        'redactor' => [
          'class' => 'yii\redactor\RedactorModule',
          'uploadDir' => '@webroot/upload',
          'uploadUrl' => '@web/upload',
          'imageAllowExtensions'=>['jpg','png','gif']
      ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'defaultRoute' => 'users',
            'viewPath' => '@app/modules/admin/views',
        ],
    ],
    'controllerMap' => [
      'elfinder' => [
          'class' => 'mihaildev\elfinder\Controller',
          'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
          //'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
          'roots' => [
              [
                  'baseUrl'=>'@web',
                  'basePath'=>'@webroot/upload',
                  //'path' => 'upload/global',
                  //'name' => 'Global'
                  'access' => ['read' => 'admin', 'write' => 'admin'],
              ],
              [
                  'class' => 'mihaildev\elfinder\volume\UserPath',
                  'path'  => 'upload/files/user_{id}',
                  'name'  => 'MyDocuments'
              ],
          //     [
          //         'path' => 'files/some',
          //         'name' => ['category' => 'my','message' => 'Some Name'] //перевод Yii::t($category, $message)
          //     ],
          //     [
          //         'path'   => 'files/some',
          //         'name'   => ['category' => 'my','message' => 'Some Name'], // Yii::t($category, $message)
          //         'access' => ['read' => '*', 'write' => '*'] // * - для всех, иначе проверка доступа в даааном примере все могут видет а редактировать могут пользователи только с правами UserFilesAccess
          //     ]
          // ],
          // 'watermark' => [
          //     'source'         => __DIR__.'/logo.png', // Path to Water mark image
          //          'marginRight'    => 5,          // Margin right pixel
          //          'marginBottom'   => 5,          // Margin bottom pixel
          //          'quality'        => 95,         // JPEG image save quality
          //          'transparency'   => 70,         // Water mark image transparency ( other than PNG )
          //          'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP, // Target image formats ( bit-field )
          //          'targetMinPixel' => 200         // Target image minimum pixel size
          // ],
          ],
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
