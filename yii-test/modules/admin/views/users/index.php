
<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'manage-users';
?>
<div class="user-list">
<h3><?=Html::encode($this->title)?></h3>

<?php 

echo GridView::widget([
    'dataProvider' => $users,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'ID',
            'attribute' =>'id',
        ],
        [
            'label' => 'Username',
            'attribute' =>'username',
        ],
        [   
            'header' => 'Action',
            'class' => 'yii\grid\ActionColumn',
        ],

    ],
]);

?>  

</div>

