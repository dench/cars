<aside class="main-sidebar">

    <section class="sidebar">

        <?= app\modules\admin\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => Yii::t('app', 'Пользователи'), 'icon' => 'fa fa-file-code-o', 'url' => ['/admin/user']],
                ],
            ]
        ) ?>

    </section>

</aside>
