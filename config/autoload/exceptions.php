<?php

declare(strict_types=1);

use App\Infra\Exception\Handler\AppExceptionHandler;

return [
    'handler' => [
        'http' => [
            AppExceptionHandler::class,
        ],
    ],
];
