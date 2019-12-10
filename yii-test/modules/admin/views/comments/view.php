<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->id;
\yii\web\YiiAsset::register($this);
?>
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
