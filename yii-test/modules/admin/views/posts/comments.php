<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'post-comments';
?>
<div class="post-comments">
<h3><?=Html::encode($this->title)?></h3>

<?php 

echo GridView::widget([
    'dataProvider' => $comments,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'ID',
            'attribute' =>'id',
        ],
        [
            'label' => 'content',
            'attribute' =>'content',
        ],
        [
            'label' => 'Created at',
            'attribute' =>'created_at',
        ],
        [
            'label' => 'Updated at',
            'attribute' =>'updated_at',
        ],
        [   
            'label' => 'UserId',
            'attribute'=> 'user_id',
        ],
        [   
            'label' => 'PostId',
            'attribute'=> 'post_id',
        ],
        [   
            'header' => 'Action',
            'class' => 'yii\grid\ActionColumn',
            'controller' => '/admin/comments',
        //     'buttons' => [
        //         'update' => function ($url, $model, $key){
        //             return Html::a('', ['update', 'param' => $myVariable], ['class' => 'glyphicon glyphicon-pencil']);
        //         },
        //         'delete' => function ($url, $model, $key) use($myVariable) {
        //             return Html::a('', ['delete', 'param' => $myVariable], ['class' => 'glyphicon glyphicon-cancel']);
        //         }],
 
        ],
    ],
]);

?>  
</div>

