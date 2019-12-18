<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mihaildev\elfinder\ElFinder;

$this->title = 'manage-posts';
?>
<div class="post-list">
<h3><?=Html::encode($this->title)?></h3>

<?php 

echo GridView::widget([
    'dataProvider' => $posts,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'ID',
            'attribute' =>'id',
        ],
        [
            'label' => 'Title',
            'attribute' =>'title',
        ],
        [
            'label' => 'Created at',
            'attribute' =>'created_at',
        ],
        [   
            'label' => 'Author',
            'value' => function ($data) {
               return $data->owner->username;
            },
        ],
        [   
            'header' => 'Action',
            'class' => 'yii\grid\ActionColumn',
            
        ],
    ],
]);

?>  

</div>

