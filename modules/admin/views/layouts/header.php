<?php
use yii\bootstrap\Nav;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">SD</span><span class="logo-lg">' . Yii::$app->name . '</span>', \yii\helpers\Url::to(['/admin/default/index']), ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <?php

            $menuItems[] = ['label' => '<i class="fa fa-home"></i> ' . Yii::t('app', 'Home'), 'encode' => false, 'url' => Yii::$app->homeUrl];
            $menuItems[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    '<i class="fa fa-sign-out"></i> ' . Yii::t('app', 'Log out'),
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>';

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => $menuItems,
            ]);

            ?>

        </div>
    </nav>
</header>
