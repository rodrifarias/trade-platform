<?php

declare(strict_types=1);

return [
    'enable' => true,
    'port' => 9500,
    'json_dir' => BASE_PATH . '/public',
    'html' => null,
    'url' => '/swagger',
    'auto_generate' => true,
    'scan' => [
        'paths' => [BASE_PATH . '/app'],
    ],
    'processors' => [
    ],
    'server' => [
        'http' => [
            'servers' => [
                [
                    'url' => 'http://127.0.0.1:9501',
                    'description' => 'Dev Server',
                ],
            ],
            'info' => [
                'title' => 'Trade Platform API',
                'description' => 'This is a sample API using OpenAPI 3.0 specification',
                'version' => '1.0.0',
            ],
        ],
    ],
];
