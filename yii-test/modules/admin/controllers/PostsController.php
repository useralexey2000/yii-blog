<?php

namespace app\modules\admin\controllers;
use Yii;
use yii\web\Controller;
use app\models\Post;
use app\models\Comment;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class PostsController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
               'class' => VerbFilter::className(),
               'actions' => [
                   'delete' => ['POST'],
               ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'delete', 'comments'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],

         ];
    }

    public function actionIndex()
    {
        $posts = new ActiveDataProvider([
            'query' => Post::find()->orderBy('updated_at DESC'),
            'pagination' => [
                'pageSize' =>20
            ],
        ]);
        return $this->render('index', ['posts' =>$posts,]);
    }

    public function actionView($id)
    {
        $post = $this->findModel($id);
        return $this->render('view', [
            'model' => $post,
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model'=> $model,
            ]);
    }
        
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionComments($id){
        $comments = new ActiveDataProvider([
            'query' => Comment::find()->where(['post_id'=> $id])->orderBy('updated_at DESC'),
            'pagination' => [
                'pageSize' =>20,
            ],
        ]);
        //$comments = $this->findModel($id)->comments;
        return $this->render('comments', [
            'comments' => $comments,
        ]);
    }

        protected function findModel($id)
        {
            if (($model = Post::findOne($id)) !== null) {
                return $model;
            }
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    