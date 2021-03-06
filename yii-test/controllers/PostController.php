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
                //var_dump($model);die;
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
            
            return $this->redirect([
                'view',
                'id' => $comment->post_id,
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

    // //Not used
    // public function actionImage()
    // {
    //     error_log('in image method');

    //     $imageFolder = 'upload/images/'. Yii::$app->user->getId(). '/';

    //     if (!file_exists($imageFolder)) {
    //         mkdir($imageFolder, 0777, true);
    //     }

    //     reset ($_FILES);
    //     $temp = current($_FILES);
    //     if (is_uploaded_file($temp['tmp_name'])){

    //     // Sanitize input
    //     if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {

    //         return [
    //             'message' => 'Invalid file name',
    //             'code' => 400,
    //         ];
    //     }
    
    //     // Verify extension
    //     if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {

    //         return [
    //             'message' => 'Invalid extension',
    //             'code' => 400,
    //         ];
    //     }
    
    //     $filetowrite = $imageFolder . $temp['name'];

    //     move_uploaded_file($temp['tmp_name'], $filetowrite);
    
    //     // Respond to the successful upload with JSON.
    //     // Use a location key to specify the path to the saved image resource.
    //     return json_encode(array('location' => '/'.$filetowrite));

    //     } else {
    //       // Notify editor that the upload failed
    //     return [
    //         'message' => 'Server Error',
    //         'code' => 500,
    //     ];
    //     }
    // }
}   
