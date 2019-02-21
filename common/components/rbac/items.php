<?php
return [
    'user' => [
        'type' => 1,
        'description' => 'Пользователь',
    ],
    'driver' => [
        'type' => 1,
        'description' => 'Водитель',
    ],
    'dispatcher' => [
        'type' => 1,
        'description' => 'Диспечер',
        'children' => [
            'user',
        ],
    ],
    'administrator' => [
        'type' => 1,
        'description' => 'Администратор',
        'children' => [
            'dispatcher',
        ],
    ],
];
