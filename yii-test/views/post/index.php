<?php
/*@var $posts yii\data\ActiveDataProvider*/

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=ListView::widget([
        'dataProvider'=>$posts,
        'itemView'=>'_post',
        'layout'=>'
        <div class="row">{items}</div>
        <div class="text-center">{pager}</div>',
    ]);
    ?>
   

</div>
