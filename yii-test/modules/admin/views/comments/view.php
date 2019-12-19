<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\web\YiiAsset;
/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->id;
YiiAsset::register($this);
?>
<h3><?=Html::encode($this->title)?></h3>

<div class="commetns-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'content:ntext',
            'user_id',
            'post_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
