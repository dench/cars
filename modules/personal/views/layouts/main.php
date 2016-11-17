<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\assets\FontAwesomeAsset;
use app\assets\PersonalAsset;
use app\widgets\Lang;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

FontAwesomeAsset::register($this);
AppAsset::register($this);
PersonalAsset::register($this);
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
        'brandLabel' => Html::img('/img/rad_icon.png', ['height' => '100%']) . '</a><a href="'.Url::to(['/personal/default/index']).'" class="navbar-brand">' . Yii::t('app', 'Personal'),
        'brandUrl' => ['/'],
        'options' => [
            'class' => 'navbar-dark',
        ],
    ]);

    $menuItems[] = '<li class="nav-item nav-personal">'
        . Html::a(Html::img('/img/userpic.png') . Yii::$app->user->identity->username, ['/personal/default/index'])
        . '</li>';

    $menuItems[] = ['label' => '<i class="fa fa-cogs"></i> ' . Yii::t('app', 'Timeline'), 'url' => ['/personal/timeline/index']];
    $menuItems[] = ['label' => '<i class="fa fa-cogs"></i> ' . Yii::t('app', 'Home'), 'url' => ['/site/index']];
    $menuItems[] = ['label' => '<i class="fa fa-cogs"></i> ' . Yii::t('app', 'Control'), 'url' => ['/admin/default/index']];

    $menuItems[] = '<li class="nav-item">'
        . Html::beginForm(['/user/logout'], 'post')
        . Html::submitButton(
            '<i class="fa fa-sign-out"></i> ' . Yii::t('app', 'Log out'),
            ['class' => 'nav-link']
        )
        . Html::endForm()
        . '</li>';

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav pull-sm-right'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    NavBar::end();
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
