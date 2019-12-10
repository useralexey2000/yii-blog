<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->username;?>

<div class="user-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'password',
            [
                'attribute' => 'roles',
                'value' => function ($model) {
                    return implode(",", $model->roles);
                },
            ],
        ],
    ]) ?>
</div>
