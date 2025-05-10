<?php

declare(strict_types=1);

use Hyperf\Watcher\Driver\FindNewerDriver;

return [
    'driver' => FindNewerDriver::class,
    'bin' => 'php',
    'watch' => [
        'dir' => ['app', 'config'],
        'file' => ['.env'],
        'scan_interval' => 2000,
    ],
];
