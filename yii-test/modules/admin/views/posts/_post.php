<?php use yii\helpers\Html;?>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-body">

            <h3><?= Html::a($model->title, ['/admin/manager/viewpost', 'id' => $model->id]) ?></h3>
            <hr>
            <div class="text-right">
                <span>
                    <?=$model->updated_at;?>
                </span>
            </div>
        </div>
    </div>
</div>
