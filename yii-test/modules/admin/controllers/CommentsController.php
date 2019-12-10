<?php

namespace app\modules\admin\controllers;
use Yii;
use yii\web\Controller;
use app\models\Comment;
use yii\data\ActiveDataProvider;

class CommentsController extends Controller
{
    public function actionIndex()
    {
        $posts = new ActiveDataProvider([
            'query' => Comment::find()->orderBy('updated_at DESC'),
            'pagination' => [
                'pageSize' =>20
            ],
        ]);
        return $this->render('index', ['comments' =>$comments,]);
    }

    public function actionView($id)
    {
        $comment = $this->findModel($id);
        return $this->render('view', [
            'model' => $comment,
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
            $comment = $this->findModel($id);
            $postId = $comment->post_id;
            $comment->delete();
            return $this->redirect(['/admin/posts/comments', 'id'=>$postId]);
        }

        protected function findModel($id)
        {
            if (($model = Comment::findOne($id)) !== null) {
                return $model;
            }
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    