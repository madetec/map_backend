<?php
return [
    [
        'status' => \uztelecom\entities\orders\Order::STATUS_ACTIVE,
        'from_lat' => 312.13,
        'from_lng' => 31.23,
        'from_address' => 'tashkent',
        'to_lat' => 322.13,
        'to_lng' => 41.23,
        'to_address' => 'samarkand',
        'created_at' => time(),
        'created_by' => 3,
        'completed_at' => null,
        'driver_id' => null,
    ],
    [
        'status' => \uztelecom\entities\orders\Order::STATUS_WAIT,
        'from_lat' => 312.13,
        'from_lng' => 31.23,
        'from_address' => 'tashkent',
        'to_lat' => 322.13,
        'to_lng' => 41.23,
        'to_address' => 'samarkand',
        'created_at' => time(),
        'created_by' => 3,
        'completed_at' => null,
        'driver_id' => 2,
    ],
];
