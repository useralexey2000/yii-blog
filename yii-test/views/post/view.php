<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">
    <h2><?= Html::encode($this->title) ?></h2>
    <p>created by: <?=$model->owner->username;?></p>
    <div class='post-content'>
        <?=$model->content;?>    
    </div>
    
    <?php if(!empty($model->comments)):?>
    <div class='post-comments'>
        <h4>Comments:</h4>
        <ul class="comment-list">
        <?php foreach($model->comments as $comment):?>
            <li>
                <header class="comment-header">
                    <span><?=$comment->user->username?></span>
                    <span><?=$comment->updated_at?></span>
                </header>
                <div class="comment-content">
                    <p><?=$comment->content?></p>
                </div>
            </li>
        <?php endforeach?>
        </ul>
    </div>
    <?php endif;?>

    <div class="comment-form">
    <?php $form = ActiveForm::begin([
        'action' => ['comment'],
        'options' => ['method' => 'post']
        ]);
        unset($comment->content);
    ?>
    <?= $form->field($comment, 'content')->textarea(['rows' => 6])->label('Add comment') ?>
    <?= $form->field($comment, 'post_id',['inputOptions' => ['value' => $model->id]])->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('add', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>


</div>
