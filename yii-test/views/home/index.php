<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'manage-posts';
?>
<div class="post-list">
<h3><?=Html::encode($this->title)?></h3>
<?=Html::a('Create post', ['post/create',],['class'=>'btn btn-primary'],)?>
<?php 

echo GridView::widget([
    'dataProvider' => $posts,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'Title',
            'attribute' =>'title',
        ],
        [
            'label' => 'Created at',
            'attribute' =>'created_at',
        ],
        [
            'label' => 'updated at',
            'attribute' =>'updated_at',
        ],
        [   
            'header' => 'Action',
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'post',
        ],
    ],
]);
?>  

</div>

