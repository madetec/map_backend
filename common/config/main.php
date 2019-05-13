<?php
return [
    'name' => 'Telecom Car',
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'firebase' => [
            'class' => 'understeam\fcm\Client',
            'apiKey' => 'AAAAeBjY4rQ:APA91bEzg1-zcVNrXoD2FJRNMjBvPzAYdwX1s6sgFCXHw0HuY_ZzxDGlehAYJwbY_LvdbOwrteM7OgdW7FXRdllNCghs3bArNlLsF5Ld2pYGcWMcvQJWzdvodTx5ML0XzD02P6QjTifB',
        ],
        'notification' => [
            'class' => 'uztelecom\components\notification\NotificationComponent'
        ],
        'authManager' => [
            'class' => 'common\components\AuthManager',
            'itemFile' => '@common/components/rbac/items.php',
            'assignmentFile' => '@common/components/rbac/assignments.php',
            'ruleFile' => '@common/components/rbac/rules.php'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
