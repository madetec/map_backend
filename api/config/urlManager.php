<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

return [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
        'GET user/profile' => 'user/profile/index',
        'PATCH user/profile/address' => 'user/profile/add-address',
        'GET user/<_a:(role|roles)>' => 'user/profile/<_a>',
        'POST oauth2/<action:\w+>' => 'oauth2/rest/<action>',
        'PATCH driver/status/<_a:\w+>' => 'driver/profile/<_a>',

        'GET user/order' => 'user/order/index',
        'GET user/order/<id:\d+>' => 'user/order/view',
        'POST user/order' => 'user/order/create',
        'PATCH user/order/<order_id:\d+>/cancel' => 'user/order/cancel',
        'GET user/order/active' => 'user/order/active',

        'GET driver/order/<id:\d+>' => 'driver/order/view',
        'PATCH driver/order/<order_id:\d+>/cancel' => 'driver/order/cancel',
        'PATCH driver/order/<order_id:\d+>/take' => 'driver/order/take',
        'PATCH driver/order/<order_id:\d+>/completed' => 'driver/order/completed',
        'PATCH driver/order/<order_id:\d+>/waiting' => 'driver/order/is-waiting',
        'PATCH driver/order/<order_id:\d+>/started' => 'driver/order/started',

        'POST device/add' => 'common/device/add',
        'GET device/remove/<uid:[\w-_]+>' => 'common/device/remove',
        'GET notifications' => 'common/notification/index',
        'GET subdivisions' => 'common/subdivision/index',
    ]
];
