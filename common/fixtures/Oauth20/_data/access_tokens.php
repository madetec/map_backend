<?php
return [
    [
        'access_token' => 'token-correct',
        'client_id' => 'testclient',
        'user_id' => 1,
        'expires' => date('Y-m-d H:i:s',time()+3600)
    ],
    [
        'access_token' => 'token-correct-dispatcher',
        'client_id' => 'testclient',
        'user_id' => 2,
        'expires' => date('Y-m-d H:i:s',time()+3600)
    ],
    [
        'access_token' => 'token-correct-driver',
        'client_id' => 'testclient',
        'user_id' => 3,
        'expires' => date('Y-m-d H:i:s', time() + 3600)
    ],
    [
        'access_token' => 'token-correct-user',
        'client_id' => 'testclient',
        'user_id' => 4,
        'expires' => date('Y-m-d H:i:s', time() + 3600)
    ],
];
