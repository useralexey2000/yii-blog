<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use mihaildev\ckeditor\CKEditor;

$this->title = $model->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="post-view">
    <h2><?= Html::encode($this->title) ?></h2>
    <p>created by: <?=Html::encode($model->owner->username);?></p>
    <?= Html::img(Html::encode($model->image), ['alt' => 'empty title', 'class' => 'post-img']) ?>
    <div class='post-content'>
        <?=$model->content;?>    
    </div>

    <div class="comment-form">
    <h4>leave comment</h4>
    <?php $form = ActiveForm::begin([
        'action' => ['comment'],
        'options' => ['method' => 'post']
        ]);
        unset($comment->content);
    ?>
    <?= $form->field($comment, 'content')->widget(CKEditor::className(), [
        'editorOptions' => [
            'options' => ['rows' => 6],
            'preset' => 'basic',
            'language' => 'en',
            'label' => false,
        ],
    ])->label(false);
    ?>
    <?= $form->field($comment, 'post_id',['inputOptions' => ['value' => $model->id]])->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('add', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    </div>

    <!----------------------------------------------------------------------------------------------------------------->
    <div class='comments-container'>
        <h5>Comments:</h5>
        <ul>
            <?= $this->context->renderPartial('comments',['model' => $model]);?>
        </ul>
    </div>
</div>



