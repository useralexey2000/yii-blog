<?php
namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\Comment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class PostController extends Controller
{

    public $enableCsrfValidation = false;
    
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
                'only' => ['create', 'comment'],
                'denyCallback' => function ($rule, $action) {
                    throw new ForbiddenHttpException('You are not allowed to access this page');
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createPost'],
                    ],
                    // [
                    //    'allow' => true,
                    //    'actions' => ['view'],
                    //    'roles' => ['viewPost'],
                    // ],
                    [
                        'allow' => true,
                        'actions' => ['comment',],
                        'roles' => ['@'],
                    ],
                ],
            ],
         ];
    }
    //List all posts
    public function actionIndex()
    {
        $posts = new ActiveDataProvider([
            'query' => Post::find()->orderBy('updated_at DESC'),
            'pagination' => [
                'pageSize' => 3
            ]
        ]);
        return $this->render('index',[
            'posts'=> $posts,
            ]);
    }

    //View post
    public function actionView($id)
    {
        $comment = new Comment();
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'comment' => $comment,
        ]);
    }
    //Create post
    public function actionCreate()
    {
        $model = new Post();
        $model->user_id = Yii::$app->user->getId();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    //Delete post
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (\Yii::$app->user->can('deletePost', ['user_id' => $model->user_id])) {
            $model->delete();
            return $this->redirect(['index']);
       }else {
           throw new ForbiddenHttpException('You are not allowed to execute this action');
       }
    }

    //Update post
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (\Yii::$app->user->can('updatePost', ['user_id' => $model->user_id])){

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                var_dump($model);die;
                return $this->redirect(['view', 'id' => $model->id]); 
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
    }

    //Add comment to post
    public function actionComment()
    {
        $comment = new Comment();
        if($comment->load(Yii::$app->request->post())){
            $comment->user_id = Yii::$app->user->getId();
            $comment->save();
            $newComment = new Comment();

            return $this->render('view', [
                'model'=>$this->findModel($comment->post_id),
                'comment'=> $newComment,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
