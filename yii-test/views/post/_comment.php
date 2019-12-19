<?php 
use yii\helpers\Html;
?>

<hr>
<span><?= Html::encode($model->user->username)?></span>
<?=$model->content;?>
<span><?=Html::encode($model->updated_at);?></span>

