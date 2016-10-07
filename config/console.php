<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests/codeception');

return [
    'id' => 'app-console',
    'bootstrap' => ['gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
];
