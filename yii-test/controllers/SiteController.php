<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Post;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup',], 
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'about'],
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    public function actions()
    {
        return ['error' => ['class' => 'yii\web\ErrorAction',],];
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionHome()
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
        return $this->render('home',[
            'posts'=> $posts,
        ]);
    }

    public function actionSignup()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_REGISTER;

        if($model->load(Yii::$app->request->post()) && $model->signup()){
            
            $model = new User();
            return $this->redirect(['login', 'model'=> $model]);
        }
        return $this->render('signup', ['model' => $model]);
    }
    
    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest){
            return $this->goHome();
        }
        $model = new User();
        $model->scenario = User::SCENARIO_LOGIN;
        if($model->load(Yii::$app->request->post()) && $model->login()){
            
            return $this->render('index');
        }
        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
       Yii::$app->user->logout();
       return $this->goHome();
    }
}
