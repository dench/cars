<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
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

<div class="container-fluid page-container">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems[] = ['label' => false, 'url' => false, 'options' => ['class' => 'navbar-divider']];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '<i class="fa fa-sign-in"></i> ' . Yii::t('app', 'Войти'), 'url' => ['/user/default/login']];
        $menuItems[] = ['label' => '<i class="fa fa-user"></i> ' . Yii::t('app', 'Регистрация'), 'url' => ['/user/default/signup']];
    } else {
        $menuItems[] = ['label' => '<i class="fa fa-cogs"></i> ' . Yii::t('app', 'Панель управления'), 'url' => ['/admin/default/index']];
        $menuItems[] = '<li>'
            . Html::beginForm(['/user/default/logout'], 'post')
            . Html::submitButton(
                '<i class="fa fa-sign-out"></i> ' . Yii::t('app', 'Выйти'),
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
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
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
