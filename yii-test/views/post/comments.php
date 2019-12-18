<?php 

use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\models\Comment;

$dataProvider = new ActiveDataProvider([
    'query' => Comment::find()->where(['post_id'=> $model->id])->orderBy('updated_at DESC'),
    'pagination' => [
        'pageSize' =>3,
    ],
]);
?>
<?=ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_comment',
    'itemOptions' => [
        'tag'=>'li',
        'class'=>'comment-list',
    ],
]);
?>