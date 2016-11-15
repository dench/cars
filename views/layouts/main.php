<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\FontAwesomeAsset;
use app\widgets\Lang;
use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
FontAwesomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="page-container">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('/img/rad_icon.png', ['height' => '100%']),
        'brandUrl' => ['/'],
        'options' => [
            'class' => 'navbar-dark',
        ],
    ]);

    $menuItems[] = ['label' => '<i class="fa fa-info"></i> ' . Yii::t('app', 'About'), 'url' => ['/site/about']];
    $menuItems[] = ['label' => '<i class="fa fa-star"></i> ' . Yii::t('app', 'Leaderboards'), 'url' => ['/site/leaderboards']];
    $menuItems[] = ['label' => '<i class="fa fa-comments"></i> ' . Yii::t('app', 'Blog'), 'url' => ['/blog/index']];
    $menuItems[] = ['label' => '<i class="fa fa-question"></i> ' . Yii::t('app', 'FAQ'), 'url' => ['/site/faq']];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);

    $menuItems = [];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '<i class="fa fa-sign-in"></i> ' . Yii::t('app', 'Log in'), 'url' => ['/user/login']];
        $menuItems[] = ['label' => '<i class="fa fa-user"></i> ' . Yii::t('app', 'Sign up'), 'url' => ['/user/signup']];
    } else {
        $menuItems[] = ['label' => '<i class="fa fa-user"></i> ' . Yii::t('app', 'Personal'), 'url' => ['/personal/default/index']];
        $menuItems[] = ['label' => '<i class="fa fa-cogs"></i> ' . Yii::t('app', 'Control'), 'url' => ['/admin/default/index']];
        $menuItems[] = '<li class="nav-item">'
            . Html::beginForm(['/user/logout'], 'post')
            . Html::submitButton(
                '<i class="fa fa-sign-out"></i> ' . Yii::t('app', 'Log out'),
                ['class' => 'nav-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav pull-sm-right'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <?php
    /*
    echo Carousel::widget([
        'showIndicators' => false,
        'controls' => ['<img src="/img/carousel-control-prev.png" alt="Prev" class="icon-prev">','<img src="/img/carousel-control-next.png" alt="Next" class="icon-next">'],
        'options' => ['class' => 'carousel-home'],
        'items' => [
            [
                'content' => '<img src="/img/slider1.jpg"/>',
                'caption' => Html::a(Yii::t('app','Log in'), ['/user/login']) . ' | ' . Html::a(Yii::t('app','Sign up'), ['/user/signup']),
                'options' => [],
            ],
        ]
    ]);
    */
    ?>

    <div class="container container-content">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <?= Lang::widget(); ?>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
