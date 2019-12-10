<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'user_id',
            [
                'label' => 'Comments',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a('comments', [
                        'comments', 'id' => $data->id,]);
                },
            ],
            'content:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
