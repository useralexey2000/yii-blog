<?php
namespace app\controllers;

use Yii;
use app\models\Post;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class HomeController extends Controller
{
    public function behaviors()
    {
        return [
             'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'denyCallback' => function ($rule, $action) {
                    throw new ForbiddenHttpException('You are not allowed to access this page');
                },
                'rules' => [
                    [
                       'allow' => true,
                       'actions' => ['index',],
                       'roles' => ['@'],
                    ],
                ],
            ],
         ];
    }
    //List all user posts
    public function actionIndex()
    {
        $userId = Yii::$app->user->getId();
        $posts = new ActiveDataProvider([
            'query' => Post::find()
            ->where(['user_id'=> $userId])
            ->orderBy('updated_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);
        return $this->render('index',[
            'posts'=> $posts,
        ]);
    }
}