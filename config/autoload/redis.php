<?php

declare(strict_types=1);

use function Hyperf\Support\env;

return [
    'default' => [
        'host' => env('REDIS_HOST'),
        'auth' => env('REDIS_AUTH'),
        'port' => (int) env('REDIS_PORT'),
        'db' => (int) env('REDIS_DB'),
        'pool' => [
            'min_connections' => 10,
            'max_connections' => 100,
            'connect_timeout' => 10.0,
            'wait_timeout' => 5.0,
            'heartbeat' => -1,
            'max_idle_time' => (float) env('REDIS_MAX_IDLE_TIME', 30),
        ],
    ],
];
