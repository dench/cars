<aside class="main-sidebar">

    <section class="sidebar">

        <?= app\modules\admin\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => Yii::t('app', 'Users'), 'icon' => 'fa fa-file-code-o', 'url' => ['/admin/user']],
                    ['label' => Yii::t('app', 'MQTT Users'), 'icon' => 'fa fa-file-code-o', 'url' => ['/admin/mqtt-user']],
                    ['label' => Yii::t('app', 'MQTT ACLs'), 'icon' => 'fa fa-file-code-o', 'url' => ['/admin/mqtt-acl']],
                    ['label' => Yii::t('app', 'Robots'), 'icon' => 'fa fa-file-code-o', 'url' => ['/admin/robot']],
                    ['label' => Yii::t('app', 'Zones'), 'icon' => 'fa fa-file-code-o', 'url' => ['/admin/zone']],
                    ['label' => Yii::t('app', 'Timeline'), 'icon' => 'fa fa-file-code-o', 'url' => ['/admin/timeline']],
                    ['label' => Yii::t('app', 'Page'), 'icon' => 'fa fa-file-code-o', 'url' => ['/admin/page']],
                ],
            ]
        ) ?>

    </section>

</aside>
