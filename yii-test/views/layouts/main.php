<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this)
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'blog',//Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
    $menuItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Posts','url' => '/posts',]
    ];
    if (!Yii::$app->user->isGuest) {
        if (\Yii::$app->authManager-> getAssignment('admin', Yii::$app->user->getId())){
            $menuItems[] = [
                'label' => 'Admin-panel',
                'items' => [
                    ['label' => 'manage-users', 'url' => Url::to(['/admin/users']),],
                    '<li class="divider"></li>',
                    ['label' => 'manage-posts', 'url' => Url::to(['/admin/posts']),],
                    '<li class="divider"></li>',
                    ['label' => 'manage-files', 'url' => Url::to(['/admin/files']),],
                ],
            ];
        }else{
            $menuItems[0] = ['label' => 'Home', 'url' => Url::to(['home/index']),];
        }
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => '/site/logout',
            'linkOptions' => ['data-method' => 'post']
        ];
    }else{
        $menuItems[] = [
            'label' => 'Login', 'url' => Url::to(['site/login']),
        ];
        $menuItems[] = [
            'label' => 'Signup', 'url' => Url::to(['site/signup']),
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]); 

    NavBar::end();
    ?>
    <div class="container">
        <?= $content ?>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>