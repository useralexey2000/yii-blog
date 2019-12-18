<?php

use yii\helpers\Html;
use mihaildev\elfinder\ElFinder;

$this->title = 'manage-files';
?>
<div class="post-list">
<h3><?=Html::encode($this->title)?></h3>

<?= ElFinder::widget([
    'language' => 'en',
    'controller' => 'elfinder',
    'containerOptions'       => ['style'=>'height: 600px;'],
]);
?>
</div>

