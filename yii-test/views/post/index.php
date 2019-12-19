<?php

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = 'Posts';

?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="post-index">

    <?=ListView::widget([
        'dataProvider'=>$posts,
        'itemView'=>'_post',
        'layout'=>'
        <div class="row">{items}</div>
        <div class="text-center">{pager}</div>',
    ]);
    ?>
   

</div>
