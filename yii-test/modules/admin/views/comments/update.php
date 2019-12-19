<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

$this->title = 'Update comment: '.$model->id;
?>

<h3><?=Html::encode($this->title)?></h3>
<div class="comment-form">

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id') ?>
    <!-- <?= $form->field($model, 'content')->textArea() ?> -->
    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
        'editorOptions' => [
            'options' => ['rows' => 6],
            'preset' => 'basic',
            'language' => 'en',
            'label' => false,
        ],
    ])->label(false);
    ?>

    <?= $form->field($model, 'user_id') ?>
    <?= $form->field($model, 'post_id') ?>
    <?= $form->field($model, 'created_at')->textInput() ?>
    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>