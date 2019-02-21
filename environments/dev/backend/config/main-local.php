<?php

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'q7vx5P3jzRpDgcGQYvAdGPZESVQkN8f4QZwPTR7UktaCkgkT',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
