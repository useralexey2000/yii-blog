<?php

namespace app\modules\admin\controllers;
use yii\web\Controller;
use yii\filters\AccessControl;

class FilesController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index',],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
         ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
    