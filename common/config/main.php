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
            'apiKey' => 'AAAAeBjY4rQ:APA91bG7gxX_Th-x0JiBQ-muLRdCGjdm4SoUOjrJvu7lbWAFrdhvtP_MOH_cC0PCOf0qZTTxqDU3ilCQKqPFANGP0m4qCFhagxgKClUEMHvmWm2RltJhllhfN0LbTKUO777PKC4IeN-k',
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
