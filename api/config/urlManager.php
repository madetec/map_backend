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
        'GET user/role' => 'user/profile/role',
        'GET user/roles' => 'user/profile/roles',
        'POST oauth2/<action:\w+>' => 'oauth2/rest/<action>',
    ]
];