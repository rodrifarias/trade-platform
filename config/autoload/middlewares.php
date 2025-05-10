<?php

declare(strict_types=1);

use App\Infra\Middleware\CorsMiddleware;

return [
    'http' => [
        CorsMiddleware::class,
    ],
];
