<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'telecom-car-app-backend',
    'aliases' => [
        '@staticRoot' => $params['staticPath'],
        '@static'   => $params['staticHostInfo'],
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\auth\Identity',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['auth/sign-in'],
        ],
        'session' => [
            'name' => 'telecom-car-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
            ],
        ],
    ],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'except' => ['auth/sign-in', 'auth/sign-up', 'site/error', 'auth/sign-out'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['dispatcher', 'administrator']
            ]
        ],
    ],
    'params' => $params,
];
