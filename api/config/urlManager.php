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
        'GET profile' => 'user/profile/index',
        'POST oauth2/<action:\w+>' => 'oauth2/rest/<action>',
    ]
];