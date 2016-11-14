<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\PersonalAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

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

<div class="container-fluid page-container">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('app', 'Personal'),
        'brandUrl' => Url::to(['/personal/default/index']),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems[] = ['label' => false, 'url' => false, 'options' => ['class' => 'navbar-divider']];

    $menuItems[] = ['label' => '<i class="fa fa-cogs"></i> ' . Yii::t('app', 'Timeline'), 'url' => ['/personal/timeline/index']];
    $menuItems[] = ['label' => '<i class="fa fa-cogs"></i> ' . Yii::t('app', 'Home'), 'url' => ['/site/index']];
    $menuItems[] = ['label' => '<i class="fa fa-cogs"></i> ' . Yii::t('app', 'Control'), 'url' => ['/admin/default/index']];
    $menuItems[] = '<li>'
        . Html::beginForm(['/user/logout'], 'post')
        . Html::submitButton(
            '<i class="fa fa-sign-out"></i> ' . Yii::t('app', 'Log out'),
            ['class' => 'btn btn-link']
        )
        . Html::endForm()
        . '</li>';

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
