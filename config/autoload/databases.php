<?php

declare(strict_types=1);

use function Hyperf\Support\env;

return [
    'default' => [
        'driver' => env('DB_DRIVER'),
        'host' => env('DB_HOST'),
        'database' => env('DB_DATABASE'),
        'port' => env('DB_PORT'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'charset' => env('DB_CHARSET'),
        'collation' => env('DB_COLLATION'),
        'prefix' => env('DB_PREFIX'),
        'pool' => [
            'min_connections' => 5,
            'max_connections' => 50,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float) env('DB_MAX_IDLE_TIME', 60),
        ],
        'commands' => [
            'gen:model' => [
                'path' => 'app/Model',
                'force_casts' => true,
                'inheritance' => 'Model',
            ],
        ],
    ],
];
