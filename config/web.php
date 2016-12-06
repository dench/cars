<?php

$config = [
    'id' => 'app',
    'defaultRoute' => 'site/index',
    'components' => [
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
        'request' => [
            'class' => 'app\components\LangRequest'
        ],
        'urlManager' => [
            'class' => 'app\components\LangUrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix'=>'/',
            'rules' => [
                '' => 'site/index',
                '<action:(about|leaderboards|faq|lang)>' => 'site/<action>',
                '<action:(login|signup)>' => 'user/<action>',
                'admin' => 'admin/default/index',
                'personal' => 'personal/default/index',
                '<controller:timeline|game>' => '<controller>/index',
                'blog' => 'blog/index',
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'panels' => [
            'httpclient' => [
                'class' => 'yii\httpclient\debug\HttpClientPanel',
            ],
        ],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
