<?php
return [
    [
        'refresh_token' => 'refresh_token',
        'client_id' => 'testclient',
        'user_id' => 1,
        'expires' => date('Y-m-d H:i:s',time()+3600)
    ],
    [
        'refresh_token' => 'refresh_token_driver',
        'client_id' => 'testclient',
        'user_id' => 2,
        'expires' => date('Y-m-d H:i:s',time()+3600)
    ],
];
