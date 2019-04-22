<?php
$config =  [
    'components' => [
        'request' => [
            'cookieValidationKey' => '6gzybhetJhQBEj45tEDLcm2n5hnZaCNb3dfTC3rqMmsBEFez',
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
