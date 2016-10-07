<aside class="main-sidebar">

    <section class="sidebar">

        <?= app\modules\admin\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => Yii::t('app', 'Users'), 'icon' => 'fa fa-file-code-o', 'url' => ['/admin/user']],
                    ['label' => Yii::t('app', 'MQTT ACL'), 'icon' => 'fa fa-file-code-o', 'url' => ['/admin/mqtt-acl']],
                ],
            ]
        ) ?>

    </section>

</aside>
