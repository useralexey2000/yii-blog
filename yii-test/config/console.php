<?php

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'yiitest-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
    ],
    'components' => [
        'db' => $db,
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    
];

return $config;
