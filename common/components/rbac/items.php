<?php
return [
    'crud' => [
        'type' => 2,
    ],
    'user' => [
        'type' => 1,
        'description' => 'User',
    ],
    'driver' => [
        'type' => 1,
        'description' => 'driver',
        'children' => [
            'user',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'admin',
        'children' => [
            'crud',
            'driver',
        ],
    ],
];
