<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update user: '.$model->id;
?>
<div class="user-form">


<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password') ?>
    <?=$form->field($model, 'roles')->checkboxList([
    'author' => 'author', 
    'admin' => 'admin',
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>